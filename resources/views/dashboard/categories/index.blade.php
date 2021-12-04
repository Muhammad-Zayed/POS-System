@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.categories')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard">@lang('site.dashboard')</i></a></li>
                <li class="active"><i >@lang('site.categories')</i></li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" style="margin-bottom: 15px">@lang('site.categories') <small>({{ $categories->total() }})</small></h3>

                    <form action="{{ route('dashboard.categories.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" value="{{ request()->search }}" placeholder="@lang('site.search')">
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i>@lang('site.search')</button>
                            
                            @if (auth()->user()->hasPermission('categories_create'))
                                <a class="btn btn-primary btn-sm" href="{{ route('dashboard.categories.create') }}"><i class="fa fa-plus"></i> @lang('site.add')</a>                                
                            @else
                                <button disabled class="btn btn-primary btn-sm"> <i class="fa fa-plus"></i> @lang('site.add')</button>
                            @endif
                        </div>
                        
                    </form>

                </div>
                
                <!-- Start categories Table-->
                    <div class="box-body">
                        @if($categories->count())
                        
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('site.category_name')</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($categories as $index => $category)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ $category->name }}</td>
                                            {{--  <td><img style="width:50px; height:50px;" class=" img-thumbnail img-rounded" src="{{ $category->image_path }}" ></td>  --}}
                                            <td>
                                                @if (auth()->user()->hasPermission('categories_update'))
                                                    <a class="btn btn-info btn-sm" href="{{ route('dashboard.categories.edit' , $category->id) }}"><i class="fa fa-edit"></i>@lang('site.edit')</a>                                                    
                                                @else
                                                     <button disabled class="btn btn-info btn-sm" ><i class="fa fa-edit"></i>@lang('site.edit')</button>
                                                @endif
                                                

                                                @if (auth()->user()->hasPermission('categories_delete'))
                                                    <form style="display: inline-block" method="POST" action="{{ route('dashboard.categories.destroy', $category->id) }}">
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
                            {{ $categories->appends(request()->query())->links() }}
                        @else
                            <h2>@lang('site.no_data')</h2>
                        @endif
                        
                    </div>
              </div>
        </section>
    </div>
@endsection
