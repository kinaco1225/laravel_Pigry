<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WeightLog;
use App\Models\WeightTarget;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        WeightLog::factory()
            ->count(35)
            ->create([
                'user_id' => $user->id,
            ]);

        WeightTarget::factory()->create([
            'user_id' => $user->id,
        ]);
            
    }
}
