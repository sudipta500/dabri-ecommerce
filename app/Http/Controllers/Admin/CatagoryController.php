<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use Illuminate\Http\Request;

class CatagoryController extends Controller
{
    public function index(){
        $catagoryAll= Category::paginate(10);
        // $catagoryAll= Category::all();
        return view('dabri.pages.catagory.catagory',['catagory'=>$catagoryAll]);
    }
    public function createView(){
        return view('dabri.pages.catagory.create_catagory');
    }
    public function createData(Request $req ){
        $sameCatagory=Category::where('category_name',$req->post('category'))->get();
       if(isset($sameCatagory[0])){
            $req->session()->flash('errorMessage','This Catagory is already created');
            return redirect('admin/create-catagory');
       }else{
            $validate=$req->validate([
                'category' => 'required',
            ]);
            $category=new Category;
                $category->category_name=$req->category;
                $category->save();
                $req->session()->flash('success','New Category Added');
                return redirect('admin/catagory');
       }
    }

    public function editView($id){
        $category=Category::find($id);
        return view('dabri.pages.catagory.edit_catagory',['catagory'=> $category]);
    }

    // public function showCategory($id)
    // {
    //     $category=Category::find($id);
    //     return view('dabri.pages.catagory.edit_catagory',['category'=> $category]);

    // }
    public function editData(Request $req,$id){
        $catagory=Category::find($id);
        $validate=$req->validate([
            'catagory' => 'required',
        ]);
        $catagory->category_name=$req->catagory;
        $catagory->save();
        $req->session()->flash('success','Category Edit Successfully');
        return redirect('admin/catagory');
    }

    public function destroy($id)
    {
        Category::destroy($id);
        return redirect('admin/catagory');

    }
}
