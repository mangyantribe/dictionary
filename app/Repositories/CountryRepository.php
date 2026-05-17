<?php

namespace App\Repositories;
use App\Models\Country;
use App\Interfaces\CountryInterface;
class CountryRepository implements CountryInterface
{
    public function saveCountry($data)
    {
        return Country::updateOrCreate(['name' => $data['name']],$data);
    }
}
