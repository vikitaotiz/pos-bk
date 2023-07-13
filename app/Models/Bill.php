<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = ["status", "uuid", "user_id", "selling_price", "payment_mode_id"];

    protected $hidden = ["id"];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function payment_mode() {
        return $this->belongsTo(PaymentMode::class);
    }

    public function  sales() {
        return $this->hasMany(Sale::class);
    }
}
