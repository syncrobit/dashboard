<?php
    if(SB_AUTH::checkAuth(2)){
?>

<footer class="footer">
    © <?=date("Y");?> SyncroB.it - All Rights Reserved.
</footer>

</div>
<!-- End Right content here -->

</div>
<!-- END wrapper -->
<?php } ?>

<!-- jQuery  -->
<script src="{{SB_THEME::getResourceJS(jquery.min.js)}}"></script>
<script src="{{SB_THEME::getResourceJS(bootstrap.bundle.min.js)}}"></script>
<script src="{{SB_THEME::getResourceJS(modernizr.min.js)}}"></script>
<script src="{{SB_THEME::getResourceJS(detect.js)}}"></script>
<script src="{{SB_THEME::getResourceJS(fastclick.js)}}"></script>
<script src="{{SB_THEME::getResourceJS(jquery.slimscroll.js)}}"></script>
<script src="{{SB_THEME::getResourceJS(jquery.blockUI.js)}}"></script>
<script src="{{SB_THEME::getResourceJS(waves.js)}}"></script>
<script src="{{SB_THEME::getResourceJS(wow.min.js)}}"></script>
<script src="{{SB_THEME::getResourceJS(jquery.nicescroll.js)}}"></script>
<script src="{{SB_THEME::getResourceJS(jquery.scrollTo.min.js)}}"></script>
<script src="{{SB_THEME::getResourceJS(jquery-validation/dist/jquery.validate.js)}}"></script>
<script src="{{SB_THEME::getResourceJS(jnoty.min.js)}}"></script>

<!--Morris Chart-->
<script src="{{SB_THEME::getResourcePlugins(morris/morris.min.js)}}"></script>
<script src="{{SB_THEME::getResourcePlugins(raphael/raphael-min.js)}}"></script>

<script src="{{SB_THEME::getResourcePlugins(select2/dist/js/select2.min.js)}}"></script>
{{SB_THEME::getDynamicJS(<?=$_GET['page'];?>)}}
{{SB_THEME::getResourceDynamicJS}}
<script src="{{SB_THEME::getResourceJS(app.js)}}"></script>

</body>
</html>
