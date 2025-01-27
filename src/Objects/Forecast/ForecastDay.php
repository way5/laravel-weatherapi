<?php

declare(strict_types=1);

namespace GrigoryGerasimov\Weather\Objects\Forecast;

use GrigoryGerasimov\Weather\Objects\{AirQuality, Condition};
use GrigoryGerasimov\Weather\Contracts\WeatherObjectInterface;

final readonly class ForecastDay implements WeatherObjectInterface
{
    /**
     * @var \stdClass
     */
    private \stdClass $forecastDay;

    /**
     * @param \stdClass $forecast
     */
    public function __construct(\stdClass $forecast)
    {
        $this->forecastDay = $forecast->day;
    }

    /**
     * @return float|null
     */
    public function getMaxCelsius(): ?float
    {
        return $this->forecastDay->maxtemp_c ?? null;
    }

    /**
     * @return float|null
     */
    public function getMaxFahrenheit(): ?float
    {
        return $this->forecastDay->maxtemp_f ?? null;
    }

    /**
     * @return float|null
     */
    public function getMinCelsius(): ?float
    {
        return $this->forecastDay->mintemp_c ?? null;
    }

    /**
     * @return float|null
     */
    public function getMinFahrenheit(): ?float
    {
        return $this->forecastDay->mintemp_f ?? null;
    }

    /**
     * @return float|null
     */
    public function getAvgCelsius(): ?float
    {
        return $this->forecastDay->avgtemp_c ?? null;
    }

    /**
     * @return float|null
     */
    public function getAvgFahrenheit(): ?float
    {
        return $this->forecastDay->avgtemp_f ?? null;
    }

    /**
     * @return float|null
     */
    public function getMaxWindSpeedInMiles(): ?float
    {
        return $this->forecastDay->maxwind_mph ?? null;
    }

    /**
     * @return float|null
     */
    public function getMaxWindSpeedInKm(): ?float
    {
        return $this->forecastDay->maxwind_kph ?? null;
    }

    /**
     * @return float|null
     */
    public function getTotalPrecipitationInMm(): ?float
    {
        return $this->forecastDay->totalprecip_mm ?? null;
    }

    /**
     * @return float|null
     */
    public function getTotalPrecipitationInInches(): ?float
    {
        return $this->forecastDay->totalprecip_in ?? null;
    }

    /**
     * @return float|null
     */
    public function getAvgVisibilityInKm(): ?float
    {
        return $this->forecastDay->avgvis_km ?? null;
    }

    /**
     * @return float|null
     */
    public function getAvgVisibilityInMiles(): ?float
    {
        return $this->forecastDay->avgvis_miles ?? null;
    }

    /**
     * @return int|float|null
     */
    public function getAvgHumidity(): int|float|null
    {
        return $this->forecastDay->avghumidity ?? null;
    }

    /**
     * 1 = Yes (it will be rainy)
     * 0 = No (it won`t be rainy)
     *
     * @return null|int
     */
    public function shallItRain(): ?int
    {
        return $this->forecastDay->daily_will_it_rain ?? null;
    }

    /**
     * Th probability of rain in percents (0-100)
     * @return null|int
     */
    public function getChanceOfRain(): ?int
    {
        return $this->forecastDay->daily_chance_of_rain ?? null;
    }

    /**
     * 1 = Yes (it will be snowing)
     * 0 = No (it won`t be snowing)
     *
     * @return null|int
     */
    public function shallItSnow(): ?int
    {
        return $this->forecastDay->daily_will_it_snow ?? null;
    }

    /**
     * The probability of snowfall in percents (0-100)
     * @return null|int
     */
    public function getChanceOfSnowfall(): ?int
    {
        return $this->forecastDay->daily_chance_of_snow ?? null;
    }

    /**
     * @return Condition|null
     */
    public function getWeatherCondition(): ?Condition
    {
        return isset($this->forecastDay->condition) ? new Condition($this->forecastDay->condition) : null;
    }

    /**
     * @return float|null
     */
    public function getUVIndex(): ?float
    {
        return $this->forecastDay->uv ?? null;
    }

    /**
     * @return AirQuality|null
     */
    public function getAirQuality(): ?AirQuality
    {
        return isset($this->forecastDay->air_quality) ? new AirQuality($this->forecastDay) : null;
    }
}