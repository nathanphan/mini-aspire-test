@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="">Loan Applications Dashboard</h1>
                <a href="{{ route('application.create') }}" type="button" class="btn btn-success">Apply for Loan</a>
                <br>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Email</th>
                        <th scope="col">Term (in weeks)</th>
                        <th scope="col">Loan Amount</th>
                        <th scope="col">Last Repayment</th>
                        <th scope="col">Status</th>
                        <th scope="col">Created</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($applications as $application)
                        <tr>
                            <th scope="row">{{ ++$loop->index }}</th>
                            <td>{{ $application->email }}
                            </td>
                            <td>{{ $application->term  }} weeks</td>
                            <td>{{ $application->amount }} $</td>
                            <td>
                                {{ $application->history->sortByDesc('created_at')->first() ?
                                   $application->history->sortByDesc('created_at')->first()->created_at->diffForHumans() :
                                   'No paid yet'  }}
                            </td>
                            <td>
                                <span class="badge badge-{{ $application->getStatusBadges() }}">
                                                        {{ $application->status }}</span>
                            </td>
                            <td>{{ $application->created_at }}</td>
                            <td><a href="{{ $application->path() }}" class="btn btn-secondary">View</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
