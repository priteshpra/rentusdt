<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletRequest extends Model
{
    protected $table = 'wallet_request';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'withdraw_type',
        'payout_id',
        'wallet_type',
        'wallet_charges',
        'wallet_gateway',
        'wallet_gatway_detail',
        'wallet_amount',
        'wallet_admin_commision',
        'wallet_admin_rich_master',
        'wallet_admin_tds',
        'payable_amount',
        'Wallet_requestdate',
        'status_text',
        'wallet_request_time',
        'wallet_transferdate',
        'wallet_status',
        'withdraw_reject_status',
    ];

    public function get_user()
    {
        return $this->belongsTo('App\Models\users', 'user_id');
    }

    public function get_wallet_gateway()
    {
        return $this->belongsTo('App\Models\payment_gateway', 'wallet_gateway');
    }
}
