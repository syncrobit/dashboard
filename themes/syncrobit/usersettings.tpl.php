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
                    <div class="col-sm-8" style="margin:0 auto;">
                        <div class="card">
                            <div class="card-body">
                                <form class="form-horizontal" role="form">
                                <div class="form-group row">
                                        <label class="col-sm-3 control-label" for="wallet-address">Wallet Address</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control wallet-address" id="wallet-address">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 control-label" for="time-zone">Time Zone</label>
                                        <div class="col-sm-9">
                                            {{SB_SELECT::getTimeZoneSelect}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 control-label" for="date_format">Date Format</label>
                                        <div class="col-sm-9 radio">
                                            <input name="date_format" type="radio" id="date_01" class="radio-col-blue" value="M j, Y">
                                            <label for="date_01"><?=date('M j, Y');?></label><br>
                                            <input name="date_format" type="radio" id="date_02" class="radio-col-blue" value="Y-m-d">
                                            <label for="date_02"><?=date('Y-m-d');?></label><br>
                                            <input name="date_format" type="radio" id="date_03" class="radio-col-blue" value="m/d/Y">
                                            <label for="date_03"><?=date('m/d/Y');?></label><br>
                                            <input name="date_format" type="radio" id="date_04" class="radio-col-blue" value="d/m/Y">
                                            <label for="date_04"><?=date('d/m/Y');?></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 control-label" for="time-format">Time Format</label>
                                        <div class="col-sm-9 radio">
                                            <input name="time_format" type="radio" id="time_01" class="radio-col-blue" value="g:i a">
                                            <label for="time_01"><?=date('g:i a');?></label><br>
                                            <input name="time_format" type="radio" id="time_02" class="radio-col-blue" value="g:i A">
                                            <label for="time_02"><?=date('g:i A');?></label><br>
                                            <input name="time_format" type="radio" id="time_03" class="radio-col-blue" value="H:i">
                                            <label for="time_03"><?=date('H:i');?> (24 hour)</label>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light submit-settings">
                                            <i class="fa fa-spinner fa-pulse button-spinner" style="display: none"></i>    
                                            <span class="button-label">Save Changes</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div><!-- container-fluid -->

        </div> <!-- Page content Wrapper -->

    </div> <!-- content -->
    
</div>
