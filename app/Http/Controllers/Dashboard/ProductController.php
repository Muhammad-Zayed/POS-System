<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::all();
        $products = Product::Search()->Filter()->with('category')->latest()->paginate(10);
        return view('dashboard.products.index',compact('products' , 'categories'));
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
        $categories = Category::all();
        return view('dashboard.products.edit' , compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $productData = $request->all();

        if($request->hasFile('image')){

            if($product->image != 'default.png'){
                Storage::disk('public_uploads')->delete('/product_images/'.$product->image);
            }

            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('uploads/product_images/'. $request->image->hashName()));
            $productData['image'] = $request->image->hashName();
        }

        $product->update($productData);

        session()->flash('success' , __('site.updated_successfully'));
        return redirect()->route('dashboard.products.index');
    }

    public function destroy(Product $product)
    {
        if($product->image != 'default.png'){
            Storage::disk('public_uploads')->delete('/product_images/'.$product->image);
        }
        $product->delete();

        session()->flash('success' , __('site.deleted_successfully'));
        return redirect()->route('dashboard.products.index');
    }
}
