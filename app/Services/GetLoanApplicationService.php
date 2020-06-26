<?php


namespace App\Services;


use App\User;

class GetLoanApplicationService
{
    /**
     * @param User $user
     * @param array $filter This is for search or filter later on.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(User $user, $filter = []) {
        return $user->applications()
            ->with('history')
            ->get();
    }
}
