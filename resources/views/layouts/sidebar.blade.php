        <div class="col-md-3 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Sidebar</div>
                <div class="panel-body">
                    <ul>
                        <li><a href="{{ url('/home') }}">Home</a></li>
                        @if(Auth::user()->status == 2)
                        <li><a href="{{ url('home/form') }}">Merchant Form</a></li>
                        <li><a href="{{ url('/home/user') }}">Users</a>
                            <ul>
                                <li><a href="{{ url('home/user/admin') }}">Admin</a></li>
                                <li><a href="{{ url('home/user/merchant') }}">Merchants</a></li>
                                <li><a href="{{ url('home/user/customer') }}">Customers</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ url('home/category') }}">Categories</a></li>
                        @endif
                        @if(Auth::user()->status == 1)
                            <li><a href="{{ url('home/service') }}">My Services</a></li>
                        @elseif(Auth::user()->status == 2)
                            <li><a href="{{ url('home/service') }}">Services</a></li>
                        @endif
                        @if(Auth::user()->status == 0 || Auth::user()->status == 1)
                            <li><a href="{{ url('home/order') }}">My Orders</a></li>
                        @else
                            <li><a href="{{ url('home/order') }}">Orders</a></li>
                        @endif
                        <li><a href="{{ url('logout') }}">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>