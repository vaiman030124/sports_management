<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('dist/img/logo.webp') }}" alt="H2O Sports Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">H2O Sports Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                @if(Auth::guard('admin')->check())
                    <a href="#" class="d-block">{{ Auth::guard('admin')->user()->name }}</a>
                @else
                    <a href="#" class="d-block">Guest</a>
                @endif
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Admin User Management -->
                <li class="nav-header">ADMIN MANAGEMENT</li>
                <li class="nav-item">
                    <a href="{{ route('admin.admin-users.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>Admin Users</p>
                    </a>
                </li>

                <!-- User Management -->
                <li class="nav-header">USER MANAGEMENT</li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.groups.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>Groups</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.trainers.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>Trainers</p>
                    </a>
                </li>

                <!-- Booking Management -->
                <li class="nav-header">BOOKING MANAGEMENT</li>
                <li class="nav-item">
                    <a href="{{ route('admin.bookings.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-calendar-check"></i>
                        <p>Court Bookings</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.trainer_bookings.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-clock"></i>
                        <p>Trainer Bookings</p>
                    </a>
                </li>

                <!-- Venue Management -->
                <li class="nav-header">VENUE MANAGEMENT</li>
                <li class="nav-item">
                    <a href="{{ route('admin.venues.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-map-marker-alt"></i>
                        <p>Venues</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.sports.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-running"></i>
                        <p>Sports</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.slots.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-dice"></i>
                        <p>Slot</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.courts.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-gamepad"></i>
                        <p>Courts</p>
                    </a>
                </li>

                <!-- Financial -->
                <li class="nav-header">FINANCIAL</li>
                <li class="nav-item">
                    <a href="{{ route('admin.transactions.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                        <p>Transactions</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.refunds.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-undo-alt"></i>
                        <p>Refunds</p>
                    </a>
                </li>

                <!-- Other -->
                <li class="nav-header">OTHER</li>
                <li class="nav-item">
                    <a href="{{ route('admin.notifications.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-bell"></i>
                        <p>Notifications</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.reviews.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-star"></i>
                        <p>Reviews</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
