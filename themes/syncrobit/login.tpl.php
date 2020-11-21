<!-- Begin page -->
<div class="accountbg"></div>
<div class="wrapper-page">
    <div class="card">
        <div class="card-body">
            <h3 class="text-center m-t-0 m-b-15">
                <a href="/" class="logo">SyncroB.it</a>
            </h3>
            <h4 class="text-muted text-center m-t-0"><b>Sign In</b></h4>

            <form class="form-horizontal m-t-20" id="login-form" action="">

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

                <div class="form-group text-center m-t-40">
                    <div class="col-12">
                        <button class="btn btn-primary btn-block btn-lg waves-effect waves-light login-button" type="submit">
                            <i class="fa fa-spinner fa-pulse button-spinner" style="display: none"></i>
                            <span class="button-label">Log In</span>
                        </button>
                    </div>
                </div>

                <div class="form-group row m-t-30 m-b-0">
                    <div class="col-sm-7">
                        <a href="#" class="text-muted forgot-pwd" data-toggle="modal" data-target="#forgot-pwd">
                            <i class="fa fa-lock m-r-5"></i> Forgot your password?
                        </a>
                    </div>
                    <div class="col-sm-5 text-right">
                        <a href="/register/" class="text-muted">Create an account</a>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

{{SB_CORE::getModal(forgot-pwd)}}