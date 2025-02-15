@extends('admin.templates.index')

@section('title', $title)

@section('content_header')
<h1>Customer</h1>
@stop

@push('styles')

@endpush

@section('index_content')
<div class="table-responsive">
    <table class="table" id="data-table">
        <thead>
            <tr class="text-left text-capitalize">
                <th>id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Account Number</th>
                <th>Verified</th>
                <th>action</th>
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
                ajax: "{{ route('customers.index') }}",
                columns: [
                    { data: 'id', name: 'DT_RowIndex' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'account_number', name: 'account_number' },
                    { data: 'verified', name: 'verified' },
                    { data: 'action', name: 'action' },
                ],
            });
        });
    </script>
@endpush