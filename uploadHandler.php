<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */
include("includes/initd.inc.php");
include(SB_LIBS."uploader.lib.php");

// Directory where we're storing uploaded images
// Remember to set correct permissions or it won't work
$uploader = new FileUpload('uploadimg');
$base_uri = SB_CORE::getSetting('avatar_uri')."tmp/";
$result = $uploader->handleUpload(SB_IMG_TMP);
if (!$result) {
    exit(json_encode(array('success' => false, 'msg' => $uploader->getErrorMsg())));
}
echo json_encode(array('success' => true, 'file' => $base_uri . $uploader->getFileName(), "fileName" => $uploader->getFileName()));