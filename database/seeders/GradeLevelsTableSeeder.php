<?php

namespace Database\Seeders;

use App\Models\GradeLevel;
use Illuminate\Database\Seeder;

class GradeLevelsTableSeeder extends Seeder
{
    public function run()
    {
        $gradeLevels = [
            // Primary Education (6 years)
            ['name' => 'Primary 1', 'level' => 'primary', 'order' => 1],
            ['name' => 'Primary 2', 'level' => 'primary', 'order' => 2],
            ['name' => 'Primary 3', 'level' => 'primary', 'order' => 3],
            ['name' => 'Primary 4', 'level' => 'primary', 'order' => 4],
            ['name' => 'Primary 5', 'level' => 'primary', 'order' => 5],
            ['name' => 'Primary 6', 'level' => 'primary', 'order' => 6],

            // Junior Secondary School (3 years)
            ['name' => 'JSS 1', 'level' => 'junior_secondary', 'order' => 7],
            ['name' => 'JSS 2', 'level' => 'junior_secondary', 'order' => 8],
            ['name' => 'JSS 3', 'level' => 'junior_secondary', 'order' => 9],

            // Senior Secondary School (3 years)
            ['name' => 'SSS 1', 'level' => 'senior_secondary', 'order' => 10],
            ['name' => 'SSS 2', 'level' => 'senior_secondary', 'order' => 11],
            ['name' => 'SSS 3', 'level' => 'senior_secondary', 'order' => 12],
        ];

        foreach ($gradeLevels as $level) {
            GradeLevel::create($level);
        }
    }
}
