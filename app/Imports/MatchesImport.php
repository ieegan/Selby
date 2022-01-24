<?php

namespace App\Imports;

use App\Country;
use App\Match;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class MatchesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $alpha = Country::firstOrCreate(['name' => $row[0]]);
        $beta = Country::firstOrCreate(['name' => $row[1]]);

        return new Match([
            'alpha_id' => $alpha->id,
            'beta_id' => $beta->id,
            'stage_id' => $row[2],
            'kickoff_at' => Carbon::parse($row[3]),
        ]);
    }
}
