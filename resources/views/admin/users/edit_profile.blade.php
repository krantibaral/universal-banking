@extends('adminlte::page')

@push('styles')
    <style>
        .show-text {
            font-weight: bold;
            color: #333;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .card {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .card-header {
            background-color: #da0010;
            color: #fff;
            font-weight: bold;
            padding: 15px;
            border-radius: 8px 8px 0 0;
        }

        .btn-primary {
            background-color: #da0010;
            border-color: #da0010;
            color: #fff;
            font-weight: bold;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #000000;
            border-color: #000000;
        }

        .error-text {
            color: red;
            font-size: 0.875rem;
            margin-top: 5px;
        }

        .form-control {
            border-radius: 4px;
            border: 1px solid #ddd;
            padding: 8px 12px;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #da0010;
            box-shadow: 0 0 5px rgba(218, 0, 16, 0.3);
        }

        .form-label {
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .form-actions {
            margin-top: 1.5rem;
            text-align: right;
        }
    </style>
@endpush

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <br>
            <div class="card">
                <div class="card-header">
                    Edit Profile
                </div>
                <div class="card-body">
                    <form action="{{ route('users.updateProfile') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Name Field -->
                        <div class="form-group">
                            <label for="name" class="form-label show-text">Name:</label>
                            <input type="text" name="name" id="name" class="form-control" 
                                   value="{{ old('name', $user->name) }}">
                            @error('name')
                                <small class="error-text">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="form-group">
                            <label for="email" class="form-label show-text">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" 
                                   value="{{ old('email', $user->email) }}">
                            @error('email')
                                <small class="error-text">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
