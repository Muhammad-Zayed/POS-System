<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {

        // Search Is Local scope
        $categories = Category::Search()->latest()->Paginate(10);
        return view('dashboard.categories.index',compact('categories'));
    }


    public function create()
    {
        return view('dashboard.categories.create');
    }

    public function store(CategoryRequest $request)
    {
        //dd($request->all());
        Category::create($request->all());

        session()->flash('success' , __('site.added_successfully'));
        return redirect()->route('dashboard.categories.index');
    }

    public function edit(Category $category)
    {
        return view('dashboard.categories.edit' , compact('category'));
    }


    public function update(CategoryRequest $request, Category $category)
    {

        $category->update($request->all());
        session()->flash('success' , __('site.updated_successfully'));
        return redirect()->route('dashboard.categories.index');
    }


    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('success' , __('site.deleted_successfully'));
        return redirect()->route('dashboard.categories.index');
    }
}
