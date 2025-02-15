@extends('adminlte::page')

@section('css')
    @stack('styles')
@stop

@section('title', 'Show ' . $title)

@section('content_header')
    <h1>View {{ $title }}</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col">
                    <!-- general form elements -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>
                            <div class="float-right">
                                <div class="row">
                                    <div class="col-md-12">
                                     
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            @yield('form_content')
                        </div>

                        @if ($route != 'contacts.')
                            <div class="card-footer">
                                <a href="javascript:history.back();" class="btn btn-default float-right">Back</a>
                            </div>
                        @endif
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('js')
    @stack('scripts')
    <script>
        jQuery(document).ready(function() {
            $('#form input').attr('readonly', true);
            $('#form select').attr('disabled', true);
        });
    </script>
@stop
