<?php

namespace App\Http\Controllers;

use App\LoanApplication;
use App\Payment\RepayFailedException;
use App\Payment\RepayManagerInterface;
use http\Env\Response;
use Illuminate\Http\Request;

class RepayLoanController extends Controller
{
    private $repayManager;

    public function __construct(RepayManagerInterface $rePayManager)
    {
        $this->repayManager = $rePayManager;
    }

    public function repay(LoanApplication $application)
    {
        if(auth()->user()->isNot($application->borrower)) {
            abort(403);
        }

        try {
            $this->repayManager->pay($application);
            return response()->redirectTo('/applications');
        }
        catch (RepayFailedException $repayFailedException) {
            return response()->json([], 422);
        }
    }
}
