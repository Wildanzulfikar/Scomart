<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected $fillable = [
        'user_id',
        'product_id',
        'price',
        'jumlah',
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function totalItems($userId)
    {
        return self::where('user_id', $userId)->sum('jumlah');
    }



    use HasFactory;
}
