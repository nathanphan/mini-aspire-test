<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanApplicationRequest;
use App\LoanApplication;
use App\Policies\LoanApplicationPolicy;
use App\Services\CreateLoanApplicationService;
use App\Services\GetLoanApplicationService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ApplicationController extends Controller
{
    private $createLoanApplicationService;
    private $getLoanApplicationService;

    public function __construct(
        CreateLoanApplicationService $createLoanApplicationService,
        GetLoanApplicationService $getLoanApplicationService)
    {
        $this->createLoanApplicationService = $createLoanApplicationService;
        $this->getLoanApplicationService = $getLoanApplicationService;
    }

    public function store(LoanApplicationRequest $request)
    {
        $this->createLoanApplicationService->execute($request);

        return response()->redirectTo('/applications', 201);
    }

    public function show(LoanApplication $application)
    {
        $this->authorize(LoanApplicationPolicy::POLICY_MANAGE_LOAN, $application);

        return view('application.view', compact('application'));
    }

    public function index()
    {
        $applications = $this->getLoanApplicationService->all();
        return view('application.index', compact('applications'));
    }

    public function create()
    {
        return view('application.create');
    }
}
