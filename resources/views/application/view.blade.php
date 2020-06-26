@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <a href="{{ url('/applications') }}" type="button" class="btn btn-primary">Back</a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="basicInfo-tab" data-toggle="tab"
                                               href="#basicInfo"
                                               role="tab" aria-controls="basicInfo" aria-selected="true">Loan Application {{ $application->id }}
                                                Details</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content ml-1" id="myTabContent">
                                        <div class="tab-pane fade show active" id="basicInfo" role="tabpanel"
                                             aria-labelledby="basicInfo-tab">


                                            <div class="row">
                                                <div class="col-sm-2 col-md-2 col-4">
                                                    <label style="font-weight:bold;">Term (in Weeks)</label>
                                                </div>
                                                <div class="col-md-7 col-5">
                                                    {{ $application->term }} weeks
                                                </div>
                                                @if($application->status == \App\LoanApplication::STATUS_APPROVED)
                                                    <div class="col-md-1 col-1">
                                                        <form method="POST" action="{{ $application->repayPath() }}">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success">Repay
                                                                <span class="badge badge-light">{{ $application->getWeeklyRepayAmount() }} USD</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                            <hr/>
                                            <div class="row">
                                                <div class="col-sm-3 col-md-2 col-5">
                                                    <label style="font-weight:bold;">Loan Amount</label>
                                                </div>
                                                <div class="col-md-8 col-6">
                                                    {{ $application->amount }} $
                                                </div>
                                            </div>
                                            <hr/>
                                            <div class="row">
                                                <div class="col-sm-3 col-md-2 col-5">
                                                    <label style="font-weight:bold;">Applicant Name</label>
                                                </div>
                                                <div class="col-md-8 col-6">
                                                    {{ $application->first_name . ' ' . $application->last_name }}
                                                </div>
                                            </div>
                                            <hr/>

                                            <div class="row">
                                                <div class="col-sm-3 col-md-2 col-5">
                                                    <label style="font-weight:bold;">Email</label>
                                                </div>
                                                <div class="col-md-8 col-6">
                                                    {{ $application->email }}
                                                </div>
                                            </div>
                                            <hr/>

                                            <div class="row">
                                                <div class="col-sm-3 col-md-2 col-5">
                                                    <label style="font-weight:bold;">Date of Birth</label>
                                                </div>
                                                <div class="col-md-8 col-6">
                                                    {{ $application->dob }}
                                                </div>
                                            </div>
                                            <hr/>

                                            <div class="row">
                                                <div class="col-sm-3 col-md-2 col-5">
                                                    <label style="font-weight:bold;">Status</label>
                                                </div>
                                                <div class="col-md-8 col-6">
                                                    <span class="badge badge-{{ $application->getStatusBadges() }}">
                                                        {{ $application->status }}</span>

                                                    <span class="badge badge-info">
                                                        Remaining Amount: {{ $application->getRemainingAmount() }}</span>

                                                </div>
                                            </div>
                                            <hr/>

                                            <div class="row">
                                                <div class="col-sm-3 col-md-2 col-5">
                                                    <label style="font-weight:bold;">Note</label>
                                                </div>
                                                <div class="col-md-8 col-6">
                                                    {{ $application->note }}
                                                </div>
                                            </div>
                                            <hr/>


                                        </div>

                                    </div>
                                </div>
                            </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
