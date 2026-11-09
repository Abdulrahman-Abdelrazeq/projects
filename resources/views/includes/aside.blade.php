<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link">
        <img src="{{ asset('assets/admin-lte/dist/img/splash.png')}}" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">محلات ابوسمره</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{route('home')}}" class="nav-link">
                        <i class="fas fa-th nav-icon"></i>
                        <p> الرئيسية </p>
                    </a>
                </li>

                <li class="nav-item has-treeview {{ request()->is('shops*') || request()->is('subscriptions*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('shops*') || request()->is('subscriptions*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-store"></i>
                        <p>
                            المحلات
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('shops.index')}}" class="nav-link {{ request()->is('shops') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>عرض المحلات </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('shops.create')}}" class="nav-link {{ request()->is('shops/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>اضافة محل </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('subscriptions.index')}}" class="nav-link {{ request()->is('subscriptions*') && !request()->is('subscriptions/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon text-warning"></i>
                                <p>الاشتراكات </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('subscriptions.create')}}" class="nav-link {{ request()->is('subscriptions/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon text-success"></i>
                                <p>اضافة اشتراك </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview {{ request()->is('users*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            المستخدمين
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('users.index')}}" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>عرض المستخدمين </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview {{ request()->is('instructions*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('instructions*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-info-circle"></i>
                        <p>
                            التعليمات
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('instructions.create')}}" class="nav-link {{ request()->is('instructions/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>اضافة تعليمات </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('instructions.index')}}" class="nav-link {{ request()->is('instructions') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>عرض التعليمات </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    {!! Form::open(['method' => 'post', 'url' => url('logout'), 'id' => 'signoutSidebar']) !!}
                    {!! Form::close() !!}
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('signoutSidebar').submit();">
                        <i class="fas fa-sign-out-alt nav-icon"></i>
                        <p>تسجيل الخروج</p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
