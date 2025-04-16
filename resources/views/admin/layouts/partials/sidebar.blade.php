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
                    <img width="180" src="{{ url('website/logo.png') }}"/>
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
{{--                            <li>--}}
{{--                                <a>--}}
{{--                                    <span class="nav-icon no-fade"><i class="fa fa-user-circle-o" aria-hidden="true"></i></span>--}}
{{--                                    <span class="nav-caret"><i class="fa fa-caret-down"></i></span>--}}
{{--                                    <span class="nav-text">Users</span>--}}
{{--                                </a>--}}
{{--                                <ul class="nav-sub nav-mega nav-mega-3">--}}
{{--                                    <li class="sub_menu">--}}
{{--                                        <a href="{{ route('admin_client_view') }}">--}}
{{--                                            <span class="nav-text">Customers</span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </li>--}}

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
                            @canany(['keywords.view','keywords.create','keywords.edit','keywords.delete','keywords.ManagePostProducts'])
                            <li>
                                <a href="{{ route('keywords.index') }}">
                                    <span class="nav-icon no-fade"><i class="fa fa-genderless" aria-hidden="true"></i></span>
                                    <span class="nav-text">Content keywords</span>
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
                            @canany(['seo_tags.view','seo_tags.create','seo_tags.edit','seo_tags.delete'])
                            <li>
                                <a href="{{ route('seo-tags.index') }}">
                                    <span class="nav-icon no-fade"><i class="fa fa-genderless" aria-hidden="true"></i></span>
                                    <span class="nav-text">SEO</span>
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
                            @canany(['galleries.view','galleries.create','galleries.edit','galleries.delete'])
                            <li>
                                <a href="{{ route('galleries.index') }}">
                                    <span class="nav-icon no-fade"><i class="fa fa-genderless" aria-hidden="true"></i></span>
                                    <span class="nav-text">Gallery</span>
                                </a>
                            </li>
                            @endcan
                            @canany(['tags.view','tags.create','tags.edit','tags.delete'])
                            <li>
                                <a href="{{ route('tags.index') }}">
                                    <span class="nav-icon no-fade"><i class="fa fa-genderless" aria-hidden="true"></i></span>
                                    <span class="nav-text">Tags</span>
                                </a>
                            </li>
                            @endcan
                            @canany(['templates.view','templates.create','templates.edit','templates.delete'])
                            <li>
                                <a href="{{ route('templates.index') }}">
                                    <span class="nav-icon no-fade"><i class="fa fa-genderless" aria-hidden="true"></i></span>
                                    <span class="nav-text">Templates</span>
                                </a>
                            </li>
                            @endcan
                            @canany(['authors.view','authors.create','authors.edit','authors.delete'])
                            <li>
                                <a href="{{ route('authors.index') }}">
                                    <span class="nav-icon no-fade"><i class="fa fa-genderless" aria-hidden="true"></i></span>
                                    <span class="nav-text">Authors</span>
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
                            @canany(['post_comments.view','post_comments.create','post_comments.edit','post_comments.delete'])
                            <li>
                                <a href="{{ route('post-comments.index') }}">
                                    <span class="nav-icon no-fade"><i class="fa fa-genderless" aria-hidden="true"></i></span>
                                    <span class="nav-text">Posts Comments</span>
                                </a>
                            </li>
                            @endcan
                            @canany(['customNotification'])
                                <li>
                                    <a href="{{ route('fireBaseCustomNotification') }}">
                                        <span class="nav-icon no-fade"><i class="fa fa-genderless" aria-hidden="true"></i></span>
                                        <span class="nav-text">Custom Notification</span>
                                    </a>
                                </li>
                            @endcan


                            <hr>
                            @canany(['brands.view','brands.create','brands.edit','brands.delete'])
                            <li>
                                <a href="{{ route('brands.index') }}">
                                    <span class="nav-icon no-fade"><i class="fa fa-genderless" aria-hidden="true"></i></span>
                                    <span class="nav-text">Brands</span>
                                </a>
                            </li>
                            @endcan
                            @canany(['product_types.view','product_types.create','product_types.edit','product_types.delete'])
                            <li>
                                <a href="{{ route('product-types.index') }}">
                                    <span class="nav-icon no-fade"><i class="fa fa-genderless" aria-hidden="true"></i></span>
                                    <span class="nav-text">Product Types</span>
                                </a>
                            </li>
                            @endcan

                            @canany(['product_specification_categories.view','product_specification_categories.create','product_specification_categories.edit','product_specification_categories.delete'])
                            <li>
                                <a href="{{ route('specification-categories.index') }}">
                                    <span class="nav-icon no-fade"><i class="fa fa-genderless" aria-hidden="true"></i></span>
                                    <span class="nav-text">Specification Categories</span>
                                </a>
                            </li>
                            @endcan
                            @canany(['specifications.view','specifications.create','specifications.edit','specifications.delete'])
                            <li>
                                <a href="{{ route('specifications.index') }}">
                                    <span class="nav-icon no-fade"><i class="fa fa-genderless" aria-hidden="true"></i></span>
                                    <span class="nav-text">Specification</span>
                                </a>
                            </li>
                            @endcan
                            @canany(['products.view','products.create','products.edit','products.delete'])
                            <li>
                                <a href="{{ route('products.index') }}">
                                    <span class="nav-icon no-fade"><i class="fa fa-genderless" aria-hidden="true"></i></span>
                                    <span class="nav-text">Products</span>
                                </a>
                            </li>
                            @endcan
                            @canany(['product_reviews.view','product_reviews.create','product_reviews.edit','product_reviews.delete'])
                            <li>
                                <a href="{{ route('product-reviews.index') }}">
                                    <span class="nav-icon no-fade"><i class="fa fa-genderless" aria-hidden="true"></i></span>
                                    <span class="nav-text">Products Reviews</span>
                                </a>
                            </li>
                            @endcan
                            @canany(['reports'])
                             <li>
                                 <a>
                                     <span class="nav-icon no-fade"><i class="fa fa-genderless" aria-hidden="true"></i></span>
                                     <span class="nav-caret"><i class="fa fa-caret-down"></i></span>
                                     <span class="nav-text">Reports</span>
                                 </a>
                                 <ul class="nav-sub nav-mega nav-mega-3">
                                     <li class="sub_menu">
                                         <a href="{{ route('categoryReport') }}">
                                             <span class="nav-text">Category</span>
                                         </a>
                                     </li>
                                     <li class="sub_menu">
                                         <a href="{{ route('userReport') }}">
                                             <span class="nav-text">User</span>
                                         </a>
                                     </li>
                                 </ul>
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
                <div class="navbar-text nav-title flex" id="pageTitle">@yield('title')</div>
                <ul class="nav flex-row order-lg-2">
                    <!-- Notification -->
                    <li class="dropdown notificationLi d-flex align-items-center">
                        <a href="#" data-toggle="dropdown" class="d-flex align-items-center">
                                    <span class="avatar w-32">
	    	          <i class="fa fa-bell" aria-hidden="true"></i><span class="bellCount">{{ count(auth()->user()->unreadNotifications) }}</span>
	    	        </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right notificationDropDown pt-0 mt-2 animate fadeIn">
                            <div class="row no-gutters b-b mb-2">


                            </div>

                            @foreach(auth()->user()->notifications as $notification)
                            <a class="dropdown-item NotificationList" data-id="{{ $notification->id }}" href="{{ $notification->data['url'] }}">
                                    <span class="notificationMsg {{ ($notification->read_at == null)?'unread':'' }}">New Comment on {{ Helper::ellipsis($notification->data['title'],'30') }}</span>
                                <br>
                                <div class="notificationDetails">
                                    <span class="descp">{{ $notification->data['commenter'] }}: {{ Helper::ellipsis($notification->data['comment'],'20') }}</span>
                                    <span class="time">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                </div>
                            </a>
                            @endforeach


                            <div class="dropDownFooter">
                                <a href="{{ route('notificationReadAll') }}">Mark all Read</a>
                                <a href="{{ route('notificationDeleteAll') }}">Delete all</a>
                            </div>

                        </div>
                    </li>

                    <!-- User dropdown menu -->
                    <li class="dropdown d-flex align-items-center">
                        <a href="#" data-toggle="dropdown" class="d-flex align-items-center">
                                    <span class="avatar w-32">
	    	          <img src="{{ route('admin.assets') }}/images/user-logo.png" alt="...">
	    	        </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right w pt-0 mt-2 animate fadeIn">
                            <div class="row no-gutters b-b mb-2">


                            </div>
                            <a class="dropdown-item" href="{{ route('myProfile') }}">
                                <span>Profile</span>
                            </a>
                            <a class="dropdown-item" href="{{ route('GetLogout') }}">
                                <span>Sign Out</span>
                            </a>
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
        <style>
            div#medium-editor-toolbar-form-fontsize-1 {
                background: #000;
            }

            a.medium-editor-toobar-save i,a.medium-editor-toobar-close i {
                color: #fff !important;
            }
            .notificationLi{ display: none !important; }
            .notificationDropDown {
                min-width: 360px;
            }
            .notificationDetails {
                display: flex;
                justify-content: space-between;
            }
            li.active i.fa.fa-genderless {
                color: orange;
            }
            .notificationLi i {
                font-size: 22px;
                padding-top: 4px;
                color: #000;
            }
            span.bellCount {
                position: absolute;
                background: red;
                color: #fff;
                padding: 3px 4px;
                top: 4px;
                right: 2px;
                border-radius: 50px;
                font-weight: bold;
            }
            span.notificationMsg {
                top: -7px;
                position: relative;
                font-size: 12px;
                color: #232e3d;
            }
            span.notificationMsg.unread{
                font-weight: bold;
            }
            .dropDownFooter {
                padding: 0.25rem 1.5rem;
                display: flex;
                justify-content: space-between;
                margin-top: 17px;
                border-top: 1px solid #f1f1f1;
            }

        </style>

        @push('scripts')
            <script !src="">
                $(".NotificationList").click(function (e){
                    e.preventDefault()
                    let ele = $(this);
                    let route = "{{ route('markNotificationUnRead') }}"
                    $.ajax({
                        method:'POST',
                        url: route,
                        data: { id:ele.attr('data-id') },
                        success: function(res) {

                        }
                    });

                    location.assign(ele.attr('href'));
                });
            </script>
        @endpush
