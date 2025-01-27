<?php

declare(strict_types=1);

namespace GrigoryGerasimov\Weather\Services;

use GrigoryGerasimov\Weather\Exceptions\{
    FailedFetchDataException,
    InvalidApiTypeException,
    InvalidArgumentValueException,
    InvalidJsonResponseException,
    MissingApiFieldException,
    WeatherException
};
use GrigoryGerasimov\Weather\Models\Weather as WeatherModel;
use GrigoryGerasimov\Weather\Contracts\WeatherServiceInterface;

class WeatherService implements WeatherServiceInterface
{
    use WithExceptionHandler;

    private const API_METHOD_TYPES = [
        'current',
        'forecast',
        'search',
        'history',
        'marine',
        'future',
        'timezone',
        'sports',
        'astronomy',
        'ip'
    ];

    private const API_LANG_NAMES = [
        'ar', 'bn', 'bg',
        'zh','zh_tw','cs','da',
        'nl','fi','fr','de',
        'el','hi','hu','it',
        'ja','jv','ko','zh_cmn',
        'mr','pl','pt','pa',
        'ro','ru','sr','si',
        'sk','es','sv','ta',
        'te','tr','uk','ur',
        'vi','zh_wuu','zh_hsn','zh_yue',
        'zu',
    ];

    /**
     * @var string
     */
    private string $requestUri;

    public function __construct()
    {
        $this->requestUri = config('weather.base_url') ?? 'https://api.weatherapi.com/v1';
    }

    /**
     * Type of your request to the API which defines the appropriate API method
     *
     * You can find the list of the available types in the constant API_METHOD_TYPES
     * The default value is "current" which is used for current weather data requests
     * More details on various API method types can be found in the official WeatherAPI documentation
     *
     * @link https://www.weatherapi.com/docs/
     * @param string $type
     * @return $this
     * @throws WeatherException
     * @throws \Throwable
     */
    public function api(string $type = 'current'): self
    {
        $apiKey = config('weather.api_key') ?? '52bc4de23bad4639861233754230306';

        try {
            if (!in_array($type, self::API_METHOD_TYPES, true)) {
                throw new InvalidApiTypeException();
            }
            $this->requestUri = $this->requestUri . "/$type.json?key=$apiKey";
        } catch (InvalidApiTypeException $e) {
            $this->handleWeatherException($e);
        } catch (\Throwable $e) {
            $this->handleThrowable($e);
        }

        return $this;
    }

    /**
     * GPS coordinates in decimal degree (as latitude and longitude)
     *
     * @param float|string $lat
     * @param float|string $lon
     * @return $this
     * @throws WeatherException
     * @throws \Throwable
     */
    public function coords(float|string $lat, float|string $lon): self
    {
        try {
            if ($this->queryStructureValidated()) {
                $this->requestUri = $this->requestUri . "&q=$lat,$lon";
            }
        } catch (MissingApiFieldException $e) {
            $this->handleWeatherException($e);
        } catch (\Throwable $e) {
            $this->handleThrowable($e);
        }

        return $this;
    }

    /**
     * @param string $city
     * @return $this
     * @throws WeatherException
     * @throws \Throwable
     */
    public function city(string $city): self
    {
        try {
            if ($this->queryStructureValidated()) {
                $this->requestUri = $this->requestUri . "&q=". urlencode($city);
            }
        } catch (MissingApiFieldException $e) {
            $this->handleWeatherException($e);
        } catch (\Throwable $e) {
            $this->handleThrowable($e);
        }

        return $this;
    }

    /**
     * Here you are free to provide any US zip / UK post / Canada postal codes
     *
     * @param string $zipCode
     * @return $this
     * @throws WeatherException
     * @throws \Throwable
     */
    public function zip(string $zipCode): self
    {
        try {
            if ($this->queryStructureValidated()) {
                $this->requestUri = $this->requestUri . "&q=$zipCode";
            }
        } catch (MissingApiFieldException $e) {
            $this->handleWeatherException($e);
        } catch (\Throwable $e) {
            $this->handleThrowable($e);
        }

        return $this;
    }

