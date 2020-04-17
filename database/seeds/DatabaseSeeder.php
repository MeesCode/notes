<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => env('MY_NAME'),
            'email' => env('MY_EMAIL'),
            'password' => Hash::make(env('MY_PASSWORD')),
            'api_token' => Str::random(60),
        ]);
    }
}
