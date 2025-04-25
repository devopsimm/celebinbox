<body class="fixed-content fixed-aside" data-baseurl="{{ url('') }}">
<div class="app" id="app">
    <!-- ############ LAYOUT START-->
    <!-- ############ Aside START-->
    <div id="aside" class="app-aside fade box-shadow-x nav-expand dark" aria-hidden="true" ui-class="dark">
        <div class="sidenav modal-dialog dk" ui-class="dark">
            <!-- sidenav top -->
            <div class="navbar lt" ui-class="dark">
                <!-- brand -->
                <a href="#" class="navbar-brand" id="side_bar">


                    <span class="hidden-folded d-inline"></span>
                </a>
                <!-- / brand -->
            </div>
            <!-- Flex nav content -->
            <div class="flex hide-scroll">
                <div class="scroll">
                    <div class="nav-border b-primary" data-nav>
                        <ul class="nav bg">
                            <li>
                                <a href="{{ route('dashboard') }}">
                                    <span class="nav-icon no-fade"><i class="fa fa-tachometer" aria-hidden="true"></i></span>
                                    <span class="nav-text">Dashboard</span>
                                </a>

                            </li>

                            @role('Admin')
                            @canany(['users.view','users.create','users.edit','users.delete'])
                                <li>
                                    <a href="{{ route('users.index') }}">
                                        <span class="nav-icon no-fade"><i class="fa fa-genderless" aria-hidden="true"></i></span>
                                        <span class="nav-text">Users</span>
                                    </a>
                                </li>
                            @endcan
                            @endrole
                            @canany(['roles.view','roles.create','roles.edit','roles.delete'])
                                <li>
                                    <a href="{{ route('roles.index') }}">
                                        <span class="nav-icon no-fade"><i class="fa fa-genderless" aria-hidden="true"></i></span>
                                        <span class="nav-text">Roles</span>
                                    </a>
                                </li>
                            @endcan
                            @canany(['permissions.manage'])
                                <li>
                                    <a href="{{ route('permissions.index') }}">
                                        <span class="nav-icon no-fade"><i class="fa fa-genderless" aria-hidden="true"></i></span>
                                        <span class="nav-text">Permission Matrix</span>
                                    </a>
                                </li>
                            @endcan
                            @canany(['content_positions.view','content_positions.create','content_positions.edit','content_positions.delete','content_positions.ManagePostProducts'])
                                <li>
                                    <a href="{{ route('content-positions.index') }}">
                                        <span class="nav-icon no-fade"><i class="fa fa-genderless" aria-hidden="true"></i></span>
                                        <span class="nav-text">Content Positions</span>
                                    </a>
                                </li>
                            @endcan
                            @canany(['manageAuthors'])
                                <li>
                                    <a href="{{ route('authors.index') }}">
                                        <span class="nav-icon no-fade"><i class="fa fa-genderless" aria-hidden="true"></i></span>
                                        <span class="nav-text">Authors</span>
                                    </a>
                                </li>
                            @endcan
                            @canany(['categories.view','categories.create','categories.edit','categories.delete'])
                                <li>
                                    <a href="{{ route('categories.index') }}">
                                        <span class="nav-icon no-fade"><i class="fa fa-genderless" aria-hidden="true"></i></span>
                                        <span class="nav-text">Categories</span>
                                    </a>
                                </li>
                            @endcan

                            @canany(['posts.view','posts.create','posts.edit','posts.delete'])
                                <li>
                                    <a href="{{ route('feed-posts.index') }}">
                                        <span class="nav-icon no-fade"><i class="fa fa-genderless" aria-hidden="true"></i></span>
                                        <span class="nav-text">Posts</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </div>
            </div>
            <!-- sidenav bottom -->

        </div>
    </div>
    <!-- ############ Aside END-->
    <!-- ############ Content START-->
    <div id="content" class="app-content box-shadow-0" role="main">
        <!-- Header -->
        <div class="content-header white  box-shadow-0" id="content-header">
            <div class="navbar navbar-expand-lg">
                <!-- btn to toggle sidenav on small screen -->
                <a class="d-lg-none mx-2" data-toggle="modal" data-target="#aside">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512">
                        <path d="M80 304h352v16H80zM80 248h352v16H80zM80 192h352v16H80z"/>
                    </svg>
                </a>

                <!-- Page title -->
                <div class="navbar-text nav-title flex" id="pageTitle">
                    @isset($header)
                        {{ $header }}
                    @endisset
                </div>
                <ul class="nav flex-row order-lg-2">


                    <!-- User dropdown menu -->
                    <li class="dropdown d-flex align-items-center">
                        <a href="#" data-toggle="dropdown" class="d-flex align-items-center">
                                        <span class="avatar w-32">
                          <img src="{{ url('admin-assets/images/user-logo.png') }}" alt="...">
                        </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right w pt-0 mt-2 animate fadeIn">
                            <div class="row no-gutters b-b mb-2">


                            </div>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <span>Profile</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <button @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>
                    </li>
                    <!-- Navarbar toggle btn -->
                    <li class="d-lg-none d-flex align-items-center">
                        <a href="#" class="mx-2" data-toggle="collapse" data-target="#navbarToggler">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 512 512">
                                <path d="M64 144h384v32H64zM64 240h384v32H64zM64 336h384v32H64z"/>
                            </svg>
                        </a>
                    </li>
                </ul>
                <!-- Navbar collapse -->

            </div>
        </div>


