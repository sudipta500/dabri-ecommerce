<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Address;

class CheckoutController extends Controller
{

    public function checkout(){
       return redirect('/checkout');
    }

    public function index($id){
        $countAddres=0;
        $Address=Address::where('user_id',$id)->with('user')->get();
        $countAddres=count($Address);
        $addrActive=Address::where('user_id',$id)->where('active',1)->first();
        return view('user.pages.checkout',['address'=>$Address,'countAddres'=>$countAddres,'addrActive'=>$addrActive]);
    }

}
