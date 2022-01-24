<?php

namespace App\Imports;

use App\Country;
use Maatwebsite\Excel\Concerns\ToModel;

class CountriesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Country([
            'name'     => $row[3],
            'latitude'     => $row[1],
            'longitude'     => $row[2],
            'iso'     => $row[0],
        ]);
    }
}
