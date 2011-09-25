<?php

// db
require_once('config.php');
if (Config::$environment == 'dev') {
    Config::$db_name = 'offer_me_dev';
} elseif (Config::$environment == 'prod') {
    Config::$db_name = 'offer_me_prod';
}

require_once('db_connect.php');

$path = realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR .  "..");
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

// abstract classes/implementations/core-ext
// includes {BaseDisplayer}, {TableObject}
require_once('lib/abstract_classes.php');
require_once('lib/core-ext.php');
require_once('lib/implementations.php');

// main classes
require_once('app/user/user.php');
require_once('app/user/user_helper.php');
require_once('app/user/user_displayer.php');
require_once('app/post/post.php');
require_once('app/post/post_helper.php');
require_once('app/post/post_displayer.php');
require_once('app/service/service.php');
require_once('app/notification/note.php');
require_once('app/notification/notifier.php');
require_once('app/notification/note_displayer.php');

// templates
//
// Because I display a flash (bye user!) to the user and only destroy
// her session after the redirect, don't show the logged_in_header HTML
// at that moment
if (!preg_match("/logout=true/", $_SERVER['REQUEST_URI'])) {
    require_once('templates/logged_in_header.php');
}

// vendor
// I never actually used this, but I might some day
//require_once('lib/vendor/Paginated.php');
//require_once('lib/vendor/DoubleBarLayout.php');

