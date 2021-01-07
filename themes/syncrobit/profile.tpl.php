<!-- container -->
<div class="container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">{{SB_THEME::getPageTitle(<?=$_GET['page'];?>)}}
                </h2>
                <p class="mg-b-0">Edit your personal information</p>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- row -->
    <div class="row row-sm">
        <div class="col-lg-4">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="pl-0">
                        <div class="main-profile-overview">
                            <div class="main-img-user profile-user" id="profile-edit">
                                <img alt="profile image" src="{{SB_USER::getUserAvatar(<?=$_SESSION['uID'];?>)}}" class="profile-image">
                                <a class="fas fa-camera profile-edit" href="javascript:void(0);"></a>
                            </div>
                            <p class="main-profile-name-text text-center">Member since: {{SB_USER::memberSince(<?=$_SESSION['uID'];?>)}}</p>
                            <hr class="mg-y-20">
                            <label class="main-content-label tx-13 mg-b-20">Menu</label>

                            <div class="tab-menu-heading tabs-style-4">
                                <div class="tabs-menu ">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs mr-0">
                                        <li class="">
                                            <a href="#personal-info" class="active" data-toggle="tab">
                                                <i class="fas fa-user-edit"></i> Personal Information
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#change-pwd" data-toggle="tab">
                                                <i class="fas fa-key"></i> Change Password
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#b-sessions" data-toggle="tab">
                                                <i class="fas fa-user-shield"></i> Active Sessions
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="disable-account">
                                                <i class="fas fa-trash-alt"></i> Delete Account
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div><!-- main-profile-overview -->
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">

                    <!-- <div class="tabs-style-4 "> -->
                        <div class="tabs-menu-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="personal-info">
                                    <div class="tabs-style-4-inner">
                                        <h4 class="profile-tab-title m-t-0 m-b-15">Edit Personal Details</h4>
                                        <form class="row" method="post" action="" id="user_details_form">
                                            <div class="form-group col-lg-6">
                                                <input type="text" class="form-control first_name" name="first_name"
                                                    id="first_name" placeholder="First Name">
                                            </div>

                                            <div class="form-group col-lg-6">
                                                <input type="text" class="form-control last_name" name="last_name"
                                                    id="last_name" placeholder="Last Name">
                                            </div>

                                            <span class="col-lg-12 m-t-15"></span>

                                            <div class="form-group col-lg-9">
                                                {{SB_SELECT::getCountryCodesSelect}}
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <input type="text" class="form-control zip_code" name="zip_code"
                                                    id="zip_code" placeholder="Postal Code" disabled>
                                            </div>

                                            <div class="form-group col-lg-12">
                                                <input type="text" class="form-control address" name="address" id="address"
                                                    placeholder="Address" disabled>
                                            </div>

                                            <div class="form-group col-lg-6">
                                                <input type="text" class="form-control city" name="city" id="city"
                                                    placeholder="City" disabled>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                {{SB_SELECT::getStateSelect(US)}}
                                            </div>

                                            <div class="col-lg-12 text-right">
                                                <button class="btn btn-primary btn-details-change">
                                                    <i class="fa fa-spinner fa-pulse button-spinner"
                                                        style="display: none"></i>
                                                    <span class="button-label">Save Changes</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div> 
                                    <span class="col-lg-12 m-t-20"></span>
                                    <div class="tabs-style-4-inner">
                                        <h4 class="profile-tab-title m-t-0 m-b-15">Change Email</h4>
                                        <form class="row" method="post" action="" id="user_email_form">
                                            <div class="form-group col-lg-12">
                                                    <input type="email" class="form-control email" name="email" id="email"
                                                        placeholder="Email">
                                            </div>
                                            <div class="col-lg-12 text-right">
                                                <button class="btn btn-primary btn-email-change">
                                                    <i class="fa fa-spinner fa-pulse button-spinner"
                                                        style="display: none"></i>
                                                    <span class="button-label">Change Email</span>
                                                </button>
                                            </div>
                                        </form>    
                                    </div>        
                                </div>
                                <div class="tab-pane" id="change-pwd">
                                    <div class="tabs-style-4-inner">
                                        <h4 class="profile-tab-title m-t-0 m-b-15">Change Password</h4>
                                        <form class="row" method="post" action="" id="password_change_form">
                                            <div class="form-group col-lg-12">
                                                <input type="password" class="form-control current_pass" name="current_pass" id="current_pass" placeholder="Current Password">
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <input type="password" class="form-control new_pass" name="new_pass" id="new_pass" placeholder="New Password">
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <input type="password" class="form-control renew_pass" name="renew_pass" id="renew_pass" placeholder="Confirm new password">
                                            </div>
                                            <div class="col-lg-12 text-right">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light btn-pass-change">
                                                    <i class="fa fa-spinner fa-pulse button-spinner" style="display: none"></i>
                                                    <span class="button-label">Change Password</span>
                                                </button>
                                            </div>    
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane" id="b-sessions">
                                    <div class="tabs-style-4-inner">
                                        <h4 class="profile-tab-title m-t-0 m-b-15">Active Sessions</h4>
                                            {{SB_USER::getUserSessions(<?=$_SESSION['uID'];?>)}}
                                    </div>            
                                </div>
                            </div>
                        </div>
                    <!-- </div> -->

                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</div>
<!-- /Container -->
</div>
<!-- /main-content -->
{{SB_CORE::getModal(profile-img)}}