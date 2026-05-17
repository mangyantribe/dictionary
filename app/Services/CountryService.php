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
            'name' => $request->name,
        ];
        return $this->countryInterface->saveCountry($data);
    }
}
