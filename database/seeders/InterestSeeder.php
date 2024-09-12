<?php

namespace Database\Seeders;

use App\Models\Interest;
use Illuminate\Database\Seeder;

class InterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $interests = [
            'Info produto 1',
            'Info produto 2',
            'Info produto 3',
            'Info produto 4',
            'Info produto 5',
        ];

        foreach ($interests as $interestName) {
            Interest::factory()->create(['name' => $interestName]);
        }
    }
}
