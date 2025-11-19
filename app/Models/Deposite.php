<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposite extends Model
{
    use HasFactory;

    protected $table = 'payment_deposites';   // your table name

    protected $primaryKey = 'id';

    public $timestamps = true;        // because you have created_at / updated_at

    protected $fillable = [
        'user_id',
        'buyer_email',
        'amount1',
        'currency1',
        'status_1',
        'order_id',
        'status_text',
        'amount2',
        'currency2',
        'expire_at',
        'txn_id',
        'address_1',
        'status_url',
        'gateway',
        'amount',
        'status',
        'apply_date',
    ];

    protected $casts = [
        'expire_at' => 'datetime',
        'amount1' => 'decimal:8',
        'amount2' => 'decimal:8',
        'amount'  => 'decimal:8',
        'apply_date' => 'datetime',
    ];

    // Optional: Relation to user
    public function get_user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
