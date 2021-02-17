<!-- container -->
<div class="container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">{{SB_THEME::getPageTitle(<?=$_GET['page'];?>)}}
                </h2>
                <p class="mg-b-0">Mange your hotspot fleet.</p>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content"> 
            <div class="pr-1 mb-3 mb-xl-0"> 
            <button type="button" class="btn btn-danger btn-icon mr-2">
                    <i class="mdi mdi-star"></i>
                </button> 
            </div> 
            <div class="pr-1 mb-3 mb-xl-0"> 
            <button type="button" class="btn btn-warning  btn-icon mr-2">
                    <i class="mdi mdi-refresh"></i>
                </button>
            </div> 
            <div class="pr-1 mb-6 mb-xl-0"> 
                 
            </div> 
        </div>
    </div>
    <!-- /breadcrumb -->

    <div class="row row-sm">
        <div class="col-12">
            <button class="btn btn-primary btn-block wd-150" data-toggle="modal" data-target="#add-hotspot-modal">Add HotSpot</button>
        </div>

    </div>
    <!-- end row -->
</div>
<!-- /Container -->
</div>
<!-- /main-content -->
{{SB_CORE::getModal(add-hotspot)}}