# Rally Congress

A PHP package for working w/ the Rally Congress API.

## Install

Normal install via Composer.

## Usage

```php
use Travis\RallyCongress;

// credentials
$username = 'myusername';
$authtoken = '123456789';

// campaign info
$campaign_id = '123456789';
$action = 'letter';

// contact info
$contact = [
    'prefix' => 'Other', // required field
    'firstname' => 'Paul',
    'lastname' => 'Tarsus',
    'street' => '777 Pearl Gates',
    'city' => 'Washington',
    'state' => 'DC',
    'zipcode' => '20002',
    'phone' => '2025555555',
    'email' => 'paul.tarsus@gmail.com',
    'subject' => 'Test',
    'message' => 'Hello world!',
    'mode' => 'no_delivery', // for testing purposes
];

// submit
$response = RallyCongress::run($username, $authtoken, 'post', 'campaigns/'.$campaign_id.'/'.$action, $contact);
```

See the [documentation](https://www.rallycongress.com/docs/api) for more information.

## Errors

The library will throw an exception on any response code other than 200, 201, or 202.