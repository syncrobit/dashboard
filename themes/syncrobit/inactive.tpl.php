<?php SB_AUTH::checkInactive(); ?>
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
                                    <h2 class="text-primary">Just one more step..</h2>
                                    <p>We've sent you a welcome email with an activation link. Simply click on the link
                                        and you are good to go.</p>
                                    <p>Don't worry! If the gremlins in your inbox ate it, just click the button below
                                        and we will send you a new code.</p>
                                    <button class="btn btn-primary btn-block progressButton resend-email" type="button">
                                        <span class="button-progress" style="width: 0%"></span>
                                        <span class="button-label">Resend email</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End -->
            </div>
        </div><!-- End -->
    </div>
</div>