<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */

if(!isset($_GET['email']) && !isset($_GET['hash']) || !SB_AUTH::checkForgotPwdHash($_GET['email'], $_GET['hash'])) {
    header("Location: /login/", true, 302);
    exit();
}

$uID = SB_USER::email2uID($_GET['email']);
?>

<div class="container-fluid">
    <div class="row no-gutter">
        <!-- The image half -->
        <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
            <div class="row wd-100p mx-auto text-center">
                <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                    <img src="{{SB_THEME::getResourcesImage(media/forgotpwd.png)}}"
                        class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
                </div>
            </div>
        </div>
        <!-- The content half -->
        <div class="col-md-6 col-lg-6 col-xl-5">
            <div class="login d-flex align-items-center py-2">
                <!-- Demo content-->
                <div class="container p-0">
                    <div class="row">
                        <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                            <div class="mb-2 d-flex mx-auto"> 
                                <a href="{{SB_CORE::getSetting(base_uri)}}" class="logo-format">SyncroB.it</a>
                            </div>
                            <div class="main-card-signin d-md-flex">
                                <div class="p-4 wd-100p">
                                    <div class="main-signin-header">
                                        <div class="avatar avatar-xxl avatar-xxl mx-auto text-center mb-2">
                                            <img class="avatar avatar-xxl rounded-circle  mt-2 mb-2 " src="<?=SB_USER::getUserAvatar($uID);?>"  alt="profile img">
                                        </div>
                                        <div class="mx-auto text-center mt-4 mg-b-20">
                                            <h5 class="mg-b-10 tx-16"><?=SB_USER::getUserName($uID);?></h5>
                                            <p class="tx-16 text-muted">Enter your new password</p>
                                        </div>
                                        <div class="reset-form-wrapper">
                                            <form action="" id="reset-form" method="post">
                                                <div class="form-group">
                                                    <input class="form-control password" name="password" id="password" placeholder="New password" type="password">
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control re_password" name="re_password" id="re_password" placeholder="Confirm password" type="password">
                                                </div>
                                                <button class="btn btn-main-primary btn-block reset-submit" data-id="<?=$uID;?>">
                                                    <i class="fa fa-spinner fa-pulse button-spinner" style="display: none"></i>
                                                    <span class="button-label">Reset Password</span>
                                                </button>
                                            </form>
                                        </div>
                                        
                                        <div class="successful-reset-wrapper" style="display: none;">
                                            <div class="col-12">
                                                <p>Your password was successfully reset. You can now login with your new password.</p>
                                                <a href="/login/" class="btn btn-primary btn-block btn-lg waves-effect waves-light">
                                                    <span class="button-label">Go to Login</span>
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End -->
            </div>
        </div><!-- End -->
    </div>
</div>