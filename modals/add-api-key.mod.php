<div id="add-apiKey-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="add-key-label" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form class="form-horizontal" method="post" id="add_key_form" action="">
                <div class="modal-header">
                    <h4 class="modal-title m-0" id="add-key-label">Add API Key</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">    
                        <p>Generate a new API key for your app.</p>
                    </div>
                    <div class="form-group">
                        <input class="form-control a_app_name" id="a_app_name" name="a_app_name" type="text" placeholder="App Name">
                    </div>
                    <div class="form-group">
                    <div class="input-group"> 
                        <input class="form-control disabled api_key_input" id="api_key_input" placeholder="API Key" type="text" readonly="readonly"> 
                        <span class="input-group-btn">
                            <button class="btn btn-primary copy-key-modal" type="button">
                                <span class="input-group-btn"><i class="fas fa-copy"></i></span>
                            </button>
                        </span> 
                    </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-add-key">Add Key</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>