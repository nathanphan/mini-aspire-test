<?php

namespace App\Policies;

use App\LoanApplication;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LoanApplicationPolicy
{
    const POLICY_SHOW = 'show';

    use HandlesAuthorization;

    public function show(User $user, LoanApplication $loanApplication)
    {
        return $user->is($loanApplication->borrower);
    }
}
