<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    public function brandCreate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);
        $user_id = Auth::id();
        $brand_name = $request->input('name');
        $brand_description = $request->input('description');

        $brand_image = $request->file('image');
        $t = time();
        $file_name = $brand_image->getClientOriginalName();
        $img_name = ("{$user_id}-{$t}-{$file_name}");
        $img_url = "images/{$img_name}";

        $brand_image->move(public_path('images/'), $img_name);

        Brand::create([
            'name' => $brand_name,
            'description' => $brand_description,
            'image' => $img_url,
            'user_id' => $user_id
        ]);

        return ResponseHelper::Out("Brand Created Successfully",null,200);

    }

    public function brandList()
    {
        $user_id = Auth::id();
        $brands = Brand::where('user_id',$user_id)->get();
        return ResponseHelper::Out('Brand List', $brands, 200);
    }

    public function brandUpdate(Request $request)
    {
        $user_id = Auth::id();
        $brand_id = $request->input('id');

        if($request->hasFile('image'))
        {
            $brand_image = $request->file('image');
            $t = time();
            $file_name = $brand_image->getClientOriginalName();
            $img_name = ("{$user_id}-{$t}-{$file_name}");
            $img_url = "images/{$img_name}";

            $brand_image->move(public_path('images/'), $img_name);

            $filePath = $request->input('file_path');
            File::delete($filePath);

            return Brand::where('id', $brand_id)->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'image' => $img_url,
            ]);

        }else{
            return Brand::where('id', $brand_id)->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
            ]);
        }


    }


    public function brandDelete(Request $request)
    {
        $user_id = Auth::id();
        $brand_id = $request->input('id');
        $brand = Brand::where('id',$brand_id)->where('user_id',$user_id)->first();
        $filePath = $brand->image;
        File::delete($filePath);
        $brand->delete();
        return ResponseHelper::Out('Brand Deleted Successfully',null,200);
    }


    public function brandById(Request $request)
    {
        $user_id = Auth::id();
        $brand_id = $request->input('id');
        $brand = Brand::where('id',$brand_id)->where('user_id',$user_id)->first();
        return ResponseHelper::Out('Brand Details', $brand, 200);
    }



    public function productByBrand()
    {
        $data = Brand::all();
        return ResponseHelper::Out('Brand List', $data, 200);
    }
}
