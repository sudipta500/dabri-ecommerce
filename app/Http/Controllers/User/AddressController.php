<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Address;

class AddressController extends Controller
{
    public function index(){
        return view('user.pages.address');
    }
    public function showAddress(Request $req){
        $userId=$req->session()->get('userId');
        if($userId){
        $countAddres=0;
        $Address=Address::where('user_id',$userId)->with('user')->get();
        $countAddres=count($Address);
        return view('user.pages.myaddress',['address'=>$Address,'countAddres'=>$countAddres]);
        }else{
           return redirect('/');
        }
    }

    public function createAddress(Request $req){
        $validate=$req->validate([
           'name' => 'required',
           'phone_number'=> 'required|numeric',
           'primary_address'=>'required',
           'second_address'=>'required'
        ]);
        $addrActive=Address::where('user_id',$req->user_id)->where('active',1)->first();
        if($addrActive){
            $addrActive->active=0;
            $addrActive->save();
            $address=new Address;
            $address->user_id=$req->user_id;
            $address->name=$req->name;
            $address->email=$req->email;
            $address->phone_number=$req->phone_number;
            $address->primary_address=$req->primary_address;
            $address->second_address=$req->second_address;
            $address->active=1;
            $address->save();
            return redirect()->to('checkout/'.$req->user_id);
        }else{
            $address=new Address;
            $address->user_id=$req->user_id;
            $address->name=$req->name;
            $address->email=$req->email;
            $address->phone_number=$req->phone_number;
            $address->primary_address=$req->primary_address;
            $address->second_address=$req->second_address;
            $address->active=1;
            $address->save();
            return redirect()->to('checkout/'.$req->user_id);
        }

    }

    public function updateAddress($id){
        $address=Address::find($id);
        return view('user.pages.edit_address',['address'=>$address]);
    }
    public function updateAddressData(Request $req,$id){
        $userId=$req->session()->get('userId');
        $addrActive=Address::where('user_id',$userId)->where('active',1)->first();
        $addrActive->active=0;
        $addrActive->save();
        $address=Address::find($id);
        $address->name=$req->name;
        $address->email=$req->email;
        $address->phone_number=$req->phone_number;
        $address->primary_address=$req->primary_address;
        $address->second_address=$req->second_address;
        $address->active=1;
        $address->save();
        return redirect()->to('checkout/'.$userId);

    }
    public function activeAddress(Request $req){
        $userId=$req->session()->get('userId');
        $addrActive=Address::where('user_id',$userId)->where('active',1)->first();
        if($addrActive){
            $addrActive->active=0;
            $addrActive->save();
            $Active=Address::where('id',$req->active)->first();
            $Active->active=1;
            $Active->save();
            return redirect('/get-address');
        }else{
            $Active=Address::where('id',$req->active)->first();
            $Active->active=1;
            $Active->save();
            return redirect('/get-address');
        }
    }

    public function activeAddressnew(Request $req){
        $userId=$req->session()->get('userId');
        $addrActive=Address::where('user_id',$userId)->where('active',1)->first();
        if($addrActive){
            $addrActive->active=0;
            $addrActive->save();
            $Active=Address::where('id',$req->active)->first();
            $Active->active=1;
            $Active->save();
            return redirect()->to('checkout/'.$userId);
        }else{
            $Active=Address::where('id',$req->active)->first();
            $Active->active=1;
            $Active->save();
            return redirect()->to('checkout/'.$userId);
        }
    }
}
