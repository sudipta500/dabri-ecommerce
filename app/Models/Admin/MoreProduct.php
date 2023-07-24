<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoreProduct extends Model
{
    use HasFactory;

    public function packet_size(){
        return $this->belongsTo(PacketSize::class);
    }
}
