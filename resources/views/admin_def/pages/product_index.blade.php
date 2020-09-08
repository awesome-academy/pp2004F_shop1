@extends('admin_master_def')

@section('title', '| Product List')

@section('content')
    <div class="col-xs-12">
        <h3>Product List</h3>
        <div class="box box-warning">
            <div class="box-body">
                <table id="table-products" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Brand</th>
                            <th width="140px">Import Price (VNĐ)</th>
                            <th width="140px">Current Price (VNĐ)</th>
                            <th width="150px">Sales last month</th>
                            <th width="150px">Total sales</th>
                            <th width="80px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td><a href="{{ route('admin.product.show', $product->id) }}">{{ $product->name }}</a></td>
                            <td>{{ $product->brand->name }}</td>
                            <td data-sort="{{ $product->buy_price }}">{{ vnd_format($product->buy_price) }}</td>
                            <td data-sort="{{ $product->current_price }}">{{ $product->vnd_format() }}</td>
                            <td>fdsgdsf</td>
                            <td>fdsgdsf</td>
                            <td>
                                <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-default"><i class="fa fa-edit"></i></a>
                                <a href="" class="btn btn-default"><i class="fa fa-trash"></i></a>
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
        $('#table-products').DataTable({
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
                {orderable: true},
                {orderable: false},
            ],
            order: [0, 'desc'],
        });
    </script>
@endpush