    /**
     * The METAR code provides the direction of the wind relative to true north,
     * as well as the average wind speed expressed in knots
     *
     * @param string $metarCode
     * @return $this
     * @throws WeatherException
     * @throws \Throwable
     */
    public function metar(string $metarCode): self
    {
        try {
            if ($this->queryStructureValidated()) {
                $this->requestUri = $this->requestUri . "&q=metar:$metarCode";
            }
        } catch (MissingApiFieldException $e) {
            $this->handleWeatherException($e);
        } catch (\Throwable $e) {
            $this->handleThrowable($e);
        }

        return $this;
    }

    /**
     * An IATA airport code is a three-letter geocode designating many airports and metropolitan areas
     * around the world, defined by the International Air Transport Association (IATA)
     *
     * @param string $iataCode
     * @return $this
     * @throws WeatherException
     * @throws \Throwable
     */
    public function iata(string $iataCode): self
    {
        try {
            if ($this->queryStructureValidated()) {
                $this->requestUri = $this->requestUri . "&q=iata:$iataCode";
            }
        } catch (MissingApiFieldException $e) {
            $this->handleWeatherException($e);
        } catch (\Throwable $e) {
            $this->handleThrowable($e);
        }

        return $this;
    }

    /**
     * @return $this
     * @throws WeatherException
     * @throws \Throwable
     */
    public function autoIp(): self
    {
        try {
            if ($this->queryStructureValidated()) {
                $this->requestUri = $this->requestUri . "&q=auto:ip";
            }
        } catch (MissingApiFieldException $e) {
            $this->handleWeatherException($e);
        } catch (\Throwable $e) {
            $this->handleThrowable($e);
        }

        return $this;
    }

    /**
     * @param string $ip
     * @return $this
     * @throws WeatherException
     * @throws \Throwable
     */
    public function ip(string $ip): self
    {
        try {
            if ($this->queryStructureValidated()) {
                $this->requestUri = $this->requestUri . "&q=$ip";
            }
        } catch (MissingApiFieldException $e) {
            $this->handleWeatherException($e);
        } catch (\Throwable $e) {
            $this->handleThrowable($e);
        }

        return $this;
    }

    /**
     * Required only with forecast API method
     *
     * ForecastCommon days range: 1-14
     *
     * @param int $days
     * @return $this
     * @throws WeatherException
     * @throws \Throwable
     */
    public function forecastDays(int $days = 1): self
    {
        try {
            if ($days < 1 || $days > 14) {
                throw new InvalidArgumentValueException();
            }
            if ($this->queryStructureValidated()) {
                $this->requestUri = $this->requestUri . "&days=$days";
            }
        } catch (MissingApiFieldException | InvalidArgumentValueException $e) {
            $this->handleWeatherException($e);
        } catch (\Throwable $e) {
            $this->handleThrowable($e);
        }

        return $this;
    }

    /**
     * Required for History and Future API method, restricts date output for Forecast and History API method
     *
     * For history API 'dt' should be on or after 1st Jan, 2010 in yyyy-MM-dd format (i.e. dt=2010-01-01)
     * For forecast API 'dt' should be between today and next 14 day in yyyy-MM-dd format (i.e. dt=2010-01-01)
     * For future API 'dt' should be between 14 days and 300 days from today in the future in yyyy-MM-dd format (i.e. dt=2023-01-01)
     *
     * More details in the official WeatherAPI documentation
     *
     * @link https://www.weatherapi.com/docs/
     * @param string $date
     * @return $this
     * @throws WeatherException
     * @throws \Throwable
     */
    public function historyFutureDate(string $date): self
    {
        try {
            if ($this->queryStructureValidated()) {
                $this->requestUri = $this->requestUri . "&dt=$date";
            }
        } catch (MissingApiFieldException $e) {
            $this->handleWeatherException($e);
        } catch (\Throwable $e) {
            $this->handleThrowable($e);
        }

        return $this;
    }

    /**
     * Restrict date output for History API method
     *
     * For history API 'end_dt' should be on or after 1st Jan, 2010 in yyyy-MM-dd format (i.e. dt=2010-01-01),
     * 'end_dt' should be greater than 'dt' parameter and difference should not be more than 30 days between the two dates
     * For this query option, your API key should refer to only Pro plan and above
     *
     * More details in the official WeatherAPI documentation
     *
     * @link https://www.weatherapi.com/docs/
     * @param string $date
     * @return $this
     * @throws WeatherException
     * @throws \Throwable
     */
    public function historyDate(string $date): self
    {
        try {
            if ($this->queryStructureValidated()) {
                $this->requestUri = $this->requestUri . "&end_dt=$date";
            }
        } catch (MissingApiFieldException $e) {
            $this->handleWeatherException($e);
        } catch (\Throwable $e) {
            $this->handleThrowable($e);
        }

        return $this;
    }

