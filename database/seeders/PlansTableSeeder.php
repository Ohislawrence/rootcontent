<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    public function run()
    {
        $plans = [
            [
                'name' => 'Termly Plan',
                'duration' => 'termly',
                'months' => 3,
                'price' => 5000.00,
                'description' => 'Perfect for single term access to all curriculum materials',
                'features' => json_encode([
                    'Access to all K-12 curriculum content',
                    'All subjects and grade levels',
                    'Downloadable materials',
                    '1-hour free trial available',
                    'Term-based access'
                ]),
                'is_active' => true,
                'is_default' => true,
            ],
            [
                'name' => 'Yearly Plan',
                'duration' => 'yearly',
                'months' => 12,
                'price' => 15000.00,
                'description' => 'Complete annual access with best value for money',
                'features' => json_encode([
                    'Full year access to all content',
                    'All subjects and grade levels',
                    'Downloadable materials',
                    'Priority support',
                    'Regular content updates',
                    '1-hour free trial available',
                    'Save 25% compared to termly'
                ]),
                'is_active' => true,
                'is_default' => false,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
