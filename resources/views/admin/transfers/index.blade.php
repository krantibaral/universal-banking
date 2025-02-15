@extends('admin.templates.index')

@section('title', $title)

@section('content_header')
    <h1>Transactions</h1>
@stop

@push('styles')
    <!-- Add any specific styles if needed -->
    <style>
        .badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-pending {
            background-color: #ffc107;
            color: #000;
        }
        .badge-completed {
            background-color: #28a745;
            color: #fff;
        }
        .badge-failed {
            background-color: #dc3545;
            color: #fff;
        }
    </style>
@endpush

@section('index_content')
    <div class="table-responsive">
        <table class="table" id="data-table">
            <thead>
            <tr class="text-left text-capitalize">
                <th>ID</th>
                <th>Sender</th>
                <th>Receiver</th>
                <th>Amount</th>
                <th>Memo</th>
                <th>Status</th>
                <th>Created At</th> <!-- Added created_at column -->
                <th>Action</th>
            </tr>
            </thead>
        </table>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('transfers.index') }}",  // Update the route to your transaction index route
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'sender', name: 'sender.name'},  // Assuming sender is a relationship with User model
                    {data: 'receiver', name: 'receiver.user.name'},  // Assuming receiver is a relationship with Customer model
                    {data: 'amount', name: 'amount'},
                    {data: 'memo', name: 'memo'},
                    {
                        data: 'status',
                        name: 'status',
                        render: function (data, type, row) {
                            // Add badges based on status
                            if (data === 'Pending') {
                                return '<span class="badge badge-pending">Pending</span>';
                            } else if (data === 'Completed') {
                                return '<span class="badge badge-completed">Completed</span>';
                            } else if (data === 'Failed') {
                                return '<span class="badge badge-failed">Failed</span>';
                            } else {
                                return '<span class="badge">' + data + '</span>';
                            }
                        }
                    },
                    {
                        data: 'created_at',  // Added created_at field for display
                        name: 'created_at',
                        render: function (data, type, row) {
                            // Format the date if needed
                            var date = new Date(data);
                            return date.toLocaleString();  // Change formatting as needed
                        }
                    },
                    {data: 'action', name: 'action'},
                ],
            });
        });
    </script>
@endpush
