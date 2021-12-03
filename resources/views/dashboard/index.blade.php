@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Hello Page
                <small>Iam here </small>
            </h1>
            <ol>
                <li class="active"><i class="fa fa-dashboard">@lang('site.dashboard')</i></li>
            </ol>
        </section>

        <section class="content">
            <h1>This is Dashboard</h1>
        </section>
    </div>
@endsection
