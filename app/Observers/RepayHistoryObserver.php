<?php

namespace App\Observers;

use App\LoanApplication;
use App\RepayHistory;

class RepayHistoryObserver
{
    /**
     * Handle the repay history "created" event.
     *
     * @param  \App\RepayHistory  $repayHistory
     * @return void
     */
    public function created(RepayHistory $repayHistory)
    {
        /** @var LoanApplication $loanApplication */
        $loanApplication = $repayHistory->application;

        if (round($loanApplication->getTotalRepaid()) == $loanApplication->amount) {
            $loanApplication->status = LoanApplication::STATUS_DONE;
            $loanApplication->save();
        }
    }

    /**
     * Handle the repay history "updated" event.
     *
     * @param  \App\RepayHistory  $repayHistory
     * @return void
     */
    public function updated(RepayHistory $repayHistory)
    {
        //
    }

}
