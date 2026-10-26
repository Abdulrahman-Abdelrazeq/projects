<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link">
        <img src="{{ asset('assets/admin-lte/dist/img/splash.png')}}" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">               محلات ابوسمره


      </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">


                <li class="nav-item">
                    <a href="{{route('home')}}" class="nav-link">
                        <i class="fas fa-th nav-icon"></i>
                        <p> الرئيسية </p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                            المحلات
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('shops.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>اضافة محل </p>
                            </a>
                            <a href="{{route('shops.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>عرض المحلات </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                            المستخدمين
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('users.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>عرض المستخدمين </p>
                            </a>
                        </li>
                    </ul>
                </li>
                 <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                            التعليمات
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('instructions.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>اضافة تعليمات </p>
                            </a>
                            <a href="{{route('instructions.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>عرض التعليمات </p>
                            </a>
                        </li>
                    </ul>
                </li>

                    </script>
                    {!! Form::open(['method' => 'post', 'url' => url('logout'),'id'=>'signoutForm','id'=>'signoutSidebar']) !!}

                    {!! Form::close() !!}
                    <a href="#" class="nav-link" onclick="submitSidebarSignout()">
                        <i class="fas fa-sign-out-alt nav-icon"></i>
                        <p>تسجيل الخروج</p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->

        <script>
            function submitSidebarSignout() {
                document.getElementById('signoutSidebar').submit();
            }
        </script>
    </div>
    <!-- /.sidebar -->
</aside>
