<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */


require "config.inc.php";
require_once SB_LIBS."sessions.lib.php";
$session = new SB_SESSION();

require SB_LIBS."core.lib.php";
require SB_LIBS."sanitize.lib.php";
require SB_LIBS."theme.lib.php";
require SB_LIBS."auth.lib.php";
require SB_LIBS."watchdog.lib.php";
require SB_LIBS."PHPMailer/src/Exception.php";
require SB_LIBS."PHPMailer/src/PHPMailer.php";
require SB_LIBS."PHPMailer/src/SMTP.php";
require SB_LIBS."emails.lib.php";
require SB_LIBS."user.lib.php";
require SB_LIBS."heliumApiCall.lib.php";
require SB_LIBS."helium.lib.php";
require SB_LIBS."hotspotAnalyzer.lib.php";
require SB_LIBS."hotspots.lib.php";
require SB_LIBS."parseUserAgent.lib.php";
require SB_LIBS."subscription.lib.php";
require SB_LIBS."api.lib.php";

SB_CORE::loadModules();


