<?php


namespace App\Services;


use App\Http\Requests\LoanApplicationRequest;
use Illuminate\Http\Request;

class CreateLoanApplicationService
{
    /**
     * @param LoanApplicationRequest $request
     * @return mixed
     */
    public function execute(LoanApplicationRequest $request)
    {
        return auth()->user()->applications()->create($request->validated());
    }
}
