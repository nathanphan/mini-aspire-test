<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\LoanApplication;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(LoanApplication::class, function (Faker $faker) {
    return [
        'term' => '12', // in weeks
        'amount' => 1500, // in dollars
        'first_name' => 'Test First Name',
        'last_name' => 'Test Last Name',
        'monthly_income' => 2000, // in dollars
        'dob' => $faker->date('Y-m-d'),
        'email' => 'ngoc@test.com',
        'phone' => $faker->phoneNumber,
        //'status' => LoanApplication::STATUS_NEW,
        'note' => $faker->paragraph,
        'borrower_id' => factory(\App\User::class)->create()->id,
    ];
});

$factory->state(LoanApplication::class, 'approved', function ($faker) {
    return [
        'status' => LoanApplication::STATUS_APPROVED,
    ];
});

$factory->state(LoanApplication::class, LoanApplication::STATUS_DONE, function ($faker) {
    return [
        'status' => LoanApplication::STATUS_DONE,
    ];
});
