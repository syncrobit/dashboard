<!-- main-sidebar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll">
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-dark active" href="/">
            <span class="main-logo dark-theme logo-format">SyncroB.it</span>
        </a>
        <a class="logo-icon mobile-logo icon-dark active" href="/">
            <span class="logo-icon dark-theme logo-format">S</span>
        </a>
    </div>
    <div class="main-sidemenu">
        <div class="app-sidebar__user clearfix">
            <div class="dropdown user-pro-body">
                <div class="">
                    <img alt="user-img" class="avatar avatar-xl brround profile-image" src="{{SB_USER::getUserAvatar(<?=$_SESSION['uID'];?>)}}">
                </div>
                <div class="user-info">
                    <h4 class="font-weight-semibold mt-3 mb-0">{{SB_USER::getUserName(<?=$_SESSION['uID'];?>)}}</h4>
                    <span class="mb-0 text-muted">{{SB_SUBSCRIPTION::getUserSubType(<?=$_SESSION['uID'];?>)}}</span>
                </div>
            </div>
        </div>
        {{SB_THEME::getMenu(main_menu)}}
    </div>
</aside>
<!-- main-sidebar -->

<!-- main-content -->
<div class="main-content app-content">

    <!-- main-header -->
    <div class="main-header sticky side-header nav nav-item">
        <div class="container-fluid">
            <div class="main-header-left ">
                <div class="responsive-logo">
                    <a href="/">
                        <span class="dark-logo-1 logo-format-1">SyncroB.it</span>
                    </a>
                    <a href="/">
                        <span class="dark-logo-2 logo-format-2">SyncroB.it</span>
                    </a>
                </div>
                <div class="app-sidebar__toggle" data-toggle="sidebar">
                    <a class="open-toggle" href="#"><i class="header-icon fe fe-align-left"></i></a>
                    <a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
                </div>
                <div class="main-header-center ml-3 d-sm-none d-md-none d-lg-block">
					<input class="form-control" placeholder="Search hotspts, addresses..." type="search"> <button class="btn"><i class="fas fa-search d-none d-md-block"></i></button>
				</div>
            </div>
            <div class="main-header-right">
                <div class="nav nav-item  navbar-nav-right ml-auto">
                    <div class="nav-link" id="bs-example-navbar-collapse-1">
                        <form class="navbar-form" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search hotspts, addresses...">
                                    <span class="input-group-btn">
                                        <button type="reset" class="btn btn-default">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <button type="submit" class="btn btn-default nav-link resp-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                        </button>
                                    </span>
                            </div>
                        </form>
				    </div>
                    <div class="dropdown nav-item main-header-notification">
                        <a class="new nav-link" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-bell">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg><span class=" pulse"></span></a>
                        <div class="dropdown-menu">
                            <div class="menu-header-content bg-primary text-left">
                                <div class="d-flex">
                                    <h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">Notifications
                                    </h6>
                                    <span class="badge badge-pill badge-warning ml-auto my-auto float-right">Mark All
                                        Read</span>
                                </div>
                                <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">You have 4
                                    unread Notifications</p>
                            </div>
                            <div class="main-notification-list Notification-scroll">
                                <a class="d-flex p-3 border-bottom" href="#">
                                    <div class="notifyimg bg-pink">
                                        <i class="la la-file-alt text-white"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h5 class="notification-label mb-1">New files available</h5>
                                        <div class="notification-subtext">10 hour ago</div>
                                    </div>
                                    <div class="ml-auto">
                                        <i class="las la-angle-right text-right text-muted"></i>
                                    </div>
                                </a>
                                <a class="d-flex p-3" href="#">
                                    <div class="notifyimg bg-purple">
                                        <i class="la la-gem text-white"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h5 class="notification-label mb-1">Updates Available</h5>
                                        <div class="notification-subtext">2 days ago</div>
                                    </div>
                                    <div class="ml-auto">
                                        <i class="las la-angle-right text-right text-muted"></i>
                                    </div>
                                </a>
                                <a class="d-flex p-3 border-bottom" href="#">
                                    <div class="notifyimg bg-success">
                                        <i class="la la-shopping-basket text-white"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h5 class="notification-label mb-1">New Order Received</h5>
                                        <div class="notification-subtext">1 hour ago</div>
                                    </div>
                                    <div class="ml-auto">
                                        <i class="las la-angle-right text-right text-muted"></i>
                                    </div>
                                </a>
                                <a class="d-flex p-3 border-bottom" href="#">
                                    <div class="notifyimg bg-warning">
                                        <i class="la la-envelope-open text-white"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h5 class="notification-label mb-1">New review received</h5>
                                        <div class="notification-subtext">1 day ago</div>
                                    </div>
                                    <div class="ml-auto">
                                        <i class="las la-angle-right text-right text-muted"></i>
                                    </div>
                                </a>
                                <a class="d-flex p-3 border-bottom" href="#">
                                    <div class="notifyimg bg-danger">
                                        <i class="la la-user-check text-white"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h5 class="notification-label mb-1">22 verified registrations</h5>
                                        <div class="notification-subtext">2 hour ago</div>
                                    </div>
                                    <div class="ml-auto">
                                        <i class="las la-angle-right text-right text-muted"></i>
                                    </div>
                                </a>
                                <a class="d-flex p-3 border-bottom" href="#">
                                    <div class="notifyimg bg-primary">
                                        <i class="la la-check-circle text-white"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h5 class="notification-label mb-1">Project has been approved</h5>
                                        <div class="notification-subtext">4 hour ago</div>
                                    </div>
                                    <div class="ml-auto">
                                        <i class="las la-angle-right text-right text-muted"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="dropdown-footer">
                                <a href="">VIEW ALL</a>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown main-profile-menu nav nav-item nav-link">
                        <a class="profile-user d-flex" href="javascript:void(0);">
                            <img alt="profile image" src="{{SB_USER::getUserAvatar(<?=$_SESSION['uID'];?>)}}" class="profile-image">
                        </a>
                        {{SB_THEME::getUserMenu(user_menu)}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /main-header -->