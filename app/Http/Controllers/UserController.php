<?php

namespace App\Http\Controllers;

use App\Models\Admin\User;
use App\Models\Admin\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Mail;

class UserController extends Controller
{
    public function viewLogin(){
        return view('auth.login');
    }
    public function viewRegister(){
        return view('auth.register');
    }

    public function loginData(Request $req){
        $validated = $req->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        $sameUser=User::where('email',$req->post('email'))->get();
        if((isset($sameUser[0]))){
            if(Crypt::decrypt($sameUser[0]->password)==$req->password){
                $req->session()->put('userId',$sameUser[0]->id);
                $req->session()->put('userName',$sameUser[0]->name);
                return redirect('/');
            }else{
                $req->session()->flash('errorMessage','Invalid Password');
                return redirect('login');
            }
           }else{
              $req->session()->flash('errorMessage','Email is invalid');
              return redirect('login');
           }
    }


    public function registerData(Request $req){
        $sameUser=User::where('email',$req->post('email'))->get();
        if((isset($sameUser[0]))){
            $req->session()->flash('errorMessage','Email is invalid or already taken');
            return redirect('register');
        }else{
        $validate=$req->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        $user=new User;
        $user->name=$req->name;
        $user->email=$req->email;
        $user->password=Crypt::encrypt($req->input('password'));
        $user->save();
        $findUser=User::where('email',$req->post('email'))->get();
        $req->session()->put('userId',$findUser[0]->id);
        $req->session()->put('userName',$findUser[0]->name);
        return redirect('/');
     }
    }

    public function logout(Request $req){
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return redirect('/');
    }
    public function index(){
        return view('auth.forgetpassword');
    }
    public function reset(Request $req){
        $userDetail=User::where('email',$req->email)->first();
        if($userDetail){
            $otpData=Otp::where('user_id',$userDetail->id)->first();
            if($otpData){
                Otp::destroy($otpData->id);
            }
            $randomNumber = random_int(100000, 999999);
            $Otp=new Otp;
            $data=['value'=>$randomNumber];
            $user['to']=$req->email;
            Mail::send('mail', $data, function ($message) use ($user) {
                $message->to($user['to']);
                $message->subject('Reset Password');
            });
            $Otp->user_id=$userDetail->id;
            $Otp->otp=$randomNumber;
            $Otp->save();
            return to_route('otp',['id'=>$userDetail->id]);
        }else{
            return redirect('/');
        }

    }

    public function otp(Request $req,$id){
        $input=$req->all();
        if($input){
            $otpData=Otp::where('user_id',$id)->first();
            if($otpData->otp==$req->otp){
                return to_route('new-password',['id'=>$id]);
            }else{
                 $req->session()->flash('errorMessage','Please Enter Your Currect  Otp');
                 return to_route('otp',['id'=>$id]);
            }
        }else{
            return view('auth.otp');
        }
    }

    public function newPassword(Request $req,$id){
        $input=$req->all();
        if($input){
            $validate=$req->validate([
                'password' => 'required|min:6',
            ]);
            $sameUser=User::where('id',$id)->first();
            $otpData=Otp::where('user_id',$sameUser->id)->first();
            if($otpData){
                Otp::destroy($otpData->id);
                $sameUser->password=Crypt::encrypt($req->input('password'));
                $sameUser->save();
                return redirect('/login');
            }else{
                return redirect('/');
            }
        }else{
            return view('auth.resetpass');
        }
    }
}
