@extends('admin_master_def')

@section('title', '| Order List')

@section('content')
    <div class="col-xs-12">
        <h3>Order List</h3>
        <div class="box box-warning">
            <div class="box-body">
                <table id="table-orders" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th width="30%">Amount</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td></td>
                            <td>{{ $order->customer->getFullName() }}</td>
                            <td data-sort="{{ $order->status }}">{{ $order->textStatus() }}</td>
                            <td data-sort="{{ $order->getAmount(true) }}">{{ vnd_format($order->getAmount(true)) }} VNĐ</td>
                            <td>{{ $order->created_at }}</td>
                            <td>{{ (count($order->log) > 0) ? $order->log->last()->updated_at : $order->created_at }}</td>
                            <td>
                                <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-default"><i class="fa fa-eye"></i></a>
                                <a href="{{ route('admin.order.edit', $order->id) }}" class="btn btn-default"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('lib-css')
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush

@push('lib-js')
    <script src="{{ asset('vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
@endpush

@push('js')
    <script>
        $('#table-orders').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'columns'     : [
                {orderable: true, visible: false},
                {orderable: true},
                {orderable: true},
                {orderable: true},
                {orderable: true},
                {orderable: true},
                {orderable: false},
            ],
            order: [0, 'desc'],
        });
    </script>
@endpush