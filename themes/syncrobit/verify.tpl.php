<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */
 
if(isset($_GET['email']) && isset($_GET['hash'])) {
    if(SB_USER::checkIfAccountActive(SB_USER::email2uID($_GET['email']))){
        if(SB_AUTH::checkAuth()){
            header("Location: /overview/", true, 302);
            exit();
        }
    }

    if (SB_AUTH::checkActivationHash($_GET['email'], $_GET['hash'])) {
        SB_AUTH::updateActivationStatus($_GET['email']);
        if(SB_AUTH::checkAuth()){
            header("Location: /overview/", true, 302);
            exit();
        }
    }
}else{
    header("Location: /login/", true, 302);
    exit();
}

?>

<div class="container-fluid">
    <div class="row no-gutter">
        <!-- The image half -->
        <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
            <div class="row wd-100p mx-auto text-center">
                <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                    <img src="{{SB_THEME::getResourcesImage(media/verify.png)}}"
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
                                    <h2 class="text-primary">Token expired</h2>
                                    <p>It appears that the activation token expired</p>
                                    <p>Don't worry! Just click the button below and we will send you a new code.</p>
                                    <button class="btn btn-primary btn-block progressButton resend-email" type="button" data-id="<?php echo SB_USER::email2uID($_GET['email']);?>">
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