<?php

namespace App\Policies;

use App\LoanApplication;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class LoanApplicationPolicy
{
    const POLICY_MANAGE_LOAN = 'manageLoan';

    use HandlesAuthorization;

    public function manageLoan(User $user, LoanApplication $loanApplication)
    {
        return $user->is($loanApplication->borrower);
    }
}
