<!-- Begin page -->
<div id="wrapper">

    <!-- Top Bar Start -->
    <div class="topbar">
        <!-- LOGO -->
        <div class="topbar-left">
            <div class="text-center">
                <a href="/" class="logo-dash">SyncroB.it</a>
                <a href="/" class="logo-dash-sm">S</a>
            </div>
        </div>
        <!-- Button mobile view to collapse sidebar menu -->


        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <ul class="list-inline menu-left mb-0">
                    <li class="float-left">
                        <button class="button-menu-mobile open-left waves-light waves-effect">
                            <i class="mdi mdi-menu"></i>
                        </button>
                    </li>
                </ul>

                <ul class="nav navbar-right float-right list-inline">
                    <li class="dropdown d-none d-sm-block">
                        <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light notification-icon-box" data-toggle="dropdown" aria-expanded="true">
                            <i class="fa fa-bell"></i> <span class="badge badge-xs badge-danger"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg">
                            <li class="text-center notifi-title">Notification <span class="badge badge-xs badge-success">3</span></li>
                            <li class="list-group">
                                <!-- list item-->
                                <a href="javascript:void(0);" class="list-group-item">
                                    <div class="media">
                                        <div class="media-heading">Your order is placed</div>
                                        <p class="m-0">
                                            <small>Dummy text of the printing and typesetting industry.</small>
                                        </p>
                                    </div>
                                </a>
                                <!-- list item-->
                                <a href="javascript:void(0);" class="list-group-item">
                                    <div class="media">
                                        <div class="media-body clearfix">
                                            <div class="media-heading">New Message received</div>
                                            <p class="m-0">
                                                <small>You have 87 unread messages</small>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                                <!-- list item-->
                                <a href="javascript:void(0);" class="list-group-item">
                                    <div class="media">
                                        <div class="media-body clearfix">
                                            <div class="media-heading">Your item is shipped.</div>
                                            <p class="m-0">
                                                <small>It is a long established fact that a reader will</small>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                                <!-- last list item -->
                                <a href="javascript:void(0);" class="list-group-item">
                                    <small class="text-primary">See all notifications</small>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                            <img src="{{SB_USER::getUserAvatar(<?=$_SESSION['uID'];?>)}}" alt="user-img" class="rounded-circle">
                        </a>
                        {{SB_THEME::getUserMenu(user_menu)}}
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- Top Bar End -->


    <!-- ========== Left Sidebar Start ========== -->

    <div class="left side-menu">
        <div class="sidebar-inner slimscrollleft">

            <!--<div class="user-details">-->
            <!--<div class="pull-left">-->
            <!--<img src="assets/images/users/avatar-1.jpg" alt="" class="thumb-md img-circle">-->
            <!--</div>-->
            <!--<div class="user-info">-->
            <!--<div class="dropdown">-->
            <!--<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">David Cooper <span class="caret"></span></a>-->
            <!--<ul class="dropdown-menu">-->
            <!--<li><a href="javascript:void(0)"><i class="md md-face-unlock"></i> Profile<div class="ripple-wrapper"></div></a></li>-->
            <!--<li><a href="javascript:void(0)"><i class="md md-settings"></i> Settings</a></li>-->
            <!--<li><a href="javascript:void(0)"><i class="md md-lock"></i> Lock screen</a></li>-->
            <!--<li><a href="javascript:void(0)"><i class="md md-settings-power"></i> Logout</a></li>-->
            <!--</ul>-->
            <!--</div>-->

            <!--<p class="text-muted m-0">Admin</p>-->
            <!--</div>-->
            <!--</div>-->
            <!--- Divider -->


            <div id="sidebar-menu">
                {{SB_THEME::getMenu(main_menu)}}
            </div>
            <div class="clearfix"></div>
        </div> <!-- end sidebarinner -->
    </div>
    <!-- Left Sidebar End -->

