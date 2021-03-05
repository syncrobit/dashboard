<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */

/** Directory Structure */
define("SB_CORE", dirname(dirname(__FILE__))."/");
define("SB_LIBS", SB_CORE."libs/");
define("SB_THEMES", SB_CORE."themes/");
define("SB_MODALS", SB_CORE."modals/");
define("SB_MODULES", SB_CORE."modules/");
define("SB_RESOURCES", SB_CORE."resources/");
define("SB_IMG_TMP", SB_RESOURCES."avatars/tmp/");
define("SB_AVATARS", SB_RESOURCES."avatars/");
define("SB_TMP", SB_CORE."tmp/");

/** MySQL Credentials */
define("SB_DB_HOST", "192.168.170.171");
define("SB_DB_USER", "syncrobit");
define("SB_DB_PASSWORD", "m3rt3c123");
define("SB_DB_DATABASE", "syncrobit");

/** Memcached Credentials */
define("SB_MEMCACHED", "192.168.198.141");
define("SB_MEMCACHED_LONG", "");
define("SB_MEMCACHED_MEDIUM", "");
define("SB_MEMCACHED_FAST", "");

/** Postgres Credentials */

//define("SB_PG_HOST", "etl.dewi.org");
//define("SB_PG_USER", "georgica");
//define("SB_PG_PASSWORD", "n2YuofwiekKX_FuYCPfLBan6KR8F");
//define("SB_PG_DATABASE", "etl");

define("SB_PG_HOST", "192.168.144.115");
define("SB_PG_USER", "etl");
define("SB_PG_PASSWORD", "m3rt3c123");
define("SB_PG_DATABASE", "etl");

/* Theme Options */
define("SB_THEME", "syncrobit");