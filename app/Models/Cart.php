<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'customerID',
        'productID',
        'product',
        'quantity',
        'price',
        'total',
        'image',
    ];
}
