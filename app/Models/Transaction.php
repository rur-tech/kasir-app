<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Branch;
use App\Models\PaymentMethod;
use App\Models\TransactionDetail;

class Transaction extends Model
{
    protected $fillable = [

        /*
        |--------------------------------------------------------------------------
        | USER & RELASI
        |--------------------------------------------------------------------------
        */
        'user_id',
        'branch_id',
        'payment_method_id',

        /*
        |--------------------------------------------------------------------------
        | TOTAL HITUNGAN
        |--------------------------------------------------------------------------
        */
        'subtotal',
        'discount_total',
        'grand_total',

        /*
        |--------------------------------------------------------------------------
        | PEMBAYARAN
        |--------------------------------------------------------------------------
        */
        'cash',
        'change',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI USER
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI CABANG
    |--------------------------------------------------------------------------
    */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI PAYMENT METHOD
    |--------------------------------------------------------------------------
    */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI DETAIL TRANSAKSI
    |--------------------------------------------------------------------------
    */
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR FORMAT RUPIAH
    |--------------------------------------------------------------------------
    */
    public function getGrandTotalRupiahAttribute()
    {
        return 'Rp ' . number_format($this->grand_total, 0, ',', '.');
    }

    public function getSubtotalRupiahAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    public function getDiscountRupiahAttribute()
    {
        return 'Rp ' . number_format($this->discount_total, 0, ',', '.');
    }
}