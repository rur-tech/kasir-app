<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'branch_id',
        'category_id',
        'name',
        'price',
        'stock',
    ];

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
    | RELASI KATEGORI
    |--------------------------------------------------------------------------
    */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI DETAIL TRANSAKSI
    |--------------------------------------------------------------------------
    */
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    /*
    |--------------------------------------------------------------------------
    | FORMAT HARGA
    |--------------------------------------------------------------------------
    */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format(
            $this->price,
            0,
            ',',
            '.'
        );
    }
}