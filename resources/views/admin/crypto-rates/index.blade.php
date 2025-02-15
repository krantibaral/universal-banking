@extends('adminlte::page')

@section('title', 'Crypto Rates')

@section('content_header')
    <h1>Crypto Rates</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('crypto-rates.update') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="bitcoin">Bitcoin Rate</label>
                    <input type="number" name="bitcoin" id="bitcoin" class="form-control" value="{{ $cryptoRate->bitcoin ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label for="dogecoin">Dogecoin Rate</label>
                    <input type="number" name="dogecoin" id="dogecoin" class="form-control" value="{{ $cryptoRate->dogecoin ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label for="trumpcoin">Trumpcoin Rate</label>
                    <input type="number" name="trump" id="trumpcoin" class="form-control" value="{{ $cryptoRate->trump ?? '' }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Update Crypto Rates</button>
            </form>
        </div>
    </div>
@stop
