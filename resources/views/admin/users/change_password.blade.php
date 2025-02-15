@extends('adminlte::page')

@section('title', 'Update Password')

@section('content_header')
<h1>Update Password</h1>
@stop

@section('css')
<style>
    .form-container {
        background-color: #ffffff;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .form-group label {
        font-weight: bold;
        color: #333;
    }
    .form-control {
        border-radius: 5px;
        border: 1px solid #ddd;
        transition: border-color 0.3s ease;
    }
    .form-control:focus {
        border-color: #da0010;
        box-shadow: 0 0 5px rgba(218, 0, 16, 0.3);
    }
    .input-group-append .btn {
        border-radius: 0 5px 5px 0;
        border-color: #ddd;
        background-color: #f8f9fa;
    }
    .input-group-append .btn:hover {
        background-color: #e9ecef;
    }
    .btn-success {
        background-color: #da0010;
        border-color: #da0010;
        font-weight: bold;
        padding: 0.5rem 1.5rem;
        border-radius: 5px;
    }
    .btn-success:hover {
        background-color: #b8000d;
        border-color: #b8000d;
    }
    .text-danger {
        color: #da0010 !important;
    }
    .toggle-password i {
        color: #da0010;
    }
</style>
@stack('styles')
@stop

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="form-container">
            <form action="{{ route('users.changePassword') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="new_password">New Password:</label>
                            <div class="input-group">
                                <input type="password" id="new_password" name="new_password" class="form-control" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary toggle-password" data-target="new_password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            @error('new_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="new_password_confirmation">Confirm New Password:</label>
                            <div class="input-group">
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary toggle-password" data-target="new_password_confirmation">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            @error('new_password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group text-right"> <!-- Changed to text-right -->
                    <button type="submit" class="btn btn-success">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</section>
@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function () {
                let input = document.getElementById(this.getAttribute('data-target'));
                let icon = this.querySelector('i');

                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.remove("fa-eye");
                    icon.classList.add("fa-eye-slash");
                } else {
                    input.type = "password";
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye");
                }
            });
        });
    });
</script>
@stop