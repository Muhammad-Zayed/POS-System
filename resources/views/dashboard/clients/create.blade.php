@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                @lang('site.clients')
            </h1>
            <ol class="breadcrumb">
              <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard">@lang('site.dashboard')</i></a></li>
              <li><a href="{{ route('dashboard.clients.index') }}">@lang('site.clients')</a></li>
              <li class="active">@lang('site.add')</li>

            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">@lang('site.add')</h3>
                </div>

                @include('partials._errors')

                <form method="POST" action="{{ route('dashboard.clients.store') }}" >
                  @csrf
                    <div class="box-body">

                            <div class="form-group">
                                <label>@lang('site.name')</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            </div>

                            <div class="form-group">
                                <label>@lang('site.phone')</label>
                                <input type="text" name="phone" class="form-control"  value="{{ old('phone') }}">
                            </div>

                            <div class="form-group">
                                <label>@lang('site.address')</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                            </div>

                    </div>


                    <div class="box-footer">
                      <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.add')</button>
                    </div>
                </form>
              </div>
        </section>
    </div>
@endsection
