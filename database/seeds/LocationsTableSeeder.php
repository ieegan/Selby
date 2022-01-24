<?php

use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'Gardenia',
                'GARDENIA',
            ],
            [
                'Selby Star',
                'SELBYSTAR',
            ],
            [
                'Selby Drive',
                'SELBYDRIVE',
            ]
        ];

        foreach ($data as $each) {
            $model = new \App\Location();
            $model->name = $each[0];
            $model->odbc = $each[1];
            $model->save();
        }
    }
}
