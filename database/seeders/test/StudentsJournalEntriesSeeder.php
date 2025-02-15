<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentsJournalEntriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students_journal_entries')->insert(
            [
                [
                    'student_id' => 1,
                    'journal_entry_id' => 1,
                    'accepted' => true,
                ],
                [
                    'student_id' => 1,
                    'journal_entry_id' => 2,
                    'accepted' => true,
                ],
                [
                    'student_id' => 1,
                    'journal_entry_id' => 3,
                    'accepted' => false,
                ],
            ]
        );
    }
}
