<?php

declare(strict_types=1);

namespace GrigoryGerasimov\Weather\Objects\Forecast;

use GrigoryGerasimov\Weather\Objects\{AirQuality, Condition};
use GrigoryGerasimov\Weather\Contracts\{
    WeatherCommonInterface,
    WeatherObjectInterface
};

final readonly class ForecastHour implements WeatherObjectInterface, WeatherCommonInterface
{
    /**
     * @var \stdClass
     */
    private \stdClass $forecastHour;

    /**
     * @param \stdClass $forecast
     */
    public function __construct(\stdClass $forecast)
    {
        $this->forecastHour = $forecast;
    }

    /**
     * @return int|null
     */
    public function getTimestamp(): ?int
    {
        return $this->forecastHour->time_epoch ?? null;
    }

    /**
     * @return string|null
     */
    public function getDateTime(): ?string
    {
        return $this->forecastHour->time ?? null;
    }

    /**
     * @return float|null
     */
    public function getActualCelsius(): ?float
    {
        return $this->forecastHour->temp_c ?? null;
    }

    /**
     * @return float|null
     */
    public function getActualFahrenheit(): ?float
    {
        return $this->forecastHour->temp_f ?? null;
    }

    /**
     * @return Condition|null
     */
    public function getWeatherCondition(): ?Condition
    {
        return isset($this->forecastHour->condition) ? new Condition($this->forecastHour->condition) : null;
    }

    /**
     * @return float|null
     */
    public function getWindSpeedInMiles(): ?float
    {
        return $this->forecastHour->wind_mph ?? null;
    }

    /**
     * @return float|null
     */
    public function getWindSpeedInKm(): ?float
    {
        return $this->forecastHour->wind_kph ?? null;
    }

    /**
     * @return int|null
     */
    public function getWindDirectionInDegrees(): ?int
    {
        return $this->forecastHour->wind_degree ?? null;
    }

    /**
     * Wind direction as 16 point compass. e.g.: NSW
     *
     * @return string|null
     */
    public function getWindDirectionInPoints(): ?string
    {
        return $this->forecastHour->wind_dir ?? null;
    }

    /**
     * @return float|null
     */
    public function getPressureInMillibars(): ?float
    {
        return $this->forecastHour->pressure_mb ?? null;
    }

    /**
     * @return float|null
     */
    public function getPressureInInches(): ?float
    {
        return $this->forecastHour->pressure_in ?? null;
    }

    /**
     * @return float|null
     */
    public function getPrecipitationInMm(): ?float
    {
        return $this->forecastHour->precip_mm ?? null;
    }

    /**
     * @return float|null
     */
    public function getPrecipitationInInches(): ?float
    {
        return $this->forecastHour->precip_in ?? null;
    }

    /**
     * @return null|float
     */
    public function getSnowThicknessInCm(): ?float
    {
        return $this->forecastHour->snow_cm ?? null;
    }

    /**
     * @return int|null
     */
    public function getHumidity(): ?int
    {
        return $this->forecastHour->humidity ?? null;
    }

    /**
     * @return int|null
     */
    public function getCloudCover(): ?int
    {
        return $this->forecastHour->cloud ?? null;
    }

    /**
     * @return float|null
     */
    public function getFeelsLikeCelsius(): ?float
    {
        return $this->forecastHour->feelslike_c ?? null;
    }

    /**
     * @return float|null
     */
    public function getFeelsLikeFahrenheit(): ?float
    {
        return $this->forecastHour->feelslike_f ?? null;
    }

    /**
     * @return float|null
     */
    public function getWindchillInCelsius(): ?float
    {
        return $this->forecastHour->windchill_c ?? null;
    }

    /**
     * @return float|null
     */
    public function getWindchillInFahrenheit(): ?float
    {
        return $this->forecastHour->windchill_f ?? null;
    }

    /**
     * @return float|null
     */
    public function getHeatIndexInCelsius(): ?float
    {
        return $this->forecastHour->heatindex_c ?? null;
    }

    /**
     * @return float|null
     */
    public function getHeatIndexInFahrenheit(): ?float
    {
        return $this->forecastHour->heatindex_f ?? null;
    }

    /**
     * @return float|null
     */
    public function getDewPointInCelsius(): ?float
    {
        return $this->forecastHour->dewpoint_c ?? null;
    }

    /**
     * @return float|null
     */
    public function getDewPointInFahrenheit(): ?float
    {
        return $this->forecastHour->dewpoint_f ?? null;
    }

    /**
     * 1 = Yes (it will be raining)
     * 0 = No (it won`t be raining)
     *
     * @return int|null
     */
    public function shallItRain(): ?int
    {
        return $this->forecastHour->will_it_rain ?? null;
    }

    /**
     * 1 = Yes (it will be snowing)
     * 0 = No (it won`t be snowing)
     *
     * @return int|null
     */
    public function shallItSnow(): ?int
    {
        return $this->forecastHour->will_it_snow ?? null;
    }

    /**
     * 1 = Yes (showing day condition icon)
     * 0 = No (showing night condition icon)
     *
     * @return int|null
     */
    public function getDayNightConditionIcon(): ?int
    {
        return $this->forecastHour->is_day ?? null;
    }

    /**
     * @return float|null
     */
    public function getVisibilityInKm(): ?float
    {
        return $this->forecastHour->vis_km ?? null;
    }

    /**
     * @return float|null
     */
    public function getVisibilityInMiles(): ?float
    {
        return $this->forecastHour->vis_miles ?? null;
    }

    /**
     * The probability of rain in percents (0-100)
     * @return int|null
     */
    public function getChanceOfRain(): ?int
    {
        return $this->forecastHour->chance_of_rain ?? null;
    }

    /**
     * Th probability of snowfall in percents (0-100)
     * @return int|null
     */
    public function getChanceOfSnowfall(): ?int
    {
        return $this->forecastHour->chance_of_snow ?? null;
    }

    /**
     * @return float|null
     */
    public function getWindGustInMiles(): ?float
    {
        return $this->forecastHour->gust_mph ?? null;
    }

    /**
     * @return float|null
     */
    public function getWindGustInKm(): ?float
    {
        return $this->forecastHour->gust_kph ?? null;
    }

    /**
     * @return float|null
     */
    public function getUVIndex(): ?float
    {
        return $this->forecastHour->uv ?? null;
    }


    /**
     * Shortwave solar radiation or Global horizontal irradiation (GHI) W/m²
     * @return float|null
     */
    public function getSolarShortwaveRad(): ?float
    {
        return $this->forecastHour->short_rad ?? null;
    }


    /**
     * Diffuse Horizontal Irradiation (DHI) W/m²
     * @return float|null
     */
    public function getSolarDiffuseRad(): ?float
    {
        return $this->forecastHour->diff_rad ?? null;
    }

    /**
     * @return AirQuality|null
     */
    public function getAirQuality(): ?AirQuality
    {
        return isset($this->forecastHour->air_quality) ? new AirQuality($this->forecastHour) : null;
    }
}