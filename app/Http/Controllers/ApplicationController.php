<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanApplicationRequest;
use App\LoanApplication;
use App\Policies\LoanApplicationPolicy;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function store(LoanApplicationRequest $request)
    {
        $attributes = $this->validateRequest();

        $attributes = array_merge(request()->all(), $attributes);

        auth()->user()->applications()->create($attributes);

        return response()->redirectTo('/applications', 201);
    }

    public function show(LoanApplication $application)
    {
        $this->authorize(LoanApplicationPolicy::POLICY_SHOW, $application);

        return response()->json($application);
    }

    public function index()
    {
        $applications = auth()->user()->applications;
        return view('application.index', compact('applications'));
    }

    public function create()
    {
        return view('application.create');
    }

    protected function validateRequest()
    {
        return request()->validate([
            'email' => 'required|email',
            'term' => 'required|numeric|min:1',
            'amount' => 'required|numeric|min:100', // Assume that minimum loan amount must equal or greater than 100 dollars
            'dob' => 'nullable|date:Y-m-d'
        ]);
    }
}
