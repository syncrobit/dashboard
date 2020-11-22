<div class="content-page">
    <!-- Start content -->
    <div class="content">

        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">{{SB_THEME::getPageTitle(<?=$_GET['page'];?>)}}</h4>
            </div>
        </div>

        <div class="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card edit-profile-card">
                            <div class="change-profile-img" id="change-p-image">
                                <img src="{{SB_USER::getUserAvatar(<?=$_SESSION['uID'];?>)}}" alt="user-img" class="rounded-circle">
                                <div class="profile-hover"><i class="mdi mdi-camera"></i></div>    
                            </div>
                            <div class="card-body edit-profile-card-body">
                                <span class="m-t-card-60"></span>
                                <h4 class="m-t-0 m-b-15">Edit Personal Details</h4>
                                <form class="row" method="post" action="" id="user_details_form">
                                    <div class="form-group col-lg-6">
                                        <input type="text" class="form-control first_name" name="first_name" id="first_name" placeholder="First Name">
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <input type="text" class="form-control last_name" name="last_name" id="last_name" placeholder="Last Name">
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <input type="email" class="form-control email" name="email" id="email" placeholder="Email">
                                    </div>

                                    <span class="col-lg-12 m-t-15"></span>

                                    <div class="form-group col-lg-9">
                                        {{SB_SELECT::getCountryCodesSelect}}
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <input type="text" class="form-control zip_code" name="zip_code" id="zip_code" placeholder="Postal Code" disabled>
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <input type="text" class="form-control address" name="address" id="address" placeholder="Address" value="<?=$uD['address'];?>" disabled>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <input type="text" class="form-control city" name="city" id="city" placeholder="City" disabled>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        {{SB_SELECT::getStateSelect(US)}}
                                    </div>
                                    
                                    <div class="col-lg-12 text-right">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light btn-details-change">
                                            <i class="fa fa-spinner fa-pulse button-spinner" style="display: none"></i>     
                                            <span class="button-label">Save Changes</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="m-t-0 m-b-15">Change Password</h4>
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
                    </div>
                </div>
                <!-- end row -->

            </div><!-- container-fluid -->

        </div> <!-- Page content Wrapper -->

    </div> <!-- content -->

</div>