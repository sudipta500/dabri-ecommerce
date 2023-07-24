<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    public function product(){
        return $this->belongsTo(product::class);
    }
    // public function packet_size(){
    //     return $this->belongsTo(PacketSize::class);
    // }
}

