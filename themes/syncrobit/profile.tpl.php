<?php $uD = SB_USER::getUserDetails($_SESSION['uID']); ?>
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
                                <img src="https://avatars.syncrob.it/default/023-goldfish.png" alt="user-img"
                                    class="rounded-circle">
                                <div class="profile-hover"><i class="mdi mdi-camera"></i></div>    
                            </div>
                            <div class="card-body edit-profile-card-body">
                                <span class="m-t-card-60"></span>
                                <h4 class="m-t-0 m-b-15">Edit Personal Details</h4>
                                <form class="row">
                                    <div class="form-group col-lg-6">
                                        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" value="<?=$uD['first_name'];?>">
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" value="<?=$uD['last_name'];?>">
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?=$uD['email'];?>">
                                    </div>

                                    <span class="col-lg-12 m-t-15"></span>

                                    <div class="form-group col-lg-12">
                                        <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="<?=$uD['address'];?>">
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <input type="text" class="form-control" name="city" id="city" placeholder="City" value="<?=$uD['city'];?>">
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <input type="text" class="form-control" name="state" id="state" placeholder="State" value="<?=$uD['state'];?>">
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <input type="text" class="form-control" name="zip_code" id="zip_code" placeholder="Postal Code" value="<?=$uD['zip_code'];?>">
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <input type="text" class="form-control" id="Country" placeholder="Country" value="<?=$uD['country'];?>">
                                    </div>
                                    <div class="col-lg-12 text-right">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light ali">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="m-t-0 m-b-15">Change Password</h4>
                                <form class="row">
                                    <div class="form-group col-lg-12">
                                        <input type="password" class="form-control" id="current_pass" placeholder="Current Password">
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <input type="password" class="form-control" id="new_pass" placeholder="New Password">
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <input type="password" class="form-control" id="renew_pass" placeholder="Confirm new password">
                                    </div>
                                    <div class="col-lg-12 text-right">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Change Password</button>
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