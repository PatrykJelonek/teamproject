<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecializationsSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('specializations')->insert(
            [
                [
                    'name' => 'Projektowanie Baz Danych i Oprogramowania Użytkowego',
                    'field_id' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Ekonomika Menedżerska',
                    'field_id' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Administracja Systemów i Sieci Komputerowych',
                    'field_id' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Grafika Komputerowa i Multimedia',
                    'field_id' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Przedsiębiorczość Gospodarcza',
                    'field_id' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            ]
        );
//
//        DB::table('specializations')->insert([
//            'name' => 'Grafika Komputerowa',
//            'description' => 'Grafika Komputerowa',
//            'created_at' => date('Y-m-d H:i:s'),
//            'updated_at' => date('Y-m-d H:i:s')
//        ]);
//
//        DB::table('specializations')->insert([
//            'name' => 'Informatyka i ekonometria',
//            'description' => 'Informatyka i ekonometria',
//            'created_at' => date('Y-m-d H:i:s'),
//            'updated_at' => date('Y-m-d H:i:s')
//        ]);
    }
}
