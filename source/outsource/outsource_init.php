<?php

//session_start();
//error_reporting(E_ALL ^ E_NOTICE);

ini_set("display_errors", "1");
ini_set("display_startup_errors", "1");

global $mysql_user, $mysql_pwd, $mysql_host, $mysql_db;
$mysql_user = "root";
$mysql_pwd = "123456";
$mysql_host = "localhost";
$mysql_db = "codingcopy";


$cCharset = "utf-8";
header("Content-Type: text/html; charset=" . $cCharset);

loadObjectsInPath(dirname(__FILE__).'/swich-connection/');
loadObjectsInPath(dirname(__FILE__).'/domain/');


global $globalParam;
$globalParam = parse_ini_file('global.ini', true);

function loadObjectsInPath($path) {
    $r = new DirectoryIterator($path);
    foreach ($r as $b) {
        if (strtolower($b->getExtension()) === 'php') {
            include_once ($b->getPathname());
        }
    }
}

if (!isset($globalParam['logMod'])) {
    $globalParam['logMod'] = 'file';
}
//Log4Service::setLogMod($globalParam['logMod']);