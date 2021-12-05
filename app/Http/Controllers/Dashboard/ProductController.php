<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $products = Product::paginate(10);
        return view('dashboard.products.index',compact('products'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create' , compact('categories'));
    }


    public function store(ProductRequest $request)
    {
        $productData = $request->all();

        if($request->hasFile('image')){
            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('uploads/product_images/'. $request->image->hashName()));
            $productData['image'] = $request->image->hashName();
        }

        Product::create($productData);

        session()->flash('success' , __('site.added_successfully'));
        return redirect()->route('dashboard.products.index');
    }

    public function show(Product $product)
    {
        //
    }


    public function edit(Product $product)
    {
        //
    }

    public function update(Request $request, Product $product)
    {
        //
    }

    public function destroy(Product $product)
    {
        //
    }
}
