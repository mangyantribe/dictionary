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
            'name' => $request->name,
        ];
        return $this->countryInterface->saveCountry($data);
    }

    public function getCounties()
    {
        return $this->countryInterface->getCounties();
    }

    public function findCountry($id)
    {
        return $this->countryInterface->findCountry($id);
    }
}
