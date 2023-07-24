<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\product;
use App\Models\Admin\Category;


class ShopController extends Controller
{
    public function index(Request $req){
        $catagoryAll= Category::all();
        if($req->search){
            $searchItem=$_GET['search'];
            $product =product::where('flavour_name','LIKE',"%$searchItem%")->paginate(10);
            return view('user.pages.shop',['product'=>$product,'category'=>$catagoryAll]);
        }else{
            if($req->categoryFilter){
                $checked= $_GET['categoryFilter'];
                // return $checked;
                $product =product::whereIn('category_id', $checked)->paginate(10);
                return view('user.pages.shop',['product'=>$product,'category'=>$catagoryAll]);
            }else{
                $product =product::with('category')->paginate(10);
                return view('user.pages.shop',['product'=>$product,'category'=>$catagoryAll]);
            }
        }


    }
    public function cata($id,Request $req){
        $catagoryAll= Category::all();
        if($req->search){
            $searchItem=$_GET['search'];
            $product =product::where('flavour_name','LIKE',"%$searchItem%")->paginate(10);
            return view('user.pages.shop',['product'=>$product,'category'=>$catagoryAll]);
        }else{
            if($req->categoryFilter){
                $checked= $_GET['categoryFilter'];
                // return $checked;
                $product =product::whereIn('category_id', $checked)->paginate(10);
                return view('user.pages.shop',['product'=>$product,'category'=>$catagoryAll]);
            }else{
                $product =product::where('category_id', $id)->paginate(10);
                return view('user.pages.shop',['product'=>$product,'category'=>$catagoryAll]);
            }
        }

    }
}
