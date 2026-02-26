<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
  protected $fillable = [
    'user_id','order_id',
    'subtotal','shipping_cost','grand_total',
    'customer_name','customer_phone','customer_email',
    'shipping_address','notes',
    'snap_token','payment_type','transaction_status','fraud_status','status',
    'paid_at','midtrans_payload',
  ];

  protected $casts = [
    'midtrans_payload' => 'array',
    'paid_at' => 'datetime',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function items(): HasMany
  {
    return $this->hasMany(TransactionItem::class);
  }
}
