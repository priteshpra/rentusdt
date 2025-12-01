<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferHistory extends Model
{
    protected $table = 'refer_history';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'refer_user_id',
        'refer_amount',
    ];
}
