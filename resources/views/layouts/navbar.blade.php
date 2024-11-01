<nav id="nav-theme" class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item">
            <a class="nav-link" href="#" role="button">
                <input type="checkbox" id="theme-change">
                <p id="name-theme"> </p>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="dropdown-divider"></div>
                <a href="{{ route('user_setting') }}" class="dropdown-item">
                    <i class="fas fa-user-circle"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <!-- <a href="#" class="dropdown-item">
                    <i class="fas fa-unlock-alt"></i> Change Password
                </a> -->
                <div class="dropdown-divider"></div>
                <form id="formLogout" action="javascript:;" method="post">
                    @csrf
                    <button type="submit" class="dropdown-item dropdown-footer"><i class="fas fa-sign-out-alt"></i>
                        Logout</button>
                </form>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
