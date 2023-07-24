<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function packetSize(){
        return $this->belongsTo(PacketSize::class);
    }

    public function orderitem(){
        return $this->hasMany(OrderItem::class);
    }

    public function cart(){
        return $this->hasMany(Cart::class);
    }

}
