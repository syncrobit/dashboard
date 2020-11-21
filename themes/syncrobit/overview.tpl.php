 <!-- Start right Content here -->

    <div class="content-page">
        <!-- Start content -->
        <div class="content">

            <div class="">
                <div class="page-header-title">
                    <h4 class="page-title">{{SB_THEME::getPageTitle(<?=$_GET['page'];?>)}}</h4>
                </div>
            </div>

            <div class="page-content-wrapper ">

                <div class="container-fluid">

                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-center ">
                                <div class="card-heading">
                                    <h4 class="card-title text-muted mb-0">Block Height</h4>
                                </div>
                                <div class="card-body p-t-10 block_height">
                                    <h2 class="m-t-0 m-b-15"><i class="fas fa-spinner fa-pulse"></i></h2>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-6">
                            <div class="card text-center">
                                <div class="card-heading">
                                    <h4 class="card-title text-muted mb-0">Total Earnings</h4>
                                </div>
                                <div class="card-body p-t-10 total_earnings">
                                    <h2 class="m-t-0 m-b-15"><i class="fas fa-spinner fa-pulse"></i></h2>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-center">
                                <div class="card-heading">
                                    <h4 class="card-title text-muted mb-0">HNT Price</h4>
                                </div>
                                <div class="card-body p-t-10 hnt_price">
                                    <h2 class="m-t-0 m-b-15"><i class="fas fa-spinner fa-pulse"></i></h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="m-t-0">DC Usage</h4>

                                    <ul class="list-inline widget-chart m-t-20 text-center">
                                        <li>
                                            <h4 class=""><b>3654</b></h4>
                                            <p class="text-muted m-b-0">Marketplace</p>
                                        </li>
                                        <li>
                                            <h4 class=""><b>954</b></h4>
                                            <p class="text-muted m-b-0">Last week</p>
                                        </li>
                                        <li>
                                            <h4 class=""><b>8462</b></h4>
                                            <p class="text-muted m-b-0">Last Month</p>
                                        </li>
                                    </ul>

                                    <div id="morris-donut-example" style="height: 300px"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="m-t-0">Data Transfer</h4>

                                    <ul class="list-inline widget-chart m-t-20 text-center">
                                        <li>
                                            <h4 class=""><b>3654</b></h4>
                                            <p class="text-muted m-b-0">Marketplace</p>
                                        </li>
                                        <li>
                                            <h4 class=""><b>954</b></h4>
                                            <p class="text-muted m-b-0">Last week</p>
                                        </li>
                                        <li>
                                            <h4 class=""><b>8462</b></h4>
                                            <p class="text-muted m-b-0">Last Month</p>
                                        </li>
                                    </ul>

                                    <div id="morris-area-example" style="height: 300px"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- end row -->

                    
                </div><!-- container-fluid -->


            </div> <!-- Page content Wrapper -->

        </div> <!-- content -->