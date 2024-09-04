<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{route('user.dashboard')}}">
            <span class="align-middle">User</span>
        </a>

        <ul class="sidebar-nav">
            

            <li class="sidebar-item active">
                <a class="sidebar-link" href="{{route('user.dashboard')}}">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-header">
                Shipment
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{route("user.shipment.book")}}">
                    <i class="align-middle" data-feather="shopping-cart"></i> <span class="align-middle">Book</span>
                </a>
            </li>

        </ul>

        
    </div>
</nav>