    /**
     * Unix Timestamp used by Forecast and History API method
     *
     * unixdt has same restriction as 'dt' parameter
     * Please either pass 'dt' or 'unixdt' and not both in same request
     *
     * More details in the official WeatherAPI documentation
     *
     * @link https://www.weatherapi.com/docs/
     * @param string|int $timestamp
     * @return $this
     * @throws WeatherException
     * @throws \Throwable
     */
    public function forecastHistoryTimestamp(string|int $timestamp): self
    {
        try {
            if ($this->queryStructureValidated()) {
                $this->requestUri = $this->requestUri . "&unixdt=$timestamp";
            }
        } catch (MissingApiFieldException $e) {
            $this->handleWeatherException($e);
        } catch (\Throwable $e) {
            $this->handleThrowable($e);
        }

        return $this;
    }

    /**
     * Unix Timestamp used by History API method
     *
     * unixend_dt has same restriction as 'end_dt' parameter
     * Please either pass 'end_dt' or 'unixend_dt' and not both in same request
     *
     * More details in the official WeatherAPI documentation
     *
     * @link https://www.weatherapi.com/docs/
     * @param string|int $timestamp
     * @return $this
     * @throws WeatherException
     * @throws \Throwable
     */
    public function historyTimestamp(string|int $timestamp): self
    {
        try {
            if ($this->queryStructureValidated()) {
                $this->requestUri = $this->requestUri . "&unixend_dt=$timestamp";
            }
        } catch (MissingApiFieldException $e) {
            $this->handleWeatherException($e);
        } catch (\Throwable $e) {
            $this->handleThrowable($e);
        }

        return $this;
    }

    /**
     * Restricting forecast or history output to a specific hour in a given day
     *
     * Must be in 24 hour: for example 5 pm should be hour=17, 6 am as hour=6
     *
     * More details in the official WeatherAPI documentation
     *
     * @link https://www.weatherapi.com/docs/
     * @param int $hour
     * @return $this
     * @throws WeatherException
     * @throws \Throwable
     */
    public function forecastHistoryHour(int $hour): self
    {
        try {
            if ($hour < 0 || $hour > 24) {
                throw new InvalidArgumentValueException();
            }
            if ($this->queryStructureValidated()) {
                $this->requestUri = $this->requestUri . "&hour=$hour";
            }
        } catch (MissingApiFieldException | InvalidArgumentValueException $e) {
            $this->handleWeatherException($e);
        } catch (\Throwable $e) {
            $this->handleThrowable($e);
        }

        return $this;
    }

    /**
     * Should receive alerts in Forecast API output
     *
     * Further details to alerts can be found in the official WeatherAPI documentation
     *
     * @link https://www.weatherapi.com/docs/
     * @param bool $shouldAlert
     * @return $this
     * @throws WeatherException
     * @throws \Throwable
     */
    public function requireAlerts(bool $shouldAlert = false): self
    {
        try {
            $shouldAlert = $shouldAlert ? 'yes' : 'no';
            if ($this->queryStructureValidated()) {
                $this->requestUri = $this->requestUri . "&alerts=$shouldAlert";
            }
        } catch (MissingApiFieldException $e) {
            $this->handleWeatherException($e);
        } catch (\Throwable $e) {
            $this->handleThrowable($e);
        }

        return $this;
    }

    /**
     * Should receive the Air Quality data in Forecast API output
     *
     * Further details to AQI can be found in the official WeatherAPI documentation
     *
     * @link https://www.weatherapi.com/docs/
     * @param bool $ifAqi
     * @return $this
     * @throws WeatherException
     * @throws \Throwable
     */
    public function requireAQI(bool $ifAqi = false): self
    {
        try {
            $ifAqi = $ifAqi ? 'yes' : 'no';
            if ($this->queryStructureValidated()) {
                $this->requestUri = $this->requestUri . "&aqi=$ifAqi";
            }
        } catch (MissingApiFieldException $e) {
            $this->handleWeatherException($e);
        } catch (\Throwable $e) {
            $this->handleThrowable($e);
        }

        return $this;
    }

