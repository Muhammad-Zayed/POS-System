@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                @lang('site.products')
            </h1>
            <ol class="breadcrumb">
              <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard">@lang('site.dashboard')</i></a></li>
              <li><a href="{{ route('dashboard.products.index') }}">@lang('site.products')</a></li>
              <li class="active">@lang('site.edit')</li>

            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">@lang('site.edit')</h3>
                </div>

                @include('partials._errors')


                <form method="POST" action="{{ route('dashboard.products.update' , $product->id) }}"  enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="box-body">

                        <div class="form-group">

                            <label>@lang('site.category')</label>
                            <select style="padding:0px" name = "category_id" class="form-control">
                                <option value="">@lang('site.all_categories')</option>

                                @foreach($categories as $category)
                                    <option {{$product->category->id==$category->id ? 'selected' : ''}} value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>


                        @foreach(config('translatable.locales') as $lang)
                            <div class="form-group">
                                <label>@lang('site.'.$lang.'.product_name')</label>
                                <input  type="text" name="{{$lang}}[name]" class="form-control" value="{{ $product->name }}">
                            </div>

                            <div class="form-group">
                                <label>@lang('site.'.$lang.'.product_description')</label>
                                <textarea name="{{$lang}}[description]" class="form-control ckeditor" >
                                    {{ $product->description }}
                                </textarea>
                            </div>
                        @endforeach

                        <div class="form-group">
                            <label>@lang('site.image')</label>
                            <input  type="file" name="image" class="form-control image-preview">
                        </div>

                        <div class="form-group">
                            <img style="width:100px; height:100px;" class=" img-thumbnail img-rounded image-preview-box" src="{{$product->image_path}}" >
                        </div>

                        <div class="form-group">
                            <label>@lang('site.purchase_price')</label>
                            <input  type="number" name="purchase_price" class="form-control" value="{{ $product->purchase_price }}">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.sell_price')</label>
                            <input  type="number" name="sell_price" class="form-control" value="{{ $product->sell_price }}">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.stock')</label>
                            <input  type="number" name="stock" class="form-control" value="{{ $product->stock }}">
                        </div>
                    </div>


                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i>@lang('site.edit')</button>
                    </div>
                </form>

            </div>
        </section>
    </div>
@endsection
