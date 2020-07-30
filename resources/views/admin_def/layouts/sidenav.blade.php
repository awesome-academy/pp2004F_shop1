<aside class="main-sidebar">
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('_admin/images/dashboard/user1-128x128.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Super Admin</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
            <li>
                <a href="{{ url('admin') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-cubes"></i> <span>Products</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Product List</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Add New Product</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-truck"></i> <span>Orders</span>
                    <span class="pull-right-container">
                        <span class="label label-primary pull-right">4</span>
                    </span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-credit-card"></i> <span>Bills</span>
                    <span class="pull-right-container">
                        <span class="label label-primary pull-right">4</span>
                    </span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <small><i class="fa fa-mobile fa-2x"></i></small> <span> &nbsp;&nbsp;Brands</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Customers</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Admins</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Users</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Customers</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Admins</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-photo"></i>
                    <span>Media</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-gear"></i>
                    <span>Options</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-info-circle"></i>
                    <span>About</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
