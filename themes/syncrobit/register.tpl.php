<div class="container-fluid">
    <div class="row no-gutter">
        <!-- The image half -->
        <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
            <div class="row wd-100p mx-auto text-center">
                <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                    <img src="{{SB_THEME::getResourcesImage(media/login.png)}}"
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
                            <div class="card-sigin">
                                <div class="mb-3 d-flex">
                                    <a href="{{SB_CORE::getSetting(base_uri)}}" class="logo-format">SyncroB.it</a>
                                </div>
                                <div class="main-signup-header">
                                    <h2 class="text-primary">Get Started</h2>
                                    <h5 class="font-weight-normal mb-4">It's free to signup and only takes a minute.
                                    </h5>
                                    <div class="alert alert-danger mg-b-15 registration-error" role="alert" style="display:none"> 
                                        <strong>Oh snap!</strong> Registration cannot be completed
                                    </div>
                                    <form action="#" method="post" id="register_user">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input class="form-control mr-3 first_name" id="first_name"
                                                    name="first_name" type="text" placeholder="First Name">
                                                <input class="form-control last_name" name="last_name" id="last_name"
                                                    type="text" placeholder="Last Name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control email" name="email" id="email" type="email"
                                                placeholder="Email">
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control username" name="username" id="username"
                                                type="text" placeholder="Username">
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control password" name="password" id="password"
                                                type="password" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control re_pass" name="re_pass" id="re_pass"
                                                type="password" placeholder="Confirm Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="checkbox checkbox-primary">
                                                <input id="tnc" name="tnc" type="checkbox" checked="checked"
                                                    style="margin-left: 5px;">
                                                <label for="tnc">I accept <a href="/tnc/">Terms and Conditions</a>
                                                </label>
                                            </div>
                                        </div>
                                        <button class="btn btn-main-primary btn-block">
                                            <span class="button-spinner" style="display:none;">
                                                <i class="fa fa-spinner fa-pulse"></i>
                                            </span>
                                            <span class="button-label">Create Account</span>
                                        </button>
                                    </form>
                                    <div class="main-signup-footer mt-5">
                                        <p>Already have an account? <a href="/login/">Sign In</a></p>
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