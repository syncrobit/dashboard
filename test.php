<?php
include "includes/initd.inc.php";

//SB_EMAILS::activationEmail('partene.george@gmail.com', 'test');

//echo SB_HELIUM::getLastWeekBalance();
var_dump(SB_USER::getUserSettings($_SESSION['uID']));