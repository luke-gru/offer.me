<?php
// connect to db
$link = mysql_connect(Config::$db_host, Config::$db_user, Config::$db_pass);

if (!$link) {
    die('Could not connect to db: ' . mysql_error());
}

$db_selected = mysql_select_db(Config::$db_name, $link);

if (!$db_selected) {
    die ("Can't use db foo : " . mysql_error());
}

