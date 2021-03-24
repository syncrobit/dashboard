<!-- container -->
<div class="container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Hi {{SB_USER::getUserFirstName(<?=$_SESSION['uID'];?>)}}, welcome back!</h2>
                <p class="mg-b-0">Network & Hotspots overview.</p>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content"> 
            <div class="mb-12 mb-xl-12"> 
                {{SB_SELECT::buildUserWalletSelect}}
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            {{SB_WIDGETS::getBlocksWidget}}
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            {{SB_WIDGETS::getDailyEarnings}}
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            {{SB_WIDGETS::totalEarnings}}
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            {{SB_WIDGETS::oraclePrice}}
        </div>
    </div>
    <!-- row closed -->

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-md-12 col-lg-12 col-xl-6">
            {{SB_WIDGETS::getWeeklyEarnings}}
        </div>
        <div class="col-lg-12 col-xl-6">
            {{SB_WIDGETS::getMonthlyEarnings}}
        </div>
    </div>
    <!-- row closed -->
    <div class="row row-sm">
        <div class="col-md-12 col-lg-12 col-xl-12">
            {{SB_WIDGETS::top10EarningHS}}
        </div>
    </div>
    <!-- row closed -->

</div>
<!-- /Container -->
</div>
<!-- /main-content -->