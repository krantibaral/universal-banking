@extends('admin.templates.show')

@push('styles')
    <style>
        .show-text {
            font-weight: bold;
            color: #333;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-content {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #da0010;
            border-color: #da0010;
            color: #fff;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #000000;
            border-color: #000000;
        }
    </style>
@endpush

@section('form_content')
<div class="form-content">
    <div class="row">
        <div class="col-md-7">
            <!-- Name Field -->
            <div class="row form-group">
                <div class="col-md-3">
                    <label><span class="show-text">Name:</span></label>
                </div>
                <div class="col-md-8">
                    <span>{{ $item->name ?? 'N/A' }}</span>
                </div>
            </div>

            <!-- Email Field -->
            <div class="row form-group">
                <div class="col-md-3">
                    <label><span class="show-text">Email:</span></label>
                </div>
                <div class="col-md-8">
                    <span>{!! $item->email ?? '---' !!}</span>
                </div>
            </div>

            <!-- Account Number -->
            <div class="row form-group">
                <div class="col-md-3">
                    <label><span class="show-text">Account Number:</span></label>
                </div>
                <div class="col-md-8">
                    <span>{{ $customer->account_number ?? '---' }}</span>
                </div>
            </div>

            <!-- Total Balance -->
            <div class="row form-group">
                <div class="col-md-3">
                    <label><span class="show-text">Total Balance:</span></label>
                </div>
                <div class="col-md-8">
                    <span>{!! number_format($customer->total_balance, 2) ?? '---' !!}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Buttons Section -->
    <div class="row mt-4">
        <div class="col-md-7">
            <div class="text-left">
                <a href="{{ route('users.editProfile') }}" class="btn btn-primary">
                    Edit Profile
                </a>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-7">
            <div class="text-left">
                <a href="{{ route('users.changePasswordForm') }}" class="btn btn-primary">
                    Change Password
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
