<?php
namespace App\Traits;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use PhpParser\ErrorHandler\Throwing;
use Throwable;

trait WeatherTrait
{

/**
    * Proxy a request to the OAuth server.
    *
    * @param string $grantType what type of grant type should be proxied
    * @param array $data the data to send to the server
    */
    public function proxy($grantType, array $data = [])
    {
        try {
            $data = array_merge($data, [
                'client_id'     => env('PASSPORT_CLIENT_ID'),
                'client_secret' => env('PASSPORT_CLIENT_SECRET'),
                'grant_type'    => $grantType,
                'scope'         => ''
            ]);

            $client = new \GuzzleHttp\Client();
            $result = $client->request('POST', url('oauth/token'), [
                'form_params' => $data
            ]);

            $data = json_decode((string) $result->getBody(), true);
            return $data;
        } catch (\Exception $e) {
            throw new \Exception('Division by zero.');
        }
    }

    public function getCityDetails($cityName){

        try {
            $data = [
                'appid'     => env('OPEN_WEATHER_API_KEY'),
                'q'         => $cityName,
                'limit'     => 1
            ];

            $client = new \GuzzleHttp\Client();
            $result = $client->request('GET', url('http://api.openweathermap.org/geo/1.0/direct'), [
                'query' => $data
            ]);

            $data = json_decode((string) $result->getBody(), true);

            return $data;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

    public function getCityWeatherDetails($lat, $lon){

        try {
            $data = [
                'appid'     => env('OPEN_WEATHER_API_KEY'),
                'lat'         => $lat,
                'lon'         => $lon
            ];

            $client = new \GuzzleHttp\Client();
            $result = $client->request('GET', url('http://api.openweathermap.org/data/2.5/forecast'), [
                'query' => $data
            ]);

            $data = json_decode((string) $result->getBody(), true);

            return $data['list'] ?? [];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }
}
?>
