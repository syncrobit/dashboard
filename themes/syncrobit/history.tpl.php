<!-- container -->
<div class="container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">{{SB_THEME::getPageTitle(<?=$_GET['page'];?>)}}
                </h2>
                <p class="mg-b-0">View actions performed in your account.</p>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->

    <div class="row row-sm">
        <div class="col-12 mb-3"> 
            <div class="input-group col-md-4 row">
				<div class="input-group-prepend">
					<div class="input-group-text">
						<i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
					</div>
                </div>
                <input class="form-control fc-datepicker" placeholder="MM/DD/YYYY" type="text">
			</div>  
        </div>

        <div class="col-12"> 
            <div class="card"> 
                <div class="card-body"> 
                    <div class="table-responsive mt-2 table-wrapper history-wrapper">
                        {{SB_WATCHDOG::getUserActivity(<?=$_SESSION['uID'];?>)}}
                    </div>
                </div> 
            </div> 
        </div>

    </div>
    <!-- end row -->
</div>
<!-- /Container -->
</div>
<!-- /main-content -->
{{SB_CORE::getModal(view-ip)}}