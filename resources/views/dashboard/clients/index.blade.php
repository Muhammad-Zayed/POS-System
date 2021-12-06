@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.categories')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard">@lang('site.dashboard')</i></a></li>
                <li class="active"><i >@lang('site.clients')</i></li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" style="margin-bottom: 15px">@lang('site.clients') <small>({{ $clients->count() }})</small></h3>

                    <form action="{{ route('dashboard.clients.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" value="{{ request()->search }}" placeholder="@lang('site.search')">
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i>@lang('site.search')</button>

                            @if (auth()->user()->hasPermission('clients_create'))
                                <a class="btn btn-primary btn-sm" href="{{ route('dashboard.clients.create') }}"><i class="fa fa-plus"></i> @lang('site.add')</a>
                            @else
                                <button disabled class="btn btn-primary btn-sm"> <i class="fa fa-plus"></i> @lang('site.add')</button>
                            @endif
                        </div>

                    </form>

                </div>

                <!-- Start clients Table-->
                    <div class="box-body">
                        @if($clients->count())

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('site.name')</th>
                                        <th>@lang('site.phone')</th>
                                        <th>@lang('site.address')</th>
                                        <th>@lang('site.add_order')</th>
                                        <th>@lang('site.action')</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($clients as $index => $client)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ $client->name }}</td>
                                            <td>{{ $client->phone }}</td>
                                            <td>{{ $client->address }}</td>
                                            <td>
                                                @if (auth()->user()->hasPermission('orders_update'))
                                                    <a class="btn btn-primary btn-sm" href="{{ route('dashboard.clients.orders.create' , $client->id) }}"><i class="fa fa-edit"></i>@lang('site.add')</a>
                                                @else
                                                    <button disabled class="btn btn-primary btn-sm" ><i class="fa fa-edit"></i>@lang('site.add')</button>
                                                @endif
                                            </td>

                                            <td>
                                                @if (auth()->user()->hasPermission('clients_update'))
                                                    <a class="btn btn-info btn-sm" href="{{ route('dashboard.clients.edit' , $client->id) }}"><i class="fa fa-edit"></i>@lang('site.edit')</a>
                                                @else
                                                     <button disabled class="btn btn-info btn-sm" ><i class="fa fa-edit"></i>@lang('site.edit')</button>
                                                @endif


                                                @if (auth()->user()->hasPermission('clients_delete'))
                                                    <form style="display: inline-block" method="POST" action="{{ route('dashboard.clients.destroy', $client->id) }}">
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
                            {{ $clients->appends(request()->query())->links() }}
                        @else
                            <h2>@lang('site.no_data')</h2>
                        @endif

                    </div>
              </div>
        </section>
    </div>
@endsection
