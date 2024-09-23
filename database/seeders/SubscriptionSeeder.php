<?php

namespace Database\Seeders;

use App\Models\Subscription;
use App\Models\User;
use App\Models\Website;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $websites = Website::all();

        foreach ($users as $user) {
            Subscription::create([
                'uuid' => Str::uuid(),
                'user_id' => $user->id,
                'website_id' => $websites->random()->id,
            ]);
        }
    }
}
