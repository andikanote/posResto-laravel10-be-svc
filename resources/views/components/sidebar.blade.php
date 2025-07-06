<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="">Boetjah-CMS</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="">BCMS</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item dropdown">
                <a href="#"
                    class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ url('dashboard-general-dashboard') }}">General Dashboard</a>
                    </li>
                </ul>
            </li>

            <li class="menu-header">Users Management</li>
            <li class="nav-item dropdown">
                <a href="#"
                    class="nav-link has-dropdown"><i class="fa fa-user"></i><span>Users</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('users') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ route('user.index') }}">All Users</a>
                    </li>
                </ul>
            </li>

            <li class="menu-header">Inventory Management</li>
            <li class="nav-item dropdown">
                <a href="#"
                    class="nav-link has-dropdown"><i class="fas fa-box"></i><span>Category</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('categories') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ route('categories.index') }}">All Category</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a href="#"
                    class="nav-link has-dropdown"><i class="fas fa-square"></i><span>Products</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('products') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ route('products.index') }}">All Products</a>
                    </li>
                </ul>
            </li>
    </aside>
</div>
</div>
