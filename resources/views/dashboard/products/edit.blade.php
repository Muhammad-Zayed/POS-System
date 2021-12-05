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
              <li class="active">@lang('site.edit')</li>

            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">@lang('site.edit')</h3>
                </div>

                @include('partials._errors')

                <form method="POST" action="{{ route('dashboard.categories.update', $category->id) }}" >
                  @csrf
                  @method('PUT')
                    <div class="box-body">
                        @foreach(config('translatable.locales') as $lang)
                            <div class="form-group">
                                <label>@lang('site.'.$lang.'.category_name')</label>
                                <input type="text" name="{{$lang}}[name]" class="form-control" value="{{$category->translate($lang)->name}}">
                            </div>
                        @endforeach
                    </div>

                    <div class="box-footer">
                      <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i>@lang('site.edit')</button>
                    </div>
                </form>
              </div>
        </section>
    </div>
@endsection
