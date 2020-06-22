<?php

use Illuminate\Database\Seeder;

class LoanApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\User::all();

        foreach ($users as $user) {
            $newApplication = factory(\App\LoanApplication::class)->raw(['borrower_id' => $user->id]);
            $approvedApplication = factory(\App\LoanApplication::class)
                ->state(\App\LoanApplication::STATUS_APPROVED)->raw(['borrower_id' => $user->id]);

            $user->applications()->create($newApplication);
            $user->applications()->create($approvedApplication);
        }
    }
}
