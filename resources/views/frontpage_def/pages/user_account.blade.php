@extends('frontpage_master_def')

@section('title', '| Profile')

@section('content')
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>My Account</li>
                <li class="active">Profile</li>
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
                <span class="page-title bg-warning text-white">Profile</span>
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <th scope="row" class="w-25">First Name</th>
                            <td>{{ ucwords($user->first_name) }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Last Name</th>
                            <td>{{ ucwords($user->last_name) }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Phone</th>
                            <td>{{ $user->phone ?? '' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Primary Address</th>
                            <td>{{ $user->address1 ?? '' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Secondary Address</th>
                            <td>{{ $user->address2 ?? '' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">City</th>
                            <td>{{ $user->city ?? '' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Activated at</th>
                            <td>{{ $user->activated_at ?? '' }}</td>
                        </tr>
                        <tr>
                            <th scope="row"><a href="{{ route('user.account.edit', $user->id) }}" class="btn-cart">Edit Profile</a></th>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--Checkout Area End-->
@endsection
