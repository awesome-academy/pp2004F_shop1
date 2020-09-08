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
                                <td>@if(!empty($order::STT['completed']) || $order->status !== $order::STT['completed'])
                                    <select name="status" class="form-control">
                                        <option value="">--- Please choose a status</option>
                                        @foreach($order::STT as $status)
                                        <option value="{{ $status }}" @if ($order->status == $status) {{ 'selected' }} @endif
                                            {{ ! in_array($status, $user_can) ? "disabled" : 'class=text-green' }}>{{ $order->textStatus($status) }}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </td>
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
                                    @if ($order->status !== 8)
                                    <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Update</button>
                                    @endif
                                    <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Back</a>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection