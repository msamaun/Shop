<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function categoryCreate(Request $request)
    {
        $user_id = Auth::id();
        $category_name = $request->input('name');
        $category_description = $request->input('description');

        $category_image = $request->file('image');
        $t = time();
        $file_name = $category_image->getClientOriginalName();
        $img_name = ("{$user_id}-{$t}-{$file_name}");
        $img_url = "images/{$img_name}";

        $category_image->move(public_path('images/'), $img_name);

        Category::create([
            'name' => $category_name,
            'description' => $category_description,
            'image' => $img_url,
            'user_id' => $user_id
        ]);
        return ResponseHelper::Out("Category Created Successfully",null,200);
    }

    public function categoryList()
    {
        $user_id = Auth::id();
        $categories = Category::where('user_id',$user_id)->get();
        return ResponseHelper::Out('Category List', $categories, 200);
    }

    public function categoryUpdate(Request $request)
    {
        $user_id = Auth::id();
        $category_id = $request->input('id');

        if($request->hasFile('image'))
        {
            $category_image = $request->file('image');
            $t = time();
            $file_name = $category_image->getClientOriginalName();
            $img_name = ("{$user_id}-{$t}-{$file_name}");
            $img_url = "images/{$img_name}";

            $category_image->move(public_path('images/'), $img_name);

            $filePath = $request->input('file_path');
            File::delete($filePath);

            return Category::where('id', $category_id)->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'image' => $img_url,
            ]);

        }else{
            return Category::where('id', $category_id)->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
            ]);
        }
    }

    public function categoryDelete(Request $request)
    {
        $user_id = Auth::id();
        $category_id = $request->input('id');
        $category = Category::where('id',$category_id)->where('user_id',$user_id)->first();
        $filePath = $category->image;
        File::delete($filePath);
        $category->delete();
        return ResponseHelper::Out('Category Deleted Successfully',null,200);
    }


    public function categoryById(Request $request)
    {
        $user_id = Auth::id();
        $category_id = $request->input('id');
        $category = Category::where('id',$category_id)->where('user_id',$user_id)->first();
        return ResponseHelper::Out('Category Details', $category, 200);
    }
}
