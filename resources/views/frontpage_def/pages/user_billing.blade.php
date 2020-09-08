@extends('frontpage_master_def')

@section('title', '| Billing')

@section('content')
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="{{ route('homepage') }}">Home</a></li>
                <li class="active">Billing</li>
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
                <span class="page-title bg-warning text-white">Billing</span>
                <table class="table table-borderless">
                    <tbody>
                        @if (!empty($bills))
                            <tr>
                                <th class="w-25">Check Number</th>
                                <th class="w-25">Amount</th>
                                <th>Created At</th>
                                <th></th>
                            </tr>
                            @foreach ($bills as $bill)
                                <tr>
                                    <td>{{ $bill->bill->check_number }}</td>
                                    <td>{{ vnd_format($bill->getAmount(true)) }} VNĐ</td>
                                    <td>{{ $bill->created_at }}</td>
                                    <td class="text-right"><a href="{{ route('user.bill.show', $bill->id) }}" class="btn-sm"><small>View details</small></a></td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{ $bills->links() }}
            </div>
        </div>
    </div>
</div>
<!--Checkout Area End-->
@endsection
