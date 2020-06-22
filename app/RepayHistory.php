<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RepayHistory extends Model
{
    protected $guarded = [];
    protected $touches = ['application'];

    public function application()
    {
        return $this->belongsTo(LoanApplication::class, 'application_id', 'id');
    }
}
