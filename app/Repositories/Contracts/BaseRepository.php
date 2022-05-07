<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface BaseRepository
{
    /**
    * Save a resource
    *
    * @param array $data
    * @return Model
    */
    public function save(array $data);

}
