<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Transaction;

class TransactionDetail extends Model
{
    protected $fillable = [

        'transaction_id',
        'product_id',
        'price',
        'qty',
        'subtotal',
        'bundle_name',

    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}