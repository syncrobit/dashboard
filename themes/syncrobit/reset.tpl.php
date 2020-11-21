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

?>
<!-- Begin page -->
<div class="accountbg"></div>
<div class="wrapper-page">
    <div class="card">
        <div class="card-body">
            <h3 class="text-center m-t-0 m-b-15">
                <a href="/" class="logo">SyncroB.it</a>
            </h3>
            <h4 class="text-muted text-center m-t-0"><b>Reset Password</b></h4>
            <div class="reset-form-wrapper">

                <form class="form-horizontal m-t-20" id="reset-form" action="">
                    <div class="form-group">
                        <div class="col-12">
                            <input class="form-control password" name="password" id="password" type="password" placeholder="Password">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-12">
                            <input class="form-control re_password" name="re_password" id="re_password" type="password" placeholder="Confirm Password">
                        </div>
                    </div>

                    <div class="form-group text-center m-t-40">
                        <div class="col-12">
                            <button class="btn btn-primary btn-block btn-lg waves-effect waves-light reset-submit" type="submit" data-id="<?=SB_USER::email2uID($_GET['email']); ?>">
                                <i class="fa fa-spinner fa-pulse button-spinner" style="display: none"></i>
                                <span class="button-label">Reset Password</span>
                            </button>
                        </div>
                    </div>
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

{{SB_CORE::getModal(forgot-pwd)}}
