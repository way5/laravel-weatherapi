# Laravel-Weather Package
Laravel package for weather and geo info based on WeatherAPI

> [!IMPORTANT] 
> Laravel-Weather supports `JSON RestAPI only`.

## Installation
The package can be installed via Composer:

`composer require grigorygerasimov/laravel-weather`

You don't need to register the package Service Provider - this will be done automatically once you install the package.

For publishing the package config please run the following command. There are also some example views and the package docs under the same tag.

`php artisan vendor:publish --tag=laravel-weather`

## Start

Once the package is installed and the config is published, you are free to use the package in your Laravel projects.

### Weather API

The available Weather facade methods are:

```php
api(string $type = 'current')
coords(float|string $lat, float|string $lon)
city(string $city)
zip(string $zipCode)
metar(string $metarCode)
iata(string $iataCode)
autoIp()
ip(string $ip)
forecastDays(int $days = 1)
historyFutureDate(string $date)
historyDate(string $date)
forecastHistoryTimestamp(string|int $timestamp)
historyTimestamp(string|int $timestamp)
forecastHistoryHour(int $hour)
requireAlerts(bool $shouldAlert = false)
requireAQI(bool $ifAqi = false)
requireTides(bool $ifTides = false)
withInterval()
lang(string $langCode)
get()
uri()
```

The facade method *get()* will provide you with the result of your request, however you can also access the request uri directly via the *uri()* method.

In the following example we request weather data in `Prague` for the next `3 days`, including weather alerts, air quality data and available tide data.

```php

use GrigoryGerasimov\Weather\Facades\Weather;

$data = Weather::api('forecast')->city('Prague')->forecastDays(3)->requireAQI(true)->requireAlerts(true)->requireTides(true)->lang('cs')->get();

foreach($data->forecast() as $day) {
    // by day, ex.:
    $day->astro()->getCommonAstronomyParams()->...
    
    foreach($day->hour() as $hour) {
        // by hour
    }
}

```

- The `api()` method is mandatory, as it configures the relevant api method and api key.
- The `city()` method takes `US Zipcode`, `UK Postcode`, `Canada Postalcode`, `IP address`, `Latitude/Longitude` (decimal degree) or `Region, City, Country` string. 
- The `lang()` method accepts two letter country code (`ISO-639`), ex.: `ar`,`ca`,`pt`,`ru`,`us`,`zh`, etc...

> [!NOTE] 
> See [request parameters](https://www.weatherapi.com/docs/#intro-request) section to learn more.

By default the WeatherAPI Free plan key is used, however you can always adjust it in the [laravel-weather config](https://github.com/GrigoryGerasimov/laravel-weather/blob/main/config/weather.php), if you have your own WeatherAPI key.

As for the api methods, the following ones are available.
```php
current()    // Current weather or realtime weather API method allows a user to get up to date current weather information in json and xml. The data is returned as a Current Object.
forecast()   // Forecast weather API method returns, depending upon your price plan level, upto next 14 day weather forecast and weather alert as json or xml. The data is returned as a Forecast Object.
history()    // History weather API method returns historical weather for a date on or after 1st Jan, 2010 as json. The data is returned as a Forecast Object.
marine()    // Marine weather API method returns upto next 7 day (depending upon your price plan level) marine and sailing weather forecast and tide data (depending upon your price plan level) as json or xml. The data is returned as a Marine Object.
future()    // Future weather API method returns weather in a 3 hourly interval in future for a date between 14 days and 365 days from today in the future.
timezone()  // Return Location Object
astronomy() // Return Location and Astronomy Object
ip()        // IP Lookup API method allows a user to get up to date information for an IP address.
search()    // WeatherAPI.com Search or Autocomplete API returns matching cities and towns as an array of Location object.
```

By default, the *current* method is used. Please note that the default WeatherAPI Free plan key is limited for the *history* method.

### Sports API

```php

use GrigoryGerasimov\Weather\Facades\Weather;

$data = Weather::api('sports')->city('London')->autoIp()->requireAQI(true)->requireTides(true)->get();

$data->sports()    // {"football":[],"cricket":[],"golf":[]}

```

For demonstration purpose, the package also includes a number of components and views to the basic Weather api methods. These views are some very simple data lists without any particular styling, they serve merely for the visual representation of the weather and geo info retrieved with the help of this package. You can check them out under the following [web-routes](https://github.com/GrigoryGerasimov/laravel-weather/blob/main/routes/web.php)

For further details, you can also check the weather [controller](https://github.com/GrigoryGerasimov/laravel-weather/blob/main/src/Http/Controllers/WeatherController.php) and [components](https://github.com/GrigoryGerasimov/laravel-weather/tree/main/views/weather/components)

![Screenshot 2023-06-18 at 11 25 36](https://github.com/GrigoryGerasimov/laravel-weather/assets/102112036/25b6ebc3-63e7-49e4-afc9-5194fb800846)
![Screenshot 2023-06-18 at 11 26 11](https://github.com/GrigoryGerasimov/laravel-weather/assets/102112036/84930ae1-53c4-4ed0-ba39-caee5737d1ee)
![Screenshot 2023-06-18 at 11 26 43](https://github.com/GrigoryGerasimov/laravel-weather/assets/102112036/f3338866-7e1b-408a-9fa5-b9ce12c262c3)
![Screenshot 2023-06-18 at 11 27 33](https://github.com/GrigoryGerasimov/laravel-weather/assets/102112036/20dc6213-6a98-4def-bfaf-ea1b039b8968)

## Documentation
For the detailed infos on the package structure and api, please refer to the [Laravel-Weather documentation](https://github.com/GrigoryGerasimov/laravel-weather/tree/main/docs) which is published into your public folder. While running the php artisan serve command, you can access the docs as follows:

`http://localhost:8000/vendor/laravel-weather/docs/index.html`

Please don't forget to refer to the [official WeatherAPI documentation](https://www.weatherapi.com/docs/) to get a better glimpse of the weather and geo data via a JSON RestAPI.

## License
The package is under MIT license, thus you are free to use it in your projects.

## Feedback
As I've never had any previous experience in creating packages, I would appreciate some feedback: whether the Laravel-Weather package is easy/hard to use, what can be improved etc.

Feel free to get in touch with me under **rehor.ger@gmail.com**
