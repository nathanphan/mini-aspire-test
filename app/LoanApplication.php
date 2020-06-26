<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    const STATUS_NEW = 'new';
    const STATUS_APPROVED = 'approved';
    const STATUS_DECLINED = 'declined';
    const STATUS_DONE = 'done';

    protected $table = 'loan_applications';
    protected $guarded = [
        'borrower_id',
        'status'
    ];

    protected $attributes = [
        'status' => self::STATUS_NEW
    ];

    public function path()
    {
        return '/applications/' . $this->id;
    }

    public function borrower()
    {
        return $this->belongsTo(User::class, 'borrower_id', 'id');
    }

    public function history()
    {
        return $this->hasMany(RepayHistory::class, 'application_id', 'id');
    }

    public function getWeeklyRepayAmount()
    {
        return round($this->amount / $this->term, 2); // return a float.
    }

    public function markAs($status)
    {
        $this->status = $status;
        $this->save();
    }

    public function statusBadges()
    {
        return [
            self::STATUS_NEW => 'primary',
            self::STATUS_APPROVED => 'success',
            self::STATUS_DONE => 'secondary'
        ];
    }

    public function getStatusBadges()
    {
        return $this->statusBadges()[$this->status];
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function repayPath()
    {
        return '/applications/' . $this->id . '/repay';
    }

    public function getRemainingAmount()
    {
        $totalRePaid = $this->history()->get()->sum('amount');
        return round(abs($this->amount - $totalRePaid));
    }
}
