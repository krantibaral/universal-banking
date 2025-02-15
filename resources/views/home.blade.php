@extends('layouts.app')

@section('subtitle', 'Dashboard')

@section('content_body')
<br>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg">
                <div class="card-header" style="background-color: var(--primary-color); color: white;">
                    <h4 class="mb-0">Dashboard</h4>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        <h3>Welcome, {{ Auth::user()->name }}!</h3>
                        <p class="text-muted">Here's a summary of your account activity.</p>
                    </div>

                    @if (Auth::user()->hasRole('Admin'))
                        <!-- Admin-specific content -->
                        <!-- <div class="text-center">
                                <h4>Welcome to the Admin Dashboard</h4>
                                <p class="text-muted">You have administrative privileges.</p>
                            </div> -->
                    @else
                        <!-- Customer-specific content -->
                        <div class="row">
                            <!-- Left Column: Total Balance and Bought Cryptocurrencies -->
                            <div class="col-md-8">
                                <!-- Display Total Balance -->
                                <div class="card bg-light mb-4 shadow-sm">
                                    <div class="card-body text-start">
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="fas fa-wallet fa-lg text-secondary me-2"></i>
                                            <!-- Smaller icon, light grey color, reduced spacing -->
                                            <h1 class="card-title mb-0"><strong> Total Balance</strong></h1>
                                        </div>

                                        <!-- Balance Amount -->
                                        <h2 class="text-success fw-bold">${{ number_format($totalBalance, 2) }}</h2>
                                        <small class="text-muted">Your current available balance.</small>
                                    </div>
                                </div>

                                <!-- Display Bought Cryptocurrencies -->
                                <div class="card bg-light mb-4 shadow-sm">
                                    <div class="card-body">
                                        <h1 class="card-title"><strong>Bought Cryptocurrencies</strong></h1>

                                        <br>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">Bitcoin</h6>
                                                </div>
                                                <span class="badge bg-success rounded-pill">
                                                    ${{ number_format($cryptoBalances['bitcoin'], 2) }}
                                                </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">Dogecoin</h6>
                                                </div>
                                                <span class="badge bg-success rounded-pill">
                                                    ${{ number_format($cryptoBalances['dogecoin'], 2) }}
                                                </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">Trump</h6>
                                                </div>
                                                <span class="badge bg-success rounded-pill">
                                                    ${{ number_format($cryptoBalances['trump'], 2) }}
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Today's Rates -->
                            <div class="col-md-4">
                                <div class="card bg-light mb-4 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title"><strong>Today's Rates</strong></h5>
                                        <br>
                                        <!-- Vertical layout for non-Admin users -->
                                        <div class="row text-center">
                                            <div class="col-12 mb-3">
                                                <div class="p-3 border rounded bg-white shadow-sm">
                                                    <i class="fab fa-bitcoin text-warning fa-2x"></i>
                                                    <h6 class="mt-2">Bitcoin</h6>
                                                    <p class="mb-0 text-success fw-bold">
                                                        ${{ number_format($todayRates['bitcoin'], 2) }}</p>
                                                    <!-- Buy Button triggers modal -->
                                                    <button class="btn btn-sm btn-primary mt-2" data-bs-toggle="modal"
                                                        data-bs-target="#buyModal" data-crypto="bitcoin">
                                                        Buy
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="p-3 border rounded bg-white shadow-sm">
                                                    <i class="fab fa-dyalog text-info fa-2x"></i>
                                                    <h6 class="mt-2">Dogecoin</h6>
                                                    <p class="mb-0 text-success fw-bold">
                                                        ${{ number_format($todayRates['dogecoin'], 2) }}</p>
                                                    <button class="btn btn-sm btn-primary mt-2" data-bs-toggle="modal"
                                                        data-bs-target="#buyModal" data-crypto="dogecoin">
                                                        Buy
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="p-3 border rounded bg-white shadow-sm">
                                                    <i class="fas fa-coins text-primary fa-2x"></i>
                                                    <h6 class="mt-2">Trump</h6>
                                                    <p class="mb-0 text-success fw-bold">
                                                        ${{ number_format($todayRates['trump'], 2) }}</p>
                                                    <button class="btn btn-sm btn-primary mt-2" data-bs-toggle="modal"
                                                        data-bs-target="#buyModal" data-crypto="trump">
                                                        Buy
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Buy Modal -->
                        <div class="modal fade" id="buyModal" tabindex="-1" aria-labelledby="buyModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="buyModalLabel">Buy Cryptocurrency</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="{{ route('buy.crypto') }}">
                                        @csrf
                                        <div class="modal-body">
                                            <!-- Quantity Input -->
                                            <div class="form-group mb-3">
                                                <label for="quantity">Quantity</label>
                                                <input type="number" class="form-control" id="quantity" name="quantity"
                                                    placeholder="Enter quantity" required min="0.01" step="0.01">
                                            </div>

                                            <!-- Total Cost Display -->
                                            <div class="form-group mb-3">
                                                <label for="total_cost">Total Cost</label>
                                                <input type="text" class="form-control" id="total_cost" name="total_cost"
                                                    readonly>
                                            </div>

                                            <!-- Hidden Input for Crypto Type -->
                                            <input type="hidden" id="crypto_type" name="crypto_type" value="">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Buy</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                // Get the current rates from the backend
                                const todayRates = @json($todayRates);

                                // Function to calculate total cost
                                function calculateTotalCost(quantity, cryptoType) {
                                    const rate = todayRates[cryptoType];
                                    return (quantity * rate).toFixed(2);
                                }

                                // Set crypto type and calculate total cost when the modal is opened
                                var buyButtons = document.querySelectorAll('[data-bs-target="#buyModal"]');
                                buyButtons.forEach(function (button) {
                                    button.addEventListener('click', function () {
                                        var cryptoType = button.getAttribute('data-crypto');
                                        document.getElementById('crypto_type').value = cryptoType;

                                        // Reset quantity and total cost
                                        document.getElementById('quantity').value = '';
                                        document.getElementById('total_cost').value = '';

                                        // Add event listener to quantity input
                                        document.getElementById('quantity').addEventListener('input', function () {
                                            const quantity = parseFloat(this.value);
                                            if (!isNaN(quantity)) {
                                                const totalCost = calculateTotalCost(quantity, cryptoType);
                                                document.getElementById('total_cost').value = `$${totalCost}`;
                                            } else {
                                                document.getElementById('total_cost').value = '';
                                            }
                                        });
                                    });
                                });
                            });
                        </script>

                        <!-- Transfer Button -->
                        <div class="text-center mt-4">
                            <a href="{{ route('transfers.create') }}" class="btn btn-primary btn-lg shadow"
                                style="background-color: var(--primary-color); border-color: var(--primary-color); color: white; padding: 10px 30px;">
                                <i class="fas fa-exchange-alt me-2"></i> Transfer
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection