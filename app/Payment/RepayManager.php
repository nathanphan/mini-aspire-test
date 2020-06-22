<?php


namespace App\Payment;


use App\LoanApplication;

class RepayManager implements RepayManagerInterface
{
    /** @var LoanApplication $loanApplication */
    private $loanApplication;

    public function __construct() {}

    public function pay($application)
    {
        $this->loanApplication = $application;

        if ($this->loanApplication->status === LoanApplication::STATUS_DONE) {
            throw new RepayFailedException('The Application is already paid off.');
        }

        $this->loanApplication->history()->create([
            'amount' => $this->loanApplication->getWeeklyRepayAmount(),
        ]);

        if ($this->getTotalRepay() == $this->loanApplication->amount) {
            $this->loanApplication->markAs(LoanApplication::STATUS_DONE);
        }
    }

    public function getTotalRepay()
    {
        return round($this->loanApplication->history()->get()->sum('amount'));
    }

    public function getRemainingAmount()
    {
        return abs($this->loanApplication->amount - $this->getTotalRepay());
    }
}
