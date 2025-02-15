@extends('adminlte::page')

@php
    // Fetch settings from the database
    $settings = \App\Models\Settings::first();
@endphp

{{-- Extend and customize the browser title --}}
@section('title')
{{ $settings->site_name ?? config('adminlte.title') }}
@hasSection('subtitle') | @yield('subtitle') @endif
@stop

{{-- Extend and customize the page content header --}}
@section('content_header')
@hasSection('content_header_title')
    <h1 class="text-muted">
        @yield('content_header_title')

        @hasSection('content_header_subtitle')
            <small class="text-dark">
                <i class="fas fa-xs fa-angle-right text-muted"></i>
                @yield('content_header_subtitle')
            </small>
        @endif
    </h1>
@endif
@stop

{{-- Rename section content to content_body --}}
@section('content')
@yield('content_body')
@stop

{{-- Create a common footer --}}
@section('footer')
<div class="float-right">
    Version: {{ config('app.version', '1.0.0') }}
</div>

<strong>
    <a href="{{ config('app.company_url', '#') }}">
        {{ $settings->site_name ?? config('app.company_name', 'Universal Banking') }}
    </a>
</strong>
@stop

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            // Custom scripts if needed
        });
    </script>
@endpush


{{-- Add common CSS customizations --}}
@push('css')
    <style type="text/css">
        {
                {
                -- Apply dynamic color scheme --
            }
        }

        :root {
            --primary-color:
                {{ $settings->color_scheme ?? '#da0010' }}
            ;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color:
                {{ $settings->color_scheme ? 'rgba(' . implode(',', sscanf($settings->color_scheme, "#%02x%02x%02x")) . ', 0.8)' : '#b8000d' }}
            ;
            border-color:
                {{ $settings->color_scheme ? 'rgba(' . implode(',', sscanf($settings->color_scheme, "#%02x%02x%02x")) . ', 0.8)' : '#b8000d' }}
            ;
        }

            {
                {
                -- You can add AdminLTE customizations here --
            }
        }

        /*
        .card-header {
            border-bottom: none;
        }
        .card-title {
            font-weight: 600;
        }
        */
    </style>
@endpush