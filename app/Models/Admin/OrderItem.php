<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    public function address(){
        return $this->belongsTo(Address::class);
    }
    public function product(){
        return $this->belongsTo(product::class);
    }
}
