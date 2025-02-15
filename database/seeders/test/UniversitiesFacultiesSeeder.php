<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UniversitiesFacultiesSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        # PWSZ - Informatyka
        DB::table('universities_faculties')->insert(
            [
                [
                    'university_id' => 1,
                    'faculty_id' => 1,
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'university_id' => 1,
                    'faculty_id' => 2,
                    'created_at' => date('Y-m-d H:i:s')
                ]
            ]
        );
//
//		//PWSZ-WYDZIAL EKONOMICZNY
//        DB::table('universities_faculties')->insert([
//            'university_id' => 1,
//            'faculty_id' => 2,
//            'created_at' => date('Y-m-d H:i:s')
//        ]);
//
//        //PG-WYDZIAL ETI
//        DB::table('universities_faculties')->insert([
//            'university_id' => 2,
//            'faculty_id' => 3,
//            'created_at' => date('Y-m-d H:i:s')
//        ]);
    }
}
