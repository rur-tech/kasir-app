<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    protected $table = 'bundles';

    protected $fillable = [
        'name',
        'product_name',
        'bundle_price',
        'stock',
        'description',
    ];

    /*
    |--------------------------------------------------------------------------
    | FORMAT HARGA
    |--------------------------------------------------------------------------
    */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format(
            $this->bundle_price,
            0,
            ',',
            '.'
        );
    }
}