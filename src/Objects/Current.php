<?php

declare(strict_types=1);

namespace GrigoryGerasimov\Weather\Objects;

use GrigoryGerasimov\Weather\Contracts\{WeatherCommonInterface, WeatherObjectInterface};

final readonly class Current implements WeatherObjectInterface, WeatherCommonInterface
{
    /**
     * @var \stdClass
     */
    private \stdClass $current;

    /**
     * @param \stdClass $data
     */
    public function __construct(\stdClass $data)
    {
        $this->current = $data->current;
    }

    /**
     * @return string|null
     */
    public function getLastUpdated(): ?string
    {
        return $this->current->last_updated ?? null;
    }

    /**
     * @return int|null
     */
    public function getLastUpdatedTimestamp(): ?int
    {
        return $this->current->last_updated_epoch ?? null;
    }

    /**
     * @return float|null
     */
    public function getActualCelsius(): ?float
    {
        return $this->current->temp_c ?? null;
    }

    /**
     * @return float|null
     */
    public function getActualFahrenheit(): ?float
    {
        return $this->current->temp_f ?? null;
    }

    /**
     * @return float|null
     */
    public function getFeelsLikeCelsius(): ?float
    {
        return $this->current->feelslike_c ?? null;
    }

    /**
     * @return float|null
     */
    public function getFeelsLikeFahrenheit(): ?float
    {
        return $this->current->feelslike_f ?? null;
    }

    /**
     * @return Condition|null
     */
    public function getWeatherCondition(): ?Condition
    {
        return isset($this->current->condition) ? new Condition($this->current->condition) : null;
    }

    /**
     * @return float|null
     */
    public function getWindSpeedInMiles(): ?float
    {
        return $this->current->wind_mph ?? null;
    }

    /**
     * @return float|null
     */
    public function getWindSpeedInKm(): ?float
    {
        return $this->current->wind_kph ?? null;
    }

    /**
     * @return int|null
     */
    public function getWindDirectionInDegrees(): ?int
    {
        return $this->current->wind_degree ?? null;
    }

    /**
     * Wind direction as 16 point compass. e.g.: NSW.
     *
     * @return string|null
     */
    public function getWindDirectionInPoints(): ?string
    {
        return $this->current->wind_dir ?? null;
    }

    /**
     * @return float|null
     */
    public function getPressureInMillibars(): ?float
    {
        return $this->current->pressure_mb ?? null;
    }

    /**
     * @return float|null
     */
    public function getPressureInInches(): ?float
    {
        return $this->current->pressure_in ?? null;
    }

    /**
     * @return float|null
     */
    public function getPrecipitationInMm(): ?float
    {
        return $this->current->precip_mm ?? null;
    }

    /**
     * @return float|null
     */
    public function getPrecipitationInInches(): ?float
    {
        return $this->current->precip_in ?? null;
    }

    /**
     * @return int|null
     */
    public function getHumidity(): ?int
    {
        return $this->current->humidity ?? null;
    }

    /**
     * @return int|null
     */
    public function getCloudCover(): ?int
    {
        return $this->current->cloud ?? null;
    }

    /**
     * 1 = Yes (showing day condition icon)
     * 0 = No (showing night condition icon)
     *
     * @return int|null
     */
    public function getDayNightConditionIcon(): ?int
    {
        return $this->current->is_day ?? null;
    }

    /**
     * @return float|null
     */
    public function getUVIndex(): ?float
    {
        return $this->current->uv ?? null;
    }

    /**
     * @return float|null
     */
    public function getWindGustInMiles(): ?float
    {
        return $this->current->gust_mph ?? null;
    }

    /**
     * @return float|null
     */
    public function getWindGustInKm(): ?float
    {
        return $this->current->gust_kph ?? null;
    }

    /**
     * @return null|float
     */
    public function getWindChillInCelsius(): ?float
    {
        return $this->current->windchill_c ?? null;
    }

    /**
     * @return null|float
     */
    public function getWindChillInFahrenheit(): ?float
    {
        return $this->current->windchill_f ?? null;
    }

    /**
     * @return null|float
     */
    public function getHeatindexInCelsius(): ?float
    {
        return $this->current->heatindex_c ?? null;
    }

    /**
     * @return null|float
     */
    public function getHeatindexInFahrenheit(): ?float
    {
        return $this->current->heatindex_f ?? null;
    }

    /**
     * @return null|float
     */
    public function getDewPointInCelsius(): ?float
    {
        return $this->current->dewpoint_c ?? null;
    }

    /**
     * @return null|float
     */
    public function getDewPointInFahrenheit(): ?float
    {
        return $this->current->dewpoint_f ?? null;
    }

    /**
     * @return null|float
     */
    public function getVisibilityInKm(): ?int
    {
        return $this->current->vis_km ?? null;
    }

    /**
     * @return null|float
     */
    public function getVisibilityInMiles(): ?int
    {
        return $this->current->vis_miles ?? null;
    }
}