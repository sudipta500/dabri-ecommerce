<?php

namespace App\Http\Controllers;
use App\Models\AdminAuths;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class AdminAuthsController extends Controller
{
    public function viewLogin(){
        return view('admin.auth.login');
    }

    public function loginData(Request $req){
        $validated = $req->validate([
            'name'=>'required',
            'password' => 'required|min:6',
        ]);
        $sameUser=AdminAuths::where('name',$req->post('name'))->get();
        if((isset($sameUser[0]))){
            if(Crypt::decrypt($sameUser[0]->password)==$req->password){
                $req->session()->put('userId',$sameUser[0]->id);
                $req->session()->put('role',$sameUser[0]->role);
                $req->session()->put('userName',$sameUser[0]->name);
                if($sameUser[0]->role==1){
                    return redirect('/admin/dashboard');
                }else{
                    return redirect('/');
                }
            }else{
                $req->session()->flash('errorMessage','Invalid Password');
                return redirect('admin');
            }
           }else{
              $req->session()->flash('errorMessage','name is invalid');
              return redirect('admin');
           }
    }

}
