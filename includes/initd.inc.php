<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */
session_start();

require "config.inc.php";
require SB_LIBS."core.lib.php";
require SB_LIBS."openvpn.lib.php";
require SB_LIBS."theme.lib.php";
require SB_LIBS."auth.lib.php";
require SB_LIBS."PHPMailer/src/Exception.php";
require SB_LIBS."PHPMailer/src/PHPMailer.php";
require SB_LIBS."PHPMailer/src/SMTP.php";
require SB_LIBS."emails.lib.php";
require SB_LIBS."user.lib.php";
require SB_LIBS."heliumApiCall.lib.php";
require SB_LIBS."helium.lib.php";

