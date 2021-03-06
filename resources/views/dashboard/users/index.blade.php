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
                  <h3 class="box-title" style="margin-bottom: 15px">@lang('site.users') <small>({{ $users->total() }})</small></h3>

                    <form action="{{ route('dashboard.users.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" value="{{ request()->search }}" placeholder="@lang('site.search')">
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i>@lang('site.search')</button>
                            
                            @if (auth()->user()->hasPermission('users_create'))
                                <a class="btn btn-primary btn-sm" href="{{ route('dashboard.users.create') }}"><i class="fa fa-plus"></i> @lang('site.add')</a>                                
                            @else
                                <button disabled class="btn btn-primary btn-sm"> <i class="fa fa-plus"></i> @lang('site.add')</button>
                            @endif
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
                                        <th>@lang('site.image')</th>
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
                                            <td><img style="width:50px; height:50px;" class=" img-thumbnail img-rounded" src="{{ $user->image_path }}" ></td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if (auth()->user()->hasPermission('users_update'))
                                                    <a class="btn btn-info btn-sm" href="{{ route('dashboard.users.edit' , $user->id) }}"><i class="fa fa-edit"></i>@lang('site.edit')</a>                                                    
                                                @else
                                                     <button disabled class="btn btn-info btn-sm" ><i class="fa fa-edit"></i>@lang('site.edit')</button>
                                                @endif
                                                

                                                @if (auth()->user()->hasPermission('users_delete'))
                                                    <form style="display: inline-block" method="POST" action="{{ route('dashboard.users.destroy', $user->id) }}">
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
                            {{ $users->appends(request()->query())->links() }}
                        @else
                            <h2>@lang('site.no_data')</h2>
                        @endif
                        
                    </div>
              </div>
        </section>
    </div>
@endsection
