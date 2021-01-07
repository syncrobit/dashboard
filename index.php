<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */
include ("includes/initd.inc.php");

SB_THEME::switchPage(isset($_GET['page']) ? $_GET['page'] : '');
