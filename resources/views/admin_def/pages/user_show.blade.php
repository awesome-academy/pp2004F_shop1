@extends('admin_master_def')

@section('title', '| User Details')

@section('content')
    <div class="col-xs-12">   
        <h3>User Details</h3>
    </div>
    <div class="col-xs-12 col-md-6">
        <div class="box box-warning">
            <div class="box-body">
                <h3 class="box-title lead"><b></b></h3>
                <div class="user-details">
                    <div class="table-responsive">
                        <p class="lead">{{ $user->getFullName() }}</p>
                        <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                            @csrf
                            @method("PATCH")
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th width="30%">First Name</th>
                                        <td>{{ ucwords($user->first_name) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Last Name</th>
                                        <td>{{ ucwords($user->last_name) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    @if ($user->trashed())
                                    <tr>
                                        <th>Status</th>
                                        <td><span class="text-danger"><i class="fa fa-ban"></i> Banned</span></td>
                                    </tr>
                                    <tr>
                                        <th>Banned at</th>
                                        <td><span class="text-danger">{{ $user->deleted_at }}</span></td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th>Role</th>
                                        <td>
                                            <select name="role_id" id="" class="form-control">
                                                <option value="">--- Choose a Role</option>
                                                @if (!empty($roles))
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->id }}" 
                                                            @if($role->id == $user->role_id) {{ 'selected' }} @endif>{{ $role->title }}</option>
                                                    @endforeach
                                                @endif    
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>{{ $user->phone ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Primary Address</th>
                                        <td>{{ $user->address1 ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Secondary Address</th>
                                        <td>{{ $user->address2 ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>City</th>
                                        <td>{{ $user->city ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Activated at</th>
                                        <td>{{ $user->role_id == 1 ? 'Not Activated' : $user->activated_at }}</td>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <td>
                                            @if ($user->id == Auth::user()->id)
                                                <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-warning">
                                                    <i class="fa fa-edit"></i> Edit Profile
                                                </a>
                                            @endif
                                            @if ($user->role_id == 1)
                                                <button type="submit" name="action" value="active" class="btn btn-success">
                                                    <i class="fa fa-key"></i> Active Member
                                                </button>
                                            @endif
                                                <button type="submit" name="action" value="change-role" class="btn btn-primary">
                                                    <i class="fa fa-save"></i> Update Role
                                                </button>
                                            @if ($user->trashed())
                                                <button type="submit" name="action" value="restore" class="btn btn-success">
                                                    <i class="fa fa-refresh"></i> Restore Member
                                                </button>
                                            @else 
                                                <button type="submit" name="action" value="ban" class="btn btn-warning">
                                                    <i class="fa fa-ban"></i> Ban Member
                                                </button>
                                            @endif
                                            <a href="javascript: history.back()" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Back</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><span class="lead">Orders</span></a></li>
                <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><span class="lead">Bills</span></a></li>
                <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false"><span class="lead">Comments</span></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <table class="table table-borderless">
                        <tbody>
                            @if (count($orders) > 0)
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
                                        <td class="text-right"><a href="{{ route('admin.order.show', $order->id) }}" class="btn-sm">View details</a></td>
                                    </tr>
                                @endforeach
                            @else
                                <p class="text-center">This user has no order yet.</p>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="tab_2">
                    <table class="table table-borderless">
                        <tbody>
                            @if (count($bills) > 0)
                                <tr>
                                    <th class="w-25">Status</th>
                                    <th class="w-25">Amount</th>
                                    <th>Created At</th>
                                    <th></th>
                                </tr>
                                @foreach ($bills as $bill)
                                    <tr>
                                        <td>{{ $bill->textStatus() }}</td>
                                        <td>{{ vnd_format($bill->getAmount(true)) }} VNĐ</td>
                                        <td>{{ $bill->created_at }}</td>
                                        <td class="text-right"><a href="{{ route('admin.bill.show', $bill->id) }}" class="btn-sm">View details</a></td>
                                    </tr>
                                @endforeach
                            @else
                                <p class="text-center">This user has no bill yet.</p>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="tab_3">
                    <p class="text-center">This user has no comment yet.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
