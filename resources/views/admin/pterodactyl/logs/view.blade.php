@extends('admin.layouts.page')

@section('title', 'Log')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
    <h1>@yield('title')</h1>
    </div>
</div>
@endsection

@section('content')
@include('layouts.errors')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h6>Log #{{ $log->id }}</h6>
            </div>
            <div class="card-body">
                <code>{!! $log->result !!}</code>
            </div>
        </div>
    </div>
</div>
@endsection