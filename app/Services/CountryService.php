<?php

namespace App\Services;
use App\Interfaces\CountryInterface;
class CountryService
{

    protected $countryInterface;
    /**
     * Create a new class instance.
     */
    public function __construct(CountryInterface $countryInterface)
    {
        $this->countryInterface = $countryInterface;
    }

    public function saveCountry($request)
    {
        $data = [
            'id'    => $request->id,
            'code'  => $request->code,
            'name' => $request->name,
        ];
        return $this->countryInterface->saveCountry($data);
    }

    public function getSearchCountries($keyword)
    {
        return $this->countryInterface->getSearchCountries($keyword);
    }

    public function getCounties()
    {
        return $this->countryInterface->getCounties();
    }

    public function getGuestCountries($search,$cursor)
    {
        $data = [];

        $countries = $this->countryInterface->getGuestCountries($search,$cursor);

        foreach ($countries as $key => $country) {

            $data[] = array(
                'id'         => $country->id,
                'photo'      => $country->photo,
                'code'       => $country->code,  
                'name'       => $country->name,
            );
        }
        return [
            'data'   => $data,
            'cursor' => $countries->nextCursor()?->encode(),
        ];
    }

    public function findCountry($id)
    {
        return $this->countryInterface->findCountry($id);
    }
}
