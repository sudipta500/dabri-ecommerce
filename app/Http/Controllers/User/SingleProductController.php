<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\product;
use App\Models\Admin\PacketSize;
use App\Models\Admin\MoreProduct;

class SingleProductController extends Controller
{
    public function index( $id){
       $product= product::where('id',$id)->with('packetSize')->first();
       $productImage=MoreProduct::where('product_id',$product->id)->get();
       $productSize = PacketSize::all();
       if($product){
        return view('user.pages.single_product',['product'=>$product,'productSize'=> $productSize,'productImage'=> $productImage]);
       }else{
        return view('user.pages.single_product',['errorMessage'=>'This Product Not Available']);
       }
    }
}
