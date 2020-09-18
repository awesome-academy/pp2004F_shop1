@extends('admin_master_def')

@section('title', '| Brand Details')

@section('modal')
    @php
        $modal_class = 'modal-center';
    @endphp
    <form action="{{ route('admin.brand.update', $brand->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <h3>Edit Brand</h3>
        <div class="form-group">
            <label for="" class="control-label">Brand Name</label>
            <input type="text" name="name" id="" class="form-control" value="{{ $brand->name }}">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Update</button>
        </div>
    </form>
@endsection

@section('content')
    @can('delete', \App\Models\Brand::class)
        <form action="{{ route('admin.brand.destroy', $brand->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="submit" value="" class="hidden" id="btn-brand-delete">
        </form>
    @endcan
    <div class="col-xs-12">
        <h3>{{ $brand->name }}
            <span class="btn-group pull-right">
                <a href="{{ route('admin.brand.index') }}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Back</a>
                @can('update', \App\Models\Brand::class)
                    <button class="btn btn-default" id="btn-brand-edit"><i class="fa fa-edit"></i> Edit</button>
                @endcan
                @can('delete', \App\Models\Brand::class)
                    <label for="btn-brand-delete" class="btn btn-default"><i class="fa fa-trash"></i> Delete</label>
                @endcan
            </span>
        </h3>
        <h4 style="margin-top: 20px">Details</h4>
        <div class="box box-warning">
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-6">
                        @php
                            $total_sales_lm = $total_amount_lm = 0;
                            foreach ($products as $product) {
                                $total_sales_lm += $product->sales_lm;
                                $total_amount_lm += $product->amount_lm;
                            }                            
                        @endphp
                        <table class="table">
                            <tr>
                                <th width="30%">Sales Last Month</th>
                                <td>{{ $total_sales_lm ?? 0 }}</td>
                            </tr>
                            <tr>
                                <th>Amount Last Month</th>
                                <td>{{ vnd_format($total_amount_lm, 1, 1100) }} VNĐ</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <table id="table-brand-details" class="table">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th width="140px">Import Price (VNĐ)</th>
                            <th width="140px">Current Price (VNĐ)</th>
                            <th width="160px">Amount last month (VNĐ)</th>
                            <th width="150px">Sales last month</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td><a href="{{ route('admin.product.show', $product->id) }}">{{ $product->name }}</a></td>
                            <td>{{ vnd_format($product->buy_price) }}</td>
                            <td>{{ vnd_format($product->current_price, 1, 1100) }}</td>
                            <td>{{ vnd_format($product->amount_lm, 1, 1100) }}</td>
                            <td>{{ $product->sales_lm }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('admin_def.layouts.modal')
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
        $('#table-brand-details').DataTable({
            'paging'      : false,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'columns'     : [
                {orderable: true},
                {orderable: true},
                {orderable: true},
                {orderable: true},
                {orderable: true},
            ],
            order: [0, 'desc'],
        });
        $('#btn-brand-edit').click(function(){
            $('.modal').modal('show');
        });
    </script>
@endpush