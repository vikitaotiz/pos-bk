<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMode extends Model
{
    use HasFactory;

    protected $fillable = ["name", "uuid", "user_id"];

    protected $hidden = ["id"];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function bills() {
        return $this->hasMany(Bill::class);
    }
}
