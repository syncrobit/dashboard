<div id="upgrade-pgk-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="upgrade-pgk-label" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title m-0" id="upgrade-pgk-label">Packages</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                <span class="mb-3 d-block">Note: Prices are calculated based on the oracle price at the time of payment.</span>
                    <?php 
                    $pgks = SB_SUBSCRIPTION::getAllPackages();
                    echo '<div class="row">';
                    foreach($pgks as $pgk){
                        echo '<div class="col-md-4">'.$pgk.'</div>';
                    }
                    echo '</div>';
                    ?>
                </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>