<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\OrderItem;
use App\Models\Admin\Address;
use App\Models\Admin\Cart;

class orderItemController extends Controller
{
    public function orderItem(Request $request){
        $validate=$request->validate([
            'payment'=>'required'
        ]);
        if($request->payment){
            $cartProduct=Cart::where('user_id',$request->userId)->get();
            foreach ($cartProduct as $key => $value) {
                $orderItem=new OrderItem;
                $orderItem->user_id=$request->userId;
                $orderItem->product_id=$value->product_id;
                $orderItem->quantity=$value->quantity;
                $orderItem->price=$value->price;
                $orderItem->payment_type=$request->payment;
                $orderItem->address_id=$request->address;
                $orderItem->save();
                Cart::destroy($value->id);
            }
            return redirect('/');
        }else{
            $request->session()->flash('errorMessage','Please seletc payment method');
            return view('checkout/'.$request->userId);
        }
        // $orderItem->
        // return $request->all();
    }


    public function showItem($id){
        $OrderItem = OrderItem::where('user_id',$id)->with('address','product')->get();
        return view('user.pages.my-order',['OrderItem'=>$OrderItem]);
    }

    public function orderCheck(){
        $OrderItem = OrderItem::where('delivered',0)->with('address','product','product.category','product.packetSize')->paginate(10);
        return view('dabri.pages.orderitem',['OrderItem'=>$OrderItem]);
    }
    public function delivered($id){
        $OrderItem = OrderItem::find($id);
        $OrderItem->delivered=1;
        $OrderItem->save();
        return redirect('admin/order_item');
    }

    public function showDelivered(){
        $OrderItem = OrderItem::where('delivered',1)->with('address','product','product.category','product.packetSize')->paginate(10);
        return view('dabri.pages.already_order',['OrderItem'=>$OrderItem]);
    }

    // public function buyIndex($id){

    //     $countAddres=0;
    //     $Address=Address::where('user_id',$id)->with('user')->get();
    //     $countAddres=count($Address);
    //     $addrActive=Address::where('user_id',$id)->where('active',1)->first();
    //     return view('user.pages.checkout',['address'=>$Address,'countAddres'=>$countAddres,'addrActive'=>$addrActive]);
    //  return $id;
    // }
}
