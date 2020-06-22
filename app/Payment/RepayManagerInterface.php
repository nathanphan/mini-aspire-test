<?php


namespace App\Payment;


use App\LoanApplication;

interface RepayManagerInterface
{
    public function pay(LoanApplication $application);
}
