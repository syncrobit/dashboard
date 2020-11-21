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
<!-- Begin page -->
<div class="accountbg"></div>
<div class="wrapper-page">
    <div class="card">
        <div class="card-body">
            <h3 class="text-center m-t-0 m-b-15">
                <a href="/" class="logo">SyncroB.it</a>
            </h3>
            <h4 class="text-muted text-center m-t-0"><b>Token expired</b></h4>
            <p>It appears that the activation token expired</p>
            <p>Don't worry! Just click the button below and we will send you a new code.</p>
            <button class="btn btn-primary btn-block btn-lg progressButton resend-email" type="button" data-id="<?php echo SB_USER::email2uID($_GET['email']);?>">
                <span class="button-progress" style="width: 0%"></span>
                <span class="button-label">Resend email</span>
            </button>
        </div>

    </div>
</div>