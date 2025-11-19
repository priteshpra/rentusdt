<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnHistory extends Model
{
    protected $fillable = [
        'investment_id',
        'user_id',
        'principal_snapshot',
        'monthly_amount',
        'daily_amount',
        'for_date',
        'status',
        'processed_at'
    ];

    protected $dates = ['for_date', 'processed_at'];
}
