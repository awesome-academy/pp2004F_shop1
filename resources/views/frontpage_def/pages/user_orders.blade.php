@extends('frontpage_master_def')

@section('title', '| Orders')

@section('content')
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Orders</li>
            </ul>
        </div>
    </div>
</div>
<!-- Li's Breadcrumb Area End Here -->
<!--Checkout Area Strat-->
<div class="checkout-area pt-60 pb-30">
    <div class="container">
        <div class="row">
            @include('frontpage_def.layouts.user_sidenav')
            <div class="col-lg-8 col-md-9 col-12 user-account-right">
                <span class="page-title bg-warning text-white">My Orders</span>
                <table class="table table-borderless">
                    <tbody>
                        @if (!empty($orders))
                            <tr>
                                <th class="w-25">Status</th>
                                <th class="w-25">Amount</th>
                                <th>Created At</th>
                                <th></th>
                            </tr>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->textStatus() }}</td>
                                    <td>{{ vnd_format($order->getAmount(true)) }} VNĐ</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td class="text-right"><a href="{{ route('user.order.show', $order->id) }}" class="btn-sm"><small>View details</small></a></td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
<!--Checkout Area End-->
@endsection
