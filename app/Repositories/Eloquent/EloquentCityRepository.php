<?php

namespace App\Repositories\Eloquent;

use App\Models\City;
use App\Repositories\Contracts\CityRepository;
use App\Traits\WeatherTrait;

class EloquentCityRepository implements CityRepository
{

    private $city;
    use WeatherTrait;

    public function __construct(City $city)
    {
        $this->city = $city;
    }

    public function save(array $data)
    {
        $c_data = [];
        $c_data['name'] = $data['name'];

        $cityDetails = $this->getCityDetails($data['name']);
        if(!count($cityDetails)){
            throw new \Exception('No Data found');
        }
        $c_data['lat'] = $cityDetails[0]['lat'];
        $c_data['lon'] = $cityDetails[0]['lon'];
        $c_data['country'] = $cityDetails[0]['country'];
        $c_data['state'] = $cityDetails[0]['state'];

        $city = $this->city->create($c_data);

        return $city;
    }

    public function getWeatherData(array $data)
    {
        $cityName = $data['name'] ?? '';

        $cityDetails = $this->city->when($cityName, function ($query, $cityName) {
            $query->where('name', $cityName);
        })->get();

        foreach ($cityDetails as $cityDetail) {
            $weatherDetails = $this->getCityWeatherDetails($cityDetail->lat, $cityDetail->lon);
            $cityDetail->weatherDetail = $weatherDetails;
        }
        return $cityDetails;
    }
}
