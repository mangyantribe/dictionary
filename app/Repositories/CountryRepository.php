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

    public function getSearchCountries($keyword = null)
    {
        return Country::query()->when(filled($keyword),
                fn ($query) => $query->where('name', 'like', '%' . trim($keyword) . '%')
            )->orderBy('name')->limit(5)->get();
    }

    public function getCounties()
    {
        return Country::orderBy('name')->paginate(10);
    }

    public function getGuestCountries($search = null,$cursor = null)
    {
        return Country::query()->when($search, function ($query) use ($search){
            $query->where('name', 'like', '%' . $search . '%');
        })->orderBy('name')->cursorPaginate(10, ['id', 'photo', 'code', 'name'], 'cursor', $cursor);
    }

    public function findCountry($id)
    {
        return Country::find($id);
    }
}
