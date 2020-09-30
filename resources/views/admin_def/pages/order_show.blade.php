@extends('admin_master_def')

@section('title', '| Order Details')

@section('content')
<div class="col-xs-12">
<h3>Order Details</h3>
</div>
<div class="col-xs-12 col-md-6">
    <div class="ro">
        <div class="box box-warning box-order-details">
            <div class="box-body">
                <div class="table-responsive">
                    <form action="{{ route('admin.order.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <table class="table">
                            <tr>
                                <th style="width: 30%">Customer</th>
                                <td>{{ $order->customer->getFullName() }}</td>
                            </tr>
                            <tr>
                                <th>Products</th>
                                <td>
                                    <ul class="list-unstyled">
                                    @foreach($order->orderedProducts as $product)
                                        <li>
                                            <a href="{{ route('admin.product.show', $product->id) }}">
                                                <img src="{{ $product->images->first()->image }}" alt="" style="width: 80px; max-height: 100px; margin-right: 10px">
                                                {{ $product->name }} - {{ vnd_format($product->pivot->price) }} VNĐ
                                                <b>({!! '&times;' !!} {{ $product->pivot->quantity_ordered }})</b>
                                            </a>
                                        </li>
                                    @endforeach
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ $order->textStatus() }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $order->created_at }}</td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td>{{ (count($order->log) > 0) ? $order->log->last()->updated_at : $order->created_at }}</td>
                            </tr>
                            <tr>
                                <th>Customer Notes</th>
                                <td>{{ $order->comment ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Ship to Address*</th>
                                <td>{{ $order->ship_to_address ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Subtotal</th>
                                <td>{{ vnd_format($order->getAmount()) }} VNĐ</td>
                            </tr>
                            <tr>
                                <th>Total Amount (VAT required)</th>
                                <td><h4>{{ vnd_format($order->getAmount(true)) }} VNĐ</h4></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    @if ($order->status !== $order::STT['completed'] )
                                        <a href="{{ route('admin.order.edit', $order->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i> Edit</a>
                                    @endif
                                    <a href="javascript: history.back()" class="btn btn-default"><i class="fa fa-times"></i> Cancel</a>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xs-12 col-md-6">
    <div class="ro">
        <div class="box box-default box-order-log">
            <div class="box-header">
                <p class="lead">Order Log</p>
            </div>
            <div class="box-body">
                @if ($order->log)
                    <table id="table-orders" class="table">
                        <thead>
                            <tr>
                                <th>User has updated</th>
                                <th>Event</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->log->sortByDesc('updated_at') as $log)
                            <tr>
                                <td>{{ $log->user->getFullName() }}</td>
                                <td>{{ $log->event . ' - ' .$order->textStatus($log->event) }}</td>
                                <td>at {{ $log->updated_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
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
            'paging'      : false,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : false,
            'autoWidth'   : true,
            'order'       : false,
        });
    </script>
@endpush