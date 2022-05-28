<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guards = [];
    protected $fillable = ['id', 'timeout', 'address', 'regency', 'province', 'total', 'shipping_cost', 'sub_total', 'user_id', 'courier_id', 'proof_of_payment', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class, 'courier_id', 'id');
    }
}
