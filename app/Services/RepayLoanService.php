<?php


namespace App\Services;


use App\LoanApplication;
use App\Payment\RepayFailedException;

class RepayLoanService
{
    public function repay(LoanApplication $loanApplication)
    {
        if ($loanApplication->status === LoanApplication::STATUS_DONE) {
            throw new RepayFailedException('The Application is already paid off.');
        }

        $loanApplication->history()->create([
            'amount' => $loanApplication->getWeeklyRepayAmount(),
        ]);
    }
}
