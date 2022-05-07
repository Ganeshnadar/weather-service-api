<?php

namespace App\Repositories\Contracts;

interface CityRepository extends BaseRepository
{
    public function getWeatherData(array $data);
}
