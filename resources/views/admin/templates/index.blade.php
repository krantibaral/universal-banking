@extends('adminlte::page')

@section('title', $title)

@section('content_header')
<h1>{{ $title }} List</h1>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
@stack('styles')
@stop

@section('js')
@stack('scripts')
@stop

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $title }}</h3>
                        @if (
                            !isset($hideCreate) && !auth()->user()->hasRole('Customer')
                        )
                            <a href="{{ route($route . 'create') }}" class="btn btn-primary float-right">
                                <i class="fa fa-plus"></i>
                                <span class="kt-hidden-mobile">
                                    {{ Route::is('transfers.*') ? 'Make Payment' : 'Add New' }}
                                </span>
                            </a>
                        @endif
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @yield('index_content')
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
@endsection