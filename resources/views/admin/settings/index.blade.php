@extends('adminlte::page')

@section('title', 'Site Settings')

@section('content_header')
    <h1>Site Settings</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="site_name">Site Name</label>
                    <input type="text" name="site_name" id="site_name" class="form-control" value="{{ $settings->site_name ?? '' }}" required>
                </div>

         

                <div class="form-group">
                    <label for="color_scheme">Color Scheme</label>
                    <input type="color" name="color_scheme" id="color_scheme" class="form-control" value="{{ $settings->color_scheme ?? '#da0010' }}">
                </div>

                <button type="submit" class="btn btn-primary">Update Settings</button>
            </form>
        </div>
    </div>
@stop