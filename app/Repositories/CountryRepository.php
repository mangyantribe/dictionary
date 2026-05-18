<?php

namespace App\Repositories;
use App\Models\Country;
use App\Interfaces\CountryInterface;
class CountryRepository implements CountryInterface
{
    public function saveCountry($data)
    {
        return Country::updateOrCreate(['id' => $data['id']],$data);
    }

    public function getCounties()
    {
        return Country::orderBy('name')->paginate(10);
    }

    public function findCountry($id)
    {
        return Country::find($id);
    }
}