    /**
     * Should receive the Tide data in Marine API output
     *
     * @link https://www.weatherapi.com/docs/
     * @param bool $ifTides
     * @return $this
     * @throws WeatherException
     * @throws \Throwable
     */
    public function requireTides(bool $ifTides = false): self
    {
        try {
            $ifTides = $ifTides ? 'yes' : 'no';
            if ($this->queryStructureValidated()) {
                $this->requestUri = $this->requestUri . "&tides=$ifTides";
            }
        } catch (MissingApiFieldException $e) {
            $this->handleWeatherException($e);
        } catch (\Throwable $e) {
            $this->handleThrowable($e);
        }

        return $this;
    }

    /**
     * Get 15 min interval data for Forecast and History API
     *
     * Please note that this option is available for Enterprise plan only
     *
     * @link https://www.weatherapi.com/docs/
     * @return $this
     * @throws WeatherException
     * @throws \Throwable
     */
    public function withInterval(): self
    {
        try {
            if ($this->queryStructureValidated()) {
                $this->requestUri = $this->requestUri . "&tp=15";
            }
        } catch (MissingApiFieldException $e) {
            $this->handleWeatherException($e);
        } catch (\Throwable $e) {
            $this->handleThrowable($e);
        }

        return $this;
    }

    /**
     * Returns 'condition:text' field in API in the desired language
     *
     * For the precise lang codes list please refer to the official WeatherAPI documentation
     *
     * @link https://www.weatherapi.com/docs/
     * @param string $langCode
     * @return $this
     * @throws WeatherException
     * @throws \Throwable
     */
    public function lang(string $langCode): self
    {
        if(!in_array($langCode, self::API_LANG_NAMES, true)) {
            $this->handleThrowable(
                new InvalidArgumentValueException(
                    "language code [".$langCode."] doesn't exist, use: "
                        . implode(', ', self::API_LANG_NAMES)
                )
            );
        }

        try {
            if ($this->queryStructureValidated())  {
                $this->requestUri = $this->requestUri . "&lang=$langCode";
            }
        } catch (MissingApiFieldException $e) {
            $this->handleWeatherException($e);
        } catch (\Throwable $e) {
            $this->handleThrowable($e);
        }

        return $this;
    }

    /**
     * @return WeatherModel|null
     * @throws WeatherException
     * @throws \Throwable
     */
    public function get(): ?WeatherModel
    {
        try {
            if ($this->queryStructureValidated()) {
                $response = $this->getData();
            }
        } catch (MissingApiFieldException $e) {
            $this->handleWeatherException($e);
        } catch (\Throwable $e) {
            $this->handleThrowable($e);
        }

        return isset($response) ? new WeatherModel($response) : null;
    }

    /**
     * @return string
     */
    public function uri(): string
    {
        return $this->requestUri;
    }

    /**
     * @throws MissingApiFieldException
     */
    private function queryStructureValidated(): bool
    {
        if (!$this->isApiFieldPresent()) {
            throw new MissingApiFieldException();
        }

        return true;
    }

    /**
     * @return bool
     */
    private function isApiFieldPresent(): bool
    {
        return (bool)preg_match('/\/[a-zA-Z0-9]+\.json\?key=/', $this->requestUri);
    }

    private function isInvalidJsonResponse(bool|string $response): bool
    {
        return !$response || $response === '' || preg_match('/(<.+>)|(<\/.+>)/', $response);
    }

    /**
     * @return \stdClass|array
     * @throws WeatherException
     * @throws \Throwable
     */
    private function getData(): \stdClass|array
    {
        $curl = curl_init($this->requestUri);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        curl_close($curl);

        try {
            if ($this->isInvalidJsonResponse($response)) {
                throw new InvalidJsonResponseException();
            } elseif ($response === false) {
                throw new FailedFetchDataException();
            }
            $decodedResponse = json_decode($response, null, 512, JSON_THROW_ON_ERROR);
        } catch (InvalidJsonResponseException | FailedFetchDataException $e) {
            $this->handleWeatherException($e);
        } catch (\Throwable $e) {
            $this->handleThrowable($e);
        }

        return $decodedResponse;
    }
}