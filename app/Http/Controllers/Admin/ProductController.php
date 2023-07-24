<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\product;
use App\Models\Admin\Category;
use App\Models\Admin\PacketSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Admin\MoreProduct;

class ProductController extends Controller
{
    public function home()
    {
        // $catagoryAll= Category::with('product')->where('id',2)->first();
        // return $catagoryAll;
        $product =product::all()->take(4);
       return view('user.pages.home',['product'=>$product]);
    }
    public function index()
    {
        // $catagoryAll= Category::with('product')->where('id',2)->first();
        // return $catagoryAll;
        $product =product::with('category','packetSize')->get();
       return view('dabri.pages.Product.product',['product'=>$product]);
    }

    public function viewProduct()
    {
        $catagoryAll= Category::all();
        $packetSizeAll= PacketSize::all();
       return view('dabri.pages.Product.product-create',['catagory'=>$catagoryAll,'packetSize'=>$packetSizeAll]);
    }

    public function createProduct(Request $request)
    {
        $validateImageData = $request->validate([
            'flavour_name' => 'required',
            'ingredient' => 'required',
            'description' => 'required',
            'benefits' => 'required',
            'consume' => 'required',
            ]);
        $fileName= time().'.'.$request->one_image->extension();
        $request->one_image->move(public_path('images'), $fileName);

        foreach ($request->addmore as $key => $value) {
        $productattr['flavour_name']=$request->flavour_name;
        $productattr['ingredient']=$request->ingredient;
        $productattr['description']=$request->description;
        $productattr['benefits']=$request->benefits;
        $productattr['consume']=$request->consume;
        $productattr['one_image']=$fileName;
        $productattr['category_id']=$request->category_id;
        $productattr['packating_type']=$value['packating_type'];
        $productattr['packet_size_id']=$value['packet_size_id'];
        $productattr['mrp']=$value['mrp'];
        $productattr['offer_mrp']=$value['offer_mrp'];
        DB::table('products')->insert($productattr);
        }
        return redirect('/admin/product')->with('status', 'All Data has been uploaded successfully');
            // if($request->hasFile('images'))
            //  {
            //     foreach($request->file('images') as $key => $file)
            //     {
            //         $image_name=md5(rand(1000,10000));
            //         $exe=strtolower($file->getClientOriginalExtension());
            //         $path =$image_name.'.'. $exe;
            //         $file->move(public_path('images'), $path);
            //         $insert[] = $path;
            //     }
            //    $imagesFile= implode('|',$insert);
            //    $product->images=$imagesFile;
            //    $product->save();


            //  }else{
                // return redirect('/admin/create-product')->with('errorMessage', 'Product Data can not be insert');
            //  }
    }
    public function editProduct($id){
        $product=product::where('id',$id)->with('category','packetSize')->first();
        $catagoryAll= Category::all();
        $packetSizeAll= PacketSize::all();
        // return $product;
        return view('dabri.pages.Product.editproduct',['product'=>$product,'category'=>$catagoryAll,'packet'=>$packetSizeAll]);
    }

    public function edit(Request $request,$id){
        $product=product::where('id',$id)->first();
        if($request->one_image){
        $fileName= time().'.'.$request->one_image->extension();
        $request->one_image->move(public_path('images'), $fileName);
        $product->flavour_name=$request->flavour_name;
        $product->ingredient=$request->ingredient;
        $product->description=$request->description;
        $product->benefits=$request->benefits;
        $product->consume=$request->consume;
        $product->one_image=$fileName;
        $product->category_id=$request->category_id;
        $product->packating_type=$request->packating_type;
        $product->packet_size_id=$request->packet_size_id;
        $product->mrp=$request->mrp;
        $product->offer_mrp=$request->offer_mrp;
        $product->save();
        return redirect('admin/product');
        }else{
        $product->flavour_name=$request->flavour_name;
        $product->ingredient=$request->ingredient;
        $product->description=$request->description;
        $product->benefits=$request->benefits;
        $product->consume=$request->consume;
        $product->category_id=$request->category_id;
        $product->packating_type=$request->packating_type;
        $product->packet_size_id=$request->packet_size_id;
        $product->mrp=$request->mrp;
        $product->offer_mrp=$request->offer_mrp;
        $product->save();
       return redirect('admin/product');
        }
    }

    public function destroy($id){
        $image=product::find($id);
        $allImage=MoreProduct::where('product_id',$id)->get();
        foreach ($allImage as $key => $value) {
            $imageSrting = 'images/'.$value->Product_image;
            if(File::exists($imageSrting)){
                MoreProduct::destroy($value->id);
                File::delete($imageSrting);
            }
        }
        product::destroy($id);
        $imageSrting = 'images/'.$image->one_image;
        if(File::exists($imageSrting)){
            File::delete($imageSrting);
        }
        return redirect('admin/product');
    }

    public function imageShow($id){
        // return $id;
        $allImage=MoreProduct::where('product_id',$id)->get();
        return view('dabri.pages.Product.addimage',['id'=>$id,'allimage'=> $allImage]);
    }
    public function createimage($id){
        return view('dabri.pages.Product.createImage');
    }
    public function imageAdd(Request $request,$id){

        $fileName= time().'.'.$request->Product_image->extension();
        $request->Product_image->move(public_path('images'), $fileName);
        $image=new MoreProduct;
        $image->product_id=$id;
        $image->Product_image= $fileName;
        $image->save();
        return back();
    }
    public function editImage($id){
        $image=MoreProduct::find($id);
        return view('dabri.pages.Product.editImage',['image'=> $image]);
    }
    public function editImages(Request $request,$id){
        $fileName= time().'.'.$request->Product_image->extension();
        $request->Product_image->move(public_path('images'), $fileName);
        $image=MoreProduct::find($id);
        $imageSrting = 'images/'.$image->Product_image;
        if(File::exists($imageSrting)){
            File::delete($imageSrting);
        }
        $image->Product_image= $fileName;
        $image->save();
        return back();
    }


}
