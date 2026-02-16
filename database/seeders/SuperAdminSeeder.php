<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@test.com', // Change to your email
            'password' => Hash::make('password'), // Change to your password
            'user_level' => 2,
        ]);

        // 2. Create the primary "Admin" Team
        // We set personal_team to true so Jetstream treats it as your default home
        $team = Team::create([
            'user_id' => $user->id,
            'name' => "Main Admin Team",
            'personal_team' => true,
        ]);

        // 3. Connect the user to the team properly
        $user->current_team_id = $team->id;
        $user->save();
    }
}
