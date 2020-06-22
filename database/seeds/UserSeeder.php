<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class)->create([
                'email' => 'borrower1@mini-aspire.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password')
            ]);
    }
}
