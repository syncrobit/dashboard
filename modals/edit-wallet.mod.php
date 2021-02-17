<div id="edit-wallet-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit-wallet-label" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form class="form-horizontal" method="post" id="edit_wallet_form" action="">
                <input class="ew_id" id="ew_id" name="ew_id" type="hidden">
                <div class="modal-header">
                    <h4 class="modal-title m-0" id="edit-wallet-label">Edit Wallet</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">    
                        <p>Edit wallet details.</p>
                    </div>
                    <div class="form-group">
                        <input class="form-control ew_nickname" id="ew_nickname" name="ew_nickname" type="text" placeholder="Wallet Nickname">
                    </div>
                    <div class="form-group">
                        <input class="form-control ew_addr" id="ew_addr" name="ew_addr" type="text" placeholder="Wallet Address">
                    </div>
                    <div class="checkbox checkbox-primary">
                        <input id="eprimary" name="eprimary" class="eprimary" type="checkbox">
                        <label for="eprimary">Primary Wallet</label>
                        <a href="javascript:void(0);" data-container="body" data-popover-color="head-primary" title="" data-placement="top" data-content="By checking this box, wallet will be set as primary" data-original-title="Primary Wallet">
                            <i class="fas fa-question-circle"></i>
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-edit-wallet">Edit Wallet</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>