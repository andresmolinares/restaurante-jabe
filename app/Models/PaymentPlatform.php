<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentPlatform extends Model
{
    use HasFactory;


    protected $fillable=[
        'name', 'image'
    ];

    public function orders(){
        return $this->hasMany(orders::class, 'payment_option', 'id');

    }
}
