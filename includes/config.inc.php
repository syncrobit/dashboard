<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */

/** Directory Structure */
define("SB_CORE", dirname(dirname(__FILE__))."/");
define("SB_LIBS", SB_CORE."libs/");;
define("SB_THEMES", SB_CORE."themes/");
define("SB_MODALS", SB_CORE."modals/");
define("SB_MODULES", SB_CORE."modules/");
define("SB_RESOURCES", SB_CORE."resources/");

/** MySQL Credentials */
define("SB_DB_HOST", "127.0.0.1");
define("SB_DB_USER", "syncrobit");
define("SB_DB_PASSWORD", "m3rt3c123");
define("SB_DB_DATABASE", "syncrobit");

/* Theme Options */
define("SB_THEME", "syncrobit");