@extends('admin_master_def')

@section('title', '| Brand List')

@section('content')
    <div class="col-xs-12">
        <h3>Brand List</h3>
        <div class="row">
            <div class="col-xs-12 col-md-9">
                <div class="box box-warning">
                    <div class="box-body">
                        <table id="table-brands" class="table">
                            <thead>
                                <tr>
                                    <th>Brand</th>
                                    <th>Brand Code</th>
                                    <th>Sales last month</th>
                                    <th>Amount last month (VNĐ)</th>
                                    <th>Total Sales</th>
                                    <th width="30%">Total Amount (VNĐ)</th>
                                    <th width="50px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($brands as $brand)
                                <tr>
                                    <td data-sort="{{ $brand->id }}">{{ $brand->name }}</td>
                                    <td>{{ $brand->slug }}</td>
                                    <td>{{ $brand->sales_lm ?? 0 }}</td>
                                    <td data-sort="{{ $brand->amount_lm }}">{{ vnd_format($brand->amount_lm, 1, 1100) ?? 0 }}</td>
                                    <td>{{ $brand->sales ?? 0 }}</td>
                                    <td data-sort="{{ $brand->amount }}">{{ vnd_format($brand->amount, 1, 1100) ?? 0 }}</td>
                                    <td>
                                        <a href="{{ route('admin.brand.show', $brand->id) }}" class="btn btn-default"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $brands->links() }}
                    </div>
                </div>
            </div>
            @can('create', App\Models\Brand::class)
                <div class="col-xs-12 col-md-3">
                    <div class="box box-default">
                        <div class="box-header">
                            <p class="lead">Add New Brand</p>
                        </div>
                        <div class="box-body">
                            <form action="{{ route('admin.brand.store') }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="form-group">
                                    <label for="" class="control-label">Brand Name</label>
                                    <input type="text" name="name" id="" class="form-control">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Add Brand</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endcan
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
        $('#table-brands').DataTable({
            'paging'      : false,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'columns'     : [
                {orderable: true},
                {orderable: false},
                {orderable: true},
                {orderable: true},
                {orderable: true},
                {orderable: true},
                {orderable: false},
            ],
            order: [3, 'desc'],
        });
    </script>
@endpush