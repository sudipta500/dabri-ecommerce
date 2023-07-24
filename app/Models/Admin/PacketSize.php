<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PacketSize extends Model
{
    use HasFactory;

    public function product(){
        return $this->hasMany(product::class);
       }
}
