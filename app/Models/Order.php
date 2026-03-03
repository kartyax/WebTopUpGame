<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function game() {
        return $this->belongsTo(Game::class);
    }
    public function product() {
        return $this->belongsTo(Product::class);
    }
    public function paymentMethod() {
        return $this->belongsTo(PaymentMethod::class);
    }
    public function promo() {
        return $this->belongsTo(Promo::class);
    }
}
