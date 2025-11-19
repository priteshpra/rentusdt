<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trnx extends Model
{
    protected $table = 'trnx';

    protected $fillable = [
        'user_id',
        'type',
        'hash',
        'amount',
        'date_time',
    ];
}
