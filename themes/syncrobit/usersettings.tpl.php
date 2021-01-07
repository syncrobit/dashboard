<!-- container -->
<div class="container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">{{SB_THEME::getPageTitle(<?=$_GET['page'];?>)}}
                </h2>
                <p class="mg-b-0">Edit your account wallets, date&time, API Keys and subscription. </p>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->

    <div class="row row-sm">
        <div class="col-lg-4">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="pl-0">
                        <div class="main-profile-overview">
                            <div class="tab-menu-heading tabs-style-4">
                                <div class="tabs-menu ">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs mr-0">
                                        <li>
                                            <a href="#acct-settings" class="active" data-toggle="tab">
                                                <i class="fas fa-cogs"></i> Settings
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#api-keys" data-toggle="tab">
                                            <i class="fas fa-code"></i> API Keys
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#acct-wallets" data-toggle="tab">
                                                <i class="fas fa-wallet"></i> Wallets
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#acct-membership" data-toggle="tab">
                                                <i class="fas fa-file-invoice-dollar"></i> Subscription
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div><!-- main-profile-overview -->
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">

                    <!-- <div class="tabs-style-4 "> -->
                        <div class="tabs-menu-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="acct-settings">
                                    <div class="tabs-style-4-inner">
                                        <h4 class="profile-tab-title m-t-0 m-b-15">Account Settings</h4>
                                        <form class="form-horizontal" role="form">
                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label" for="time-zone">Time Zone</label>
                                                <div class="col-sm-9">
                                                    {{SB_SELECT::getTimeZoneSelect}}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label" for="date_format">Date Format</label>
                                                <div class="col-sm-9 radio">
                                                    <label class="rdiobox">
                                                        <input name="date_format" type="radio" id="date_01" value="M j, Y">
                                                        <span><?=date('M j, Y');?></span><br>
                                                    </label>
                                                    <label class="rdiobox">
                                                        <input name="date_format" type="radio" id="date_02" value="Y-m-d">
                                                        <span><?=date('Y-m-d');?></span><br>
                                                    </label>
                                                    <label class="rdiobox">
                                                        <input name="date_format" type="radio" id="date_03" value="m/d/Y">
                                                        <span><?=date('m/d/Y');?></span><br>
                                                    </label>
                                                    <label class="rdiobox">
                                                        <input name="date_format" type="radio" id="date_04" value="d/m/Y">
                                                        <span><?=date('d/m/Y');?></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label" for="time-format">Time Format</label>
                                                <div class="col-sm-9 radio">
                                                    <label class="rdiobox">
                                                        <input name="time_format" type="radio" id="time_01" value="g:i a">
                                                        <span><?=date('g:i a');?></span><br>
                                                    </label>
                                                    <label class="rdiobox">
                                                        <input name="time_format" type="radio" id="time_02" value="g:i A">
                                                        <span><?=date('g:i A');?></span><br>
                                                    </label>
                                                    <label class="rdiobox">
                                                        <input name="time_format" type="radio" id="time_03" value="H:i">
                                                        <span><?=date('H:i');?> (24 hour)</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <button type="submit" class="btn btn-primary submit-settings">
                                                    <i class="fa fa-spinner fa-pulse button-spinner" style="display: none"></i>    
                                                    <span class="button-label">Save Changes</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>        
                                </div>
                                <div class="tab-pane" id="api-keys">
                                    <div class="tabs-style-4-inner">
                                        <h4 class="profile-tab-title m-t-0 m-b-15">API Keys</h4>
                                        <div class="row col-md-12 mb-3">
                                            <button type="button" class="btn btn-primary add-apiKey">
                                                <span class="button-label">Add Key</span>
                                            </button>
                                        </div>
                                        {{SB_API::getUserKeys(<?=$_SESSION['uID'];?>)}}
                                    </div>
                                </div>
                                <div class="tab-pane" id="acct-wallets">
                                    <div class="tabs-style-4-inner">
                                        <h4 class="profile-tab-title m-t-0 m-b-15">Wallets</h4>
                                        <div class="row col-md-12 mb-3">
                                            <button type="button" class="btn btn-primary add-wallet" data-toggle="modal" data-target="#add-wallet-modal">
                                                <span class="button-label">Add Wallet</span>
                                            </button>
                                        </div>
                                        {{SB_USER::getUserWallets(<?=$_SESSION['uID'];?>)}}
                                    </div>
                                </div>
                                <div class="tab-pane" id="acct-membership">
                                    <div class="tabs-style-4-inner">
                                        <h4 class="profile-tab-title m-t-0 m-b-15">Subscription</h4>
                                        {{SB_SUBSCRIPTION::getUserSubInfo(<?=$_SESSION['uID'];?>)}}
                                        <hr class="mg-y-20">
                                        <div class="row">
                                            <div class="col-md-9 d-flex align-items-center">
                                                <h5 class="mb-0">Billing & Payment History</h5>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="d-flex my-xl-auto right-content">
                                                    {{SB_SELECT::billingFilterSelect}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive mt-2 table-wrapper history-wrapper">
                                            {{SB_SUBSCRIPTION::getPaymentHistory(<?=$_SESSION['uID'];?>)}}
                                        </div>
                                    </div>            
                                </div>
                            </div>
                        </div>
                    <!-- </div> -->

                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</div>
<!-- /Container -->
</div>
<!-- /main-content -->
{{SB_CORE::getModal(add-wallet)}}
{{SB_CORE::getModal(add-api-key)}}
{{SB_CORE::getModal(edit-wallet)}}
{{SB_CORE::getModal(upgrade-pkgs)}}