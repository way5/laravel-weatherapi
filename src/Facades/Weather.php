<?php

declare(strict_types=1);

namespace GrigoryGerasimov\Weather\Facades;

use GrigoryGerasimov\Weather\Contracts\WeatherServiceInterface;
use GrigoryGerasimov\Weather\Models\Weather as WeatherModel;
use Illuminate\Support\Facades\Facade;

/**
 * @method static self api(string $type = 'current')
 * @method self coords(float|string $lat, float|string $lon)
 * @method self city(string $city)
 * @method self zip(string $zipCode)
 * @method self metar(string $metarCode)
 * @method self iata(string $iataCode)
 * @method self autoIp()
 * @method self ip(string $ip)
 * @method self forecastDays(int $days = 1)
 * @method self historyFutureDate(string $date)
 * @method self historyDate(string $date)
 * @method self forecastHistoryTimestamp(string|int $timestamp)
 * @method self historyTimestamp(string|int $timestamp)
 * @method self forecastHistoryHour(int $hour)
 * @method self requireAlerts(bool $shouldAlert = false)
 * @method self requireAQI(bool $ifAqi = false)
 * @method self requireTides(bool $ifTides = false)
 * @method self withInterval()
 * @method self lang(string $langCode)
 * @method WeatherModel get()
 * @method string uri()
 */
class Weather extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return WeatherServiceInterface::class;
    }
}