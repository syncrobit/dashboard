<?php 
if(SB_AUTH::checkAuth(2) && SB_THEME::checkIfPageSecure($_GET['page'])){ ?>
<!-- Footer opened -->
<div class="main-footer ht-40">
    <div class="container-fluid pd-t-0-f ht-100p">
        <span>Copyright © <?=date("Y"); ?> <a href="https://syncrob.it/">SyncroB.it</a>. All rights reserved.</span>
    </div>
</div>
<!-- Footer closed -->
<?php } ?>

</div>
<!-- End Page -->

<!-- JQuery min js -->
<script src="{{SB_THEME::getResourcePlugins(jquery/jquery.min.js)}}"></script>

<!-- Bootstrap Bundle js -->
<script src="{{SB_THEME::getResourcePlugins(bootstrap/js/bootstrap.bundle.min.js)}}"></script>

<!-- Ionicons js -->
<script src="{{SB_THEME::getResourcePlugins(ionicons/ionicons.js)}}"></script>

<!-- Moment js -->
<script src="{{SB_THEME::getResourcePlugins(moment/moment.js)}}"></script>

<!-- eva-icons js -->
<script src="{{SB_THEME::getResourceJs(eva-icons.min.js)}}"></script>

<!-- Validate JS -->
<script src="{{SB_THEME::getResourceJs(jquery-validation/dist/jquery.validate.min.js)}}"></script>

<?php 
if(SB_AUTH::checkAuth(2) && SB_THEME::checkIfPageSecure($_GET['page'])){ 
?>
    <!--Internal  Perfect-scrollbar js -->
    <script src="{{SB_THEME::getResourcePlugins(perfect-scrollbar/perfect-scrollbar.min.js)}}"></script>
    <script src="{{SB_THEME::getResourcePlugins(perfect-scrollbar/p-scroll.js)}}"></script>

    <!-- Sticky js -->
    <script src="{{SB_THEME::getResourceJs(sticky.js)}}"></script>
    <script src="{{SB_THEME::getResourceJs(modal-popup.js)}}"></script>

    <!-- SweetAlert js-->
    <script src="{{SB_THEME::getResourcePlugins(sweet-alert/sweetalert.min.js)}}"></script>

    <!-- MapBox js-->
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.js'></script>

    <!-- Left-menu js-->
    <script src="{{SB_THEME::getResourcePlugins(side-menu/sidemenu.js)}}"></script>
    <script src="{{SB_THEME::getResourceJs(common.js)}}"></script>
<?php } ?>
<!-- Notifications -->
<script src="{{SB_THEME::getResourceJs(jnoty.min.js)}}"></script>

<!-- custom js -->
<script src="{{SB_THEME::getResourceJs(custom.js)}}"></script>

<!-- Page js -->
{{SB_THEME::getDynamicJS(<?=$_GET['page'];?>)}}
{{SB_THEME::getResourceDynamicJS}}

</body>

</html>