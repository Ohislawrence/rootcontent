<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectsTableSeeder extends Seeder
{
    public function run()
    {
        $subjects = [
            // Core Subjects (All levels)
            ['name' => 'English Language', 'category' => 'core', 'grade_levels' => range(1, 12)],
            ['name' => 'Mathematics', 'category' => 'core', 'grade_levels' => range(1, 12)],
            ['name' => 'Basic Science and Technology', 'category' => 'core', 'grade_levels' => [1, 2, 3, 4, 5, 6, 7, 8, 9]],
            ['name' => 'Social Studies', 'category' => 'core', 'grade_levels' => [4, 5, 6, 7, 8, 9]],
            ['name' => 'Civic Education', 'category' => 'core', 'grade_levels' => [7, 8, 9, 10, 11, 12]],
            ['name' => 'Computer Studies/ICT', 'category' => 'core', 'grade_levels' => [4, 5, 6, 7, 8, 9, 10, 11, 12]],

            // Primary School Specific
            ['name' => 'Verbal Reasoning', 'category' => 'core', 'grade_levels' => [1, 2, 3, 4, 5, 6]],
            ['name' => 'Quantitative Reasoning', 'category' => 'core', 'grade_levels' => [1, 2, 3, 4, 5, 6]],
            ['name' => 'Vocational Aptitude', 'category' => 'core', 'grade_levels' => [1, 2, 3, 4, 5, 6]],
            ['name' => 'Home Economics', 'category' => 'core', 'grade_levels' => [4, 5, 6, 7, 8, 9]],
            ['name' => 'Physical and Health Education', 'category' => 'core', 'grade_levels' => [1, 2, 3, 4, 5, 6, 7, 8, 9]],
            ['name' => 'Christian Religious Studies', 'category' => 'core', 'grade_levels' => [1, 2, 3, 4, 5, 6, 7, 8, 9]],
            ['name' => 'Islamic Religious Studies', 'category' => 'core', 'grade_levels' => [1, 2, 3, 4, 5, 6, 7, 8, 9]],
            ['name' => 'Yoruba Language', 'category' => 'core', 'grade_levels' => [1, 2, 3, 4, 5, 6, 7, 8, 9]],
            ['name' => 'Igbo Language', 'category' => 'core', 'grade_levels' => [1, 2, 3, 4, 5, 6, 7, 8, 9]],
            ['name' => 'Hausa Language', 'category' => 'core', 'grade_levels' => [1, 2, 3, 4, 5, 6, 7, 8, 9]],
            ['name' => 'French', 'category' => 'core', 'grade_levels' => [4, 5, 6, 7, 8, 9, 10, 11, 12]],

            // Science Subjects (Senior Secondary)
            ['name' => 'Physics', 'category' => 'science', 'grade_levels' => [10, 11, 12]],
            ['name' => 'Chemistry', 'category' => 'science', 'grade_levels' => [10, 11, 12]],
            ['name' => 'Biology', 'category' => 'science', 'grade_levels' => [10, 11, 12]],
            ['name' => 'Further Mathematics', 'category' => 'science', 'grade_levels' => [10, 11, 12]],
            ['name' => 'Agricultural Science', 'category' => 'science', 'grade_levels' => [7, 8, 9, 10, 11, 12]],

            // Arts Subjects (Senior Secondary)
            ['name' => 'Literature in English', 'category' => 'arts', 'grade_levels' => [10, 11, 12]],
            ['name' => 'Government', 'category' => 'arts', 'grade_levels' => [10, 11, 12]],
            ['name' => 'Geography', 'category' => 'arts', 'grade_levels' => [7, 8, 9, 10, 11, 12]],
            ['name' => 'History', 'category' => 'arts', 'grade_levels' => [7, 8, 9, 10, 11, 12]],
            ['name' => 'Visual Arts', 'category' => 'arts', 'grade_levels' => [7, 8, 9, 10, 11, 12]],
            ['name' => 'Music', 'category' => 'arts', 'grade_levels' => [7, 8, 9, 10, 11, 12]],

            // Commercial Subjects (Senior Secondary)
            ['name' => 'Commerce', 'category' => 'commercial', 'grade_levels' => [10, 11, 12]],
            ['name' => 'Financial Accounting', 'category' => 'commercial', 'grade_levels' => [10, 11, 12]],
            ['name' => 'Economics', 'category' => 'commercial', 'grade_levels' => [10, 11, 12]],
            ['name' => 'Book Keeping', 'category' => 'commercial', 'grade_levels' => [10, 11, 12]],

            // Technical Subjects
            ['name' => 'Technical Drawing', 'category' => 'technical', 'grade_levels' => [7, 8, 9, 10, 11, 12]],
            ['name' => 'Woodwork', 'category' => 'technical', 'grade_levels' => [7, 8, 9, 10, 11, 12]],
            ['name' => 'Metalwork', 'category' => 'technical', 'grade_levels' => [7, 8, 9, 10, 11, 12]],
            ['name' => 'Auto Mechanics', 'category' => 'technical', 'grade_levels' => [10, 11, 12]],
            ['name' => 'Electronics', 'category' => 'technical', 'grade_levels' => [10, 11, 12]],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
