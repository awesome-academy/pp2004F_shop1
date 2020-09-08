<aside class="main-sidebar">
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('_admin/images/dashboard/user1-128x128.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->getFullName() }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
            <li @if(request()->is('admin')) class="active" @endif>
                <a href="{{ url('admin') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ request()->is('admin/product*') ? 'active ' : '' }}treeview">
                <a href="#">
                    <i class="fa fa-cubes"></i> <span>Products</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="{{ route('admin.product.index') }}"><i class="fa fa-list"></i> Product List</a></li>
                    <li><a href="{{ route('admin.product.create') }}"><i class="fa fa-cube"></i> Add New Product</a></li>
                </ul>
            </li>
            <li @if(request()->is('admin/order*')) class="active" @endif>
                <a href="{{ route('admin.order.index') }}">
                    <i class="fa fa-truck"></i> <span>Orders</span>
                    <span class="pull-right-container">
                        <span class="label label-primary pull-right">4</span>
                    </span>
                </a>
            </li>
            <li @if(request()->is('admin/bill*')) class="active" @endif>
                <a href="{{ route('admin.bill.index') }}">
                    <i class="fa fa-credit-card"></i> <span>Bills</span>
                    <span class="pull-right-container">
                        <span class="label label-primary pull-right">4</span>
                    </span>
                </a>
            </li>
            <li @if(request()->is('admin/brand*')) class="active" @endif>
                <a href="{{ route('admin.brand.index') }}">
                    <small><i class="fa fa-mobile fa-2x"></i></small> <span> &nbsp;&nbsp;Brands</span>
                </a>
            </li>
            <li class="{{ request()->is('admin/user*') ? 'active ' : '' }}treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Users</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.user.index') }}"><i class="fa fa-user"></i> Users</a></li>
                    <li><a href="{{ route('admin.user.admin') }}"><i class="fa fa-user"></i> Admins</a></li>
                    <li><a href="{{ route('admin.role.index') }}"><i class="fa fa-user"></i> Roles</a></li>
                </ul>
            </li>
            <li @if(request()->is('admin/media')) class="active" @endif>
                <a href="{{ url('admin/media') }}">
                    <i class="fa fa-photo"></i>
                    <span>Media</span>
                </a>
            </li>
            <li @if(request()->is('admin/options')) class="active" @endif>
                <a href="#">
                    <i class="fa fa-gear"></i>
                    <span>Options</span>
                </a>
            </li>
            <li @if(request()->is('admin/about')) class="active" @endif>
                <a href="#">
                    <i class="fa fa-info-circle"></i>
                    <span>About</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
