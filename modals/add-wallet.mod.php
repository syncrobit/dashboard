<div id="add-wallet-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="add-wallet-label" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form class="form-horizontal" method="post" id="add_wallet_form" action="">
                <div class="modal-header">
                    <h4 class="modal-title m-0" id="add-wallet-label">Add Wallet</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">    
                        <p>Add a new wallet to be tracked in your dashobard.</p>
                    </div>
                    <div class="form-group">
                        <input class="form-control w_nickname" id="w_nickname" name="w_nickname" type="text" placeholder="Wallet Nickname">
                    </div>
                    <div class="form-group">
                        <input class="form-control w_addr" id="w_addr" name="w_addr" type="text" placeholder="Wallet Address">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-add-wallet">Add Wallet</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>