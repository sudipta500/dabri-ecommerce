<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\Admin\Category;
use App\Models\Admin\PacketSize;
use App\Models\Admin\product;
use App\Models\Admin\Cart;
use Illuminate\Http\Request;
use App\Models\Admin\Address;

class CartController extends Controller
{
    public function index(Request $req,$id){
        // $product= product::find($id);
        // $productSize = PacketSize::all();
        if($req->packet_size){
            $product=product::where('packet_size_id',$req->post('packet_size'))->where('flavour_name',$req->post('flavour_name'))->first();
            if($product){
                return to_route('/single_product', ['id' => $product]);
            }else{
                $req->session()->flash('errorMessage','This Product Not Available');
                return to_route('/single_product', ['id' => $id]);
            }
        }
        if($req->product_id){
            if($req->userId){
                $cartProduct=Cart::where('user_id',$req->userId)->where('product_id',$req->product_id)->first();
                if($cartProduct){
                    $cartProduct->quantity=$cartProduct->quantity+1;
                    $totalPrice=($cartProduct->price)+($req->price);
                    $totalOfferPrice=($cartProduct->offer_price)+($req->offer_price);
                    $cartProduct->price=$totalPrice;
                    $cartProduct->offer_price=$totalOfferPrice;
                    $cartProduct->save();
                    return redirect()->to('cart/'.$req->userId);
                }else{
                    $cart=new Cart;
                    $cart->user_id=$req->userId;
                    $cart->product_id=$req->product_id;
                    $cart->price=$req->price;
                    $cart->offer_price=$req->offer_price;
                    $cart->quantity=1;
                    $cart->save();
                    return redirect()->to('cart/'.$req->userId);
                }

            }else{
                return redirect('/login');
            }

        }
    }

    public function cartUpadte(Request $req){
        $userId=$req->session()->get('userId');
        if($req->action=='plush'){
            $cartProduct=Cart::where('id',$req->product_id)->first();
            $cartProduct->quantity=$cartProduct->quantity+1;
            $totalPrice=($cartProduct->price)+($req->price);
            $cartProduct->price=$totalPrice;
            $totaloffer=($cartProduct->offer_price)+($req->offer_price);
            $cartProduct->offer_price=$totaloffer;
            $cartProduct->save();
            return redirect()->to('cart/'.$userId);
        }
        if($req->action=='minus'){
            $cartProduct=Cart::where('id',$req->product_id)->first();
            $cartProduct->quantity=$cartProduct->quantity-1;
            $totalPrice=($cartProduct->price)-($req->price);
            $cartProduct->price=$totalPrice;
            $totaloffer=($cartProduct->offer_price)-($req->offer_price);
            $cartProduct->offer_price=$totaloffer;
            $cartProduct->save();
            return redirect()->to('cart/'.$userId);
        }
    }

    public function cartView(Request $req,$id){
        $cartProduct=Cart::where('user_id',$id)->with('product')->get();
        // return $cartProduct;
        $price=0;
        $TotalPrice=0;
        foreach ($cartProduct as $key => $value) {
            $price=$price+$value->price;
            $TotalPrice=$TotalPrice+$value->offer_price;
        }
        // return $price;
        // return $TotalPrice;
        $discount=$TotalPrice-$price;
        // return $discount;
        // return $cartProduct;
        return view('user.pages.cart',['cartProduct'=>$cartProduct,'price'=>$price,'duacount'=>$discount]);
    }

    public function cartDelete(Request $request,$id){
        Cart::destroy( $request->cart_id);
       return redirect()->to('cart/'.$id);
    }

    public function cartOperation(Request $req){
        return redirect()->to('checkout/'.$req->checkout);
        // $checkout=$req->checkout;
        // if($ProductID){
        //    $cartProduct=Cart::destroy($ProductID);
        //    return redirect('/cart');
        // }elseif ($checkout) {
        //     return redirect('/checkout');
        // }else{
        //     return 'select';
        // }

    }
}
