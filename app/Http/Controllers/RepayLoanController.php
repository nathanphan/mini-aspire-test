<?php

namespace App\Http\Controllers;

use App\LoanApplication;
use App\Payment\RepayFailedException;
use App\Policies\LoanApplicationPolicy;
use App\Services\RepayLoanService;
use http\Env\Response;
use Illuminate\Http\Request;

class RepayLoanController extends Controller
{
    private $repayLoanService;

    public function __construct(RepayLoanService $repayLoanService)
    {
        $this->repayLoanService = $repayLoanService;
    }

    public function repay(LoanApplication $application)
    {
       $this->authorize(LoanApplicationPolicy::POLICY_MANAGE_LOAN, $application);

        try {
            $this->repayLoanService->repay($application);
            return response()->redirectTo($application->path());
        }
        catch (RepayFailedException $repayFailedException) {
            return response()->json(['message' => $repayFailedException->getMessage()], 422);
        }
        catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 422);
        }
    }
}
