<div class="container-fluid">
    <div class="row no-gutter">
        <!-- The image half -->
        <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
            <div class="row wd-100p mx-auto text-center">
                <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                    <img src="{{SB_THEME::getResourcesImage(media/login.png)}}" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto"
                        alt="logo">
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
                            <div class="card-sigin">
                                <div class="mb-3 d-flex"> 
                                    <a href="{{SB_CORE::getSetting(base_uri)}}" class="logo-format">SyncroB.it</a>
                                </div>
                                <div class="card-sigin">
                                    <div class="main-signup-header">
                                        <h2>Welcome!</h2>
                                        <h5 class="font-weight-semibold mb-4">Please sign in to continue.</h5>
                                        <form id="login-form" action="" method="post">
                                            <div class="form-group">
                                                <input class="form-control username" id="username" name="username" placeholder="Username" type="text" required="">
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control password" id="password" name="password" placeholder="Password" type="password" required="">
                                            </div>
                                                <button class="btn btn-main-primary btn-block" type="submit">
                                                    <span class="button-spinner" style="display:none;">
                                                        <i class="fa fa-spinner fa-pulse"></i>
                                                    </span>
                                                    <span class="button-label">Sign In</span>
                                                </button>
                                        </form>
                                        <div class="main-signin-footer mt-5">
                                            <p>
                                                <a href="#" data-toggle="modal" data-target="#forgot-pwd">
                                                    Forgot password?
                                                </a>
                                            </p>
                                            <p>Don't have an account? <a href="/register/">Create an Account</a>
                                            </p>
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

{{SB_CORE::getModal(forgot-pwd)}}