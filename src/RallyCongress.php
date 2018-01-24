<?php

namespace Travis;

class RallyCongress
{
    public static function run($username, $authtoken, $method, $uri, $arguments = [], $page = 0)
    {
        // set endpoint
        $endpoint = 'https://api.rallycongress.net/v3/'.$uri;

        // make headers
        $headers = [
            'content-type:application/x-www-form-urlencoded',
        ];

        // make auth string
        $auth = $username.':'.$authtoken;

        // make payload
        $payload = http_build_query($arguments);

        // setup curl request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_USERPWD, $auth);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        if (strtoupper($method) === 'POST')
        {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        }
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // catch error...
        if (curl_errno($ch))
        {
            // report
            #$errors = curl_error($ch);

            // close
            curl_close($ch);

            // return false
            return false;
        }

        // close
        curl_close($ch);

        // decode response
        $response = json_decode($response);

        // catch error...
        if (!in_array($httpcode, [200, 201, 202]))
        {
            // throw error
            throw new \Exception(ex($response, 'response.errors.0', 'Request failed with HTTP code '.$httpcode));

            // return false
            return false;
        }

        // return
        return $response;
    }
}