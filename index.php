<?php
define('ROOT_DIR',realpath(dirname(__FILE__)));
require(ROOT_DIR."/config/config.php");
define("PATH_INFO", true);// PATH_INFO
define("REWRITE", false);// REWRITE 伪静态
require(ROOT_DIR."/app/base/SpeedPHP.php");
spRun();