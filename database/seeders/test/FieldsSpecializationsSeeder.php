<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FieldsSpecializationsSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fields_specializations')->insert(
            [
                [
                    'field_id' => 1,
                    'specialization_id' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'field_id' => 2,
                    'specialization_id' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'field_id' => 1,
                    'specialization_id' => 3,
                    'created_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'field_id' => 1,
                    'specialization_id' => 4,
                    'created_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'field_id' => 2,
                    'specialization_id' => 5,
                    'created_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
//
//        DB::table('fields_specializations')->insert([
//            'field_id' => 1,
//            'specialization_id' => 2,
//            'created_at' => date('Y-m-d H:i:s')
//        ]);
//
//        DB::table('fields_specializations')->insert([
//            'field_id' => 2,
//            'specialization_id' => 3,
//            'created_at' => date('Y-m-d H:i:s')
//        ]);
    }
}
