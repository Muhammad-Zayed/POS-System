@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.users')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard">@lang('site.dashboard')</i></a></li>
                <li class="active"><i >@lang('site.users')</i></li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" style="margin-bottom: 15px">@lang('site.users')</h3>

                    <form action="">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')">
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i>@lang('site.search')</button>
                            <a class="btn btn-primary btn-sm" href="{{ route('dashboard.users.create') }}"><i class="fa fa-plus"></i> @lang('site.add')</a>
                        </div>
                        
                    </form>

                </div>
                
                <!-- Start Users Table-->
                    <div class="box-body">
                        @if($users->count())
                        
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('site.first_name')</th>
                                        <th>@lang('site.last_name')</th>
                                        <th>@lang('site.email')</th>
                                        <th>@lang('site.action')</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($users as $index => $user)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ $user->first_name }}</td>
                                            <td>{{ $user->last_name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <a class="btn btn-info btn-sm" href="{{ route('dashboard.users.edit' , $user->id) }}">@lang('site.edit')</a>
                                                
                                                <form style="display: inline-block" method="POST" action="{{ route('dashboard.users.destroy', $user->id) }}">
                                                    @csrf
                                                    @method('delete')

                                                    <button type="submit" class="btn btn-danger btn-sm">@lang('site.delete')</button>
                                                </form>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h2>@lang('site.no_data')</h2>
                        @endif
                        
                    </div>
              </div>
        </section>
    </div>
@endsection
