@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.products')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard">@lang('site.dashboard')</i></a></li>
                <li class="active"><i >@lang('site.products')</i></li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" style="margin-bottom: 15px">@lang('site.products') <small>({{ $products->total() }})</small></h3>

                    <form action="{{ route('dashboard.products.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" value="{{ request()->search }}" placeholder="@lang('site.search')">
                            </div>


                            <div class="col-md-4">
                                <select name="category_id" style="padding: 0px" class="form-control">
                                    <option value="">@lang('site.all_categories')</option>
                                    @foreach($categories as $category)
                                    <option {{request()->category_id == $category->id ? 'selected' : ''}} value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i>@lang('site.search')</button>

                                @if (auth()->user()->hasPermission('products_create'))
                                    <a class="btn btn-primary btn-sm" href="{{ route('dashboard.products.create') }}"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                @else
                                    <button disabled class="btn btn-primary btn-sm"> <i class="fa fa-plus"></i> @lang('site.add')</button>
                                @endif
                            </div>

                        </div>

                    </form>

                </div>

                <!-- Start products Table-->
                    <div class="box-body">
                        @if($products->count())

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('site.product_name')</th>
                                        <th>@lang('site.product_description')</th>
                                        <th>@lang('site.category')</th>
                                        <th>@lang('site.image')</th>
                                        <th>@lang('site.purchase_price')</th>
                                        <th>@lang('site.sell_price')</th>
                                        <th>@lang('site.profit_percent')</th>
                                        <th>@lang('site.stock')</th>
                                        <th>@lang('site.action')</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($products as $index => $product)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{!! $product->description !!}</td>
                                            <td>{{ $product->category->name }}</td>
                                            <td><img style="width:50px; height:50px;" class=" img-thumbnail img-rounded" src="{{ $product->image_path }}" ></td>
                                            <td>{{ $product->purchase_price }}</td>
                                            <td>{{ $product->sell_price}}</td>
                                            <td>{{ $product->profit_percent}} %</td>
                                            <td>{{ $product->stock}}</td>

                                            <td>
                                                @if (auth()->user()->hasPermission('products_update'))
                                                    <a class="btn btn-info btn-sm" href="{{ route('dashboard.products.edit' , $product->id) }}"><i class="fa fa-edit"></i>@lang('site.edit')</a>
                                                @else
                                                     <button disabled class="btn btn-info btn-sm" ><i class="fa fa-edit"></i>@lang('site.edit')</button>
                                                @endif

                                                @if (auth()->user()->hasPermission('products_delete'))
                                                    <form style="display: inline-block" method="POST" action="{{ route('dashboard.products.destroy', $product->id) }}">
                                                        @csrf
                                                        @method('delete')

                                                        <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i>@lang('site.delete')</button>
                                                    </form>

                                                @else
                                                        <button disabled class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>@lang('site.delete')</button>
                                                @endif

                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $products->appends(request()->query())->links() }}
                        @else
                            <h2>@lang('site.no_data')</h2>
                        @endif

                    </div>
              </div>
        </section>
    </div>
@endsection
