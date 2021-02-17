<!-- container -->
<div class="container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">{{SB_THEME::getPageTitle(<?=$_GET['page']."/".$_GET['item'];?>)}}
                </h2>
                <p class="mg-b-0">Helium Network summary.</p>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->

    <div class="row row-sm">
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            {{SB_WIDGETS::getBlocksWidget}}
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            {{SB_WIDGETS::getTotalHotspots}}
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            {{SB_WIDGETS::lastCGElection}}
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            {{SB_WIDGETS::circulatingSupply}}  
        </div>  
    </div>
    <!-- end row -->

    <div class="row row-sm">
        <div class="col-md-12 col-lg-12 col-xl-6">
            {{SB_WIDGETS::getDCUsage}}
        </div>
        <div class="col-md-12 col-lg-12 col-xl-6">
            {{SB_WIDGETS::getDCUsageUSD}}
        </div>
    </div>
    <!-- end row -->

    <div class="row row-sm">
        <div class="col-md-12 col-lg-12 col-xl-12">
            {{SB_WIDGETS::getBlockAverageTimes}}
        </div>
    </div>
</div>
<!-- /Container -->
</div>
<!-- /main-content -->