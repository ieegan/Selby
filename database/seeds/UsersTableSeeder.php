<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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
                'Ibrahim Egan',
                'eegan@live.com',
                'eegan',
                bcrypt('apple123'),
            ],
            [
                'Hussein Mohamed',
                'loadeys@gmail.com',
                'loadey',
                bcrypt('apple123'),
            ],
            [
                'Moosa Nasih',
                'nasih.deseo@gmail.com',
                'nasih',
                bcrypt('apple123'),
            ]
        ];

        foreach ($data as $each) {
            $model = new \App\User();
            $model->name = $each[0];
            $model->email = $each[1];
            $model->username = $each[2];
            $model->password = $each[3];
            $model->save();
        }
    }
}
