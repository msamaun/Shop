<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Brand;
use App\Models\Category;

class ProductController extends Controller
{
    public function productCreate(Request $request)
    {
        $user_id = Auth::id();
        $brand_id = $request->input('brand_id');
        $category_id = $request->input('category_id');
        $product_name = $request->input('name');
        $description = $request->input('description');
        $price = $request->input('price');
        $discount = $request->input('discount');
        $discount_price = $request->input('discount_price');
        $stock = $request->input('stock');
        $star = $request->input('star');
        $remark = $request->input('remark');

        $image = $request->file('image');
        $t = time();
        $file_name = $image->getClientOriginalName();
        $img_name = ("{$user_id}-{$t}-{$file_name}");
        $img_url = "images/{$img_name}";

        $image->move(public_path('images/'), $img_name);

        Product::create([
            'name' => $product_name,
            'description' => $description,
            'price' => $price,
            'discount' => $discount,
            'discount_price' => $discount_price,
            'stock' => $stock,
            'star' => $star,
            'remark' => $remark,
            'image' => $img_url,
            'brand_id' => $brand_id,
            'category_id' => $category_id,
            'user_id' => $user_id
        ]);

        return ResponseHelper::Out("Product Created Successfully",null,200);

    }

    public function productList()
    {
        $user_id = Auth::id();
        $products = Product::where('user_id',$user_id)->get();


        return ResponseHelper::Out('Product List', $products, 200);
    }

    public function productUpdate(Request $request)
    {
       $user_id = Auth::id();
       $product_id = $request->input('id');

       if ($request->hasFile('image')) {
           $product_image = $request->file('image');
           $t = time();
           $file_name = $product_image->getClientOriginalName();
           $img_name = ("{$user_id}-{$t}-{$file_name}");
           $img_url = "images/{$img_name}";

           $product_image->move(public_path('images/'), $img_name);

           $filePath = $request->input('file_path');
           File::delete($filePath);

           Product::where('id', $product_id)->update([
               'name' => $request->input('name'),
               'description' => $request->input('description'),
               'price' => $request->input('price'),
               'discount' => $request->input('discount'),
               'discount_price' => $request->input('discount_price'),
               'stock' => $request->input('stock'),
               'star' => $request->input('star'),
               'remark' => $request->input('remark'),
               'image' => $img_url,
               'user_id' => $user_id
           ]);
       }
       else {
           Product::where('id', $product_id)->update([
               'name' => $request->input('name'),
               'description' => $request->input('description'),
               'price' => $request->input('price'),
               'discount' => $request->input('discount'),
               'discount_price' => $request->input('discount_price'),
               'stock' => $request->input('stock'),
               'star' => $request->input('star'),
               'remark' => $request->input('remark'),
               'user_id' => $user_id
           ]);
       }
    }

    public function productDelete(Request $request)
    {
        $user_id = Auth::id();
        $product_id = $request->input('id');
        $product = Product::where('id',$product_id)->where('user_id',$user_id)->first();
        $filePath = $product->image;
        File::delete($filePath);
        $product->delete();
        return ResponseHelper::Out('Product Deleted Successfully',null,200);
    }

    public function productById(Request $request)
    {
        $user_id = Auth::id();
        $product_id = $request->input('id');
        $product = Product::where('id',$product_id)->where('user_id',$user_id)->first();
        return ResponseHelper::Out('Product Details', $product, 200);
    }
}
