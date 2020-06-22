@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <ul class="list-group">
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <li class="list-group-item list-group-item-danger">{{ $error }}</li>
                        @endforeach
                    @endif
                </ul>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="/applications" class="form-horizontal" style="padding-top: 20px">
                    @csrf
                    <fieldset>
                        <legend>Loan Application Form</legend>
                    </fieldset>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="Name (Full name)">Name (Full name)</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input id="first_name" name="first_name" type="text" placeholder="First Name"
                                       class="form-control input-md">
                                <input id="last_name" name="last_name" type="text" placeholder="Last Name"
                                       class="form-control input-md">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="email">Email</label>
                        <div class="col-md-4">

                            <div class="input-group">
                                <input id="email" name="email" type="email" placeholder="Your email address" required
                                       class="form-control input-md">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="phone">Phone Number</label>
                        <div class="col-md-4">

                            <div class="input-group">
                                <input id="phone" name="phone" type="tel" placeholder="Your personal phone number"
                                       class="form-control input-md">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="dob">Date Of Birth</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input id="dob" name="dob" type="text" placeholder="Date Of Birth"
                                       class="form-control input-md">
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-4 control-label" for="monthly_income">Monthly Income (in Dollar)</label>
                        <div class="col-md-4">

                            <div class="input-group">
                                <input id="monthly_income" name="monthly_income" type="text" placeholder="Your monthly income"
                                       class="form-control input-md">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="term">Loan Term (in weeks)</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <select class="form-control" id="term" name="term" required>
                                    <option value="0">--Select--</option>
                                    <option value="12">12 weeks</option>
                                    <option value="24">24 weeks</option>
                                    <option value="36">36 weeks</option>
                                    <option value="48">48 weeks</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="">Amount to Loan (in US Dollar)</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input id="amount" name="amount" type="number" step="50" placeholder="Amount to loan"
                                       value="100"
                                       required
                                       class="form-control input-md">
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="note">Note</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Apply</button>
                    <a href="{{ url('/applications') }}" type="button" class="btn btn-primary">Back</a>
                </form>
            </div>
{{--            <div class="col-md-2">--}}
{{--                <p>--}}
{{--                    Welcome to Mini Aspire Loan Program.--}}
{{--                </p>--}}
{{--            </div>--}}
        </div>
    </div>
@endsection
