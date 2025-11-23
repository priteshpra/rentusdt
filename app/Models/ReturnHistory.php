<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnHistory extends Model
{
    use HasFactory;

    protected $table = 'return_history';   // your table name

    protected $primaryKey = 'id';

    protected $fillable = [
        'investment_id',
        'user_id',
        'principal_snapshot',
        'monthly_return',
        'daily_return',
        'for_date',
        'status',
        'processed_at'
    ];

    protected $dates = ['for_date', 'processed_at'];

    public function get_user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
