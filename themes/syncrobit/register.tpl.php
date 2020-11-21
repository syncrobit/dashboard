<!-- Begin page -->
        <div class="accountbg"></div>
        <div class="wrapper-page">
            <div class="card">

                <div class="card-body">
                    <h3 class="text-center m-t-0 m-b-15">
                        <a href="/" class="logo">SyncroB.it</a>
                    </h3>
                    <h4 class="text-muted text-center m-t-0"><b>Sign Up</b></h4>

                    <div class="col-12">
                        <div class="alert alert-danger registration-error" style="display: none;">
                            <p class="other-error" style="display: none">Registration failed, please try again later...</p>
                        </div>
                    </div>

                    <form class="form-horizontal m-t-20" id="register_user" action="">
                        <div class="form-group">
                            <div class="col-12 input-group">
                                <input class="form-control mr-3 first_name" id="first_name" name="first_name" type="text" placeholder="First Name">
                                <input class="form-control last_name" name="last_name" id="last_name" type="text" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-12">
                                <input class="form-control email" name="email" id="email" type="email" placeholder="Email">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <input class="form-control username" name="username" id="username" type="text" placeholder="Username">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <input class="form-control password" name="password" id="password" type="password" placeholder="Password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <input class="form-control re_pass" name="re_pass" id="re_pass" type="password" placeholder="Confirm Password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <div class="checkbox checkbox-primary">
                                    <input id="tnc" name="tnc" type="checkbox" checked="checked" style="margin-left: 5px;">
                                    <label for="tnc">I accept <a href="#">Terms and Conditions</a>
                                    </label>
                                </div>

                            </div>
                        </div>

                        <div class="form-group text-center m-t-40">
                            <div class="col-12">
                                <button class="btn btn-primary btn-block btn-lg waves-effect waves-light btn-register" type="submit">
                                    <i class="fa fa-spinner fa-pulse button-spinner" style="display: none"></i>
                                    <span class="button-label">Register</span>
                                </button>
                            </div>
                        </div>

                        <div class="form-group m-t-30 m-b-0">
                            <div class="col-sm-12 text-center">
                                <a href="/login/" class="text-muted">Already have an account?</a>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>