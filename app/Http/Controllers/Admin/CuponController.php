<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Cupon;
use Illuminate\Http\Request;

class CuponController extends Controller
{
    public function index(){
        $CuponAll=Cupon::all();
        return view('dabri.pages.cupon.cupon',['cupon'=>$CuponAll]);
    }
    public function createView(){
        return view('dabri.pages.cupon.create-cupon');
    }
    public function createData(Request $req ){
        $sameCatagory=Cupon::where('cupon_code',$req->post('cupon_code'))->get();
       if(isset($sameCatagory[0])){
            $req->session()->flash('errorMessage','This Catagory is already created');
            return redirect('admin/create-cupon');
       }else{
            $validate=$req->validate([
                'cupon_code' => 'required',
                'value'=>'required'
            ]);
            $Cupon=new Cupon;
                $Cupon->cupon_code=$req->cupon_code;
                $Cupon->value=$req->value;
                $Cupon->save();
                return redirect('admin/cupon')->with('Sucess', 'New Cupon Added');
       }
    }

    public function editView($id){
        $Cupon=Cupon::find($id);
        return view('dabri.pages.cupon.edit_cupon',['cupon'=> $Cupon]);
    }

    public function editData(Request $req,$id){
        $cupon=Cupon::find($id);
        $validate=$req->validate([
            'cupon_code' => 'required',
            'value'=>'required'
        ]);
        $cupon->cupon_code=$req->cupon_code;
        $cupon->value=$req->value;
        $cupon->save();
        return redirect('admin/cupon')->with('Sucess', 'Edit catagory');
    }

    public function destroy($id)
    {
        Cupon::destroy($id);
        return redirect('admin/cupon');

    }
}
