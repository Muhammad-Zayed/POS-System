@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                @lang('site.categories')
            </h1>
            <ol class="breadcrumb">
              <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard">@lang('site.dashboard')</i></a></li>
              <li><a href="{{ route('dashboard.categories.index') }}">@lang('site.categories')</a></li>
              <li class="active">@lang('site.add')</li>

            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">@lang('site.add')</h3>
                </div>
                
                @include('partials._errors')

                <form method="POST" action="{{ route('dashboard.categories.store') }}"  role="form" enctype="multipart/form-data" >
                  @csrf
                    <div class="box-body">
                      <div class="form-group">
                        <label>@lang('site.category_name')</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                      </div>

                      {{--  <div class="form-group">
                        <label>@lang('site.image')</label>
                        <input type="file" name="image" class="form-control image-preview">
                      </div>

                      <div class="form-group">
                        <img style="width:100px; height:100px;" class=" img-thumbnail img-rounded image-preview-box" src="{{ asset('uploads/user_images/default.png')}}" >
                      </div>
                      </div>  --}}

                    </div>
                    

                    <div class="box-footer">
                      <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.add')</button>
                    </div>
                </form>
              </div>
        </section>
    </div>
@endsection
