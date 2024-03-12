<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_product',
        'quantity',
        'total_price'
    ];

    public function user ()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function product ()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id');
    }
}
