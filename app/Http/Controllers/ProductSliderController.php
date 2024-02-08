<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\ProductSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductSliderController extends Controller
{
    public function productSliderCreate(Request $request)
    {

        $name = $request->input('title');
        $product_id = $request->input('product_id');
        $description = $request->input('short_description');
        $price = $request->input('price');
        $image = $request->file('image');
        $t = time();
        $file_name = $image->getClientOriginalName();
        $img_name = ("{$t}-{$file_name}");
        $img_url = "images/{$img_name}";

        $image->move(public_path('images/'), $img_name);

        ProductSlider::create([
            'title' => $name,
            'short_description' => $description,
            'price' => $price,
            'image' => $img_url,
            'product_id' => $product_id
        ]);
    }

    public function productSliderList()
    {

        $data = ProductSlider::all();
        return ResponseHelper::Out('Product Slider List', $data, 200);
    }

    public function productSliderUpdate(Request $request)
    {


        $name = $request->input('title');
        $product_id = $request->input('product_id');
        $description = $request->input('short_description');
        $price = $request->input('price');
        if ($request->hasFile('image')) {
        $image = $request->file('image');
        $t = time();
        $file_name = $image->getClientOriginalName();
        $img_name = ("{$t}-{$file_name}");
        $img_url = "images/{$img_name}";

        $image->move(public_path('images/'), $img_name);

        $filePath = $request->input('file_path');
        File::delete($filePath);

    ProductSlider::where('id', $request->input('id'))->update([
        'title' => $name,
        'short_description' => $description,
        'price' => $price,
        'image' => $img_url,
        'product_id' => $product_id
    ]);
       } else {

            ProductSlider::where('id', $request->input('id'))->update([
                'title' => $name,
                'short_description' => $description,
                'price' => $price,
                'product_id' => $product_id
            ]);
        }
    }

    public function productSliderDelete(Request $request)
    {
        $product = ProductSlider::where('id', $request->input('id'))->first();
        $filePath = $product->image;
        File::delete($filePath);
        $product->delete();
        return ResponseHelper::Out('Product Deleted Successfully', null, 200);
    }

    public function productSliderById(Request $request)
    {
        $product = ProductSlider::where('id', $request->input('id'))->first();
        return ResponseHelper::Out('Product Details', $product, 200);
    }


    public function productSlider()
    {
        $data = ProductSlider::all();
        return ResponseHelper::Out('Product Slider List', $data, 200);
    }
}
