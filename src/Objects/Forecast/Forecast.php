<?php

declare(strict_types=1);

namespace GrigoryGerasimov\Weather\Objects\Forecast;

use GrigoryGerasimov\Weather\Contracts\WeatherCollection\WeatherForecastInterface;
use GrigoryGerasimov\Weather\Contracts\WeatherObjectInterface;
use Illuminate\Support\Collection;

final readonly class Forecast implements WeatherObjectInterface, WeatherForecastInterface
{
    /**
     * @param \stdClass $forecastItem
     */
    public function __construct(
        private \stdClass $forecastItem
    ) {}

    /**
     * @return null|string
     */
    public function getDateOfDay(): ?string
    {
        return $this->forecastItem->date ?? null;
    }

    /**
     * @return null|int
     */
    public function getEpochOfDay(): ?int
    {
        return $this->forecastItem->date_epoch ?? null;
    }

    /**
     * @return ForecastCommon|null
     */
    public function common(): ?ForecastCommon
    {
        return isset($this->forecastItem->date) && isset($this->forecastItem->date_epoch) ? new ForecastCommon($this->forecastItem) : null;
    }

    /**
     * @return ForecastDay|null
     */
    public function day(): ?ForecastDay
    {
        return isset($this->forecastItem->day) ? new ForecastDay($this->forecastItem) : null;
    }

    /**
     * @return ForecastAstro|null
     */
    public function astro(): ?ForecastAstro
    {
        return isset($this->forecastItem->astro) ? new ForecastAstro($this->forecastItem) : null;
    }

    /**
     * @return Collection<ForecastHour>|null
     */
    public function hour(): ?Collection
    {
        $collection['forecast_hours'] = [];

        foreach($this->forecastItem->hour as $forecastHour) {
            if (!isset($forecastHour)) {
                return null;
            }

            $collection['forecast_hours'][] =  new ForecastHour($forecastHour);
        }

        return collect($collection['forecast_hours']);
    }
}