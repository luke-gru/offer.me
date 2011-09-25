<?php
ob_start();
session_start();
require_once(realpath('../config/app_tie.php'));

// can only notify if logged in
if (isset($_SESSION['user'])) {
    // GET['user'] is the user ID
    if (isset($_GET['send_email'], $_GET['user'], $_GET['regarding_post'])) {
        // takes a user_from and user_to (Users)
        $root = $_SESSION['root'];
        $from = UserRetriever::build($_SESSION['user']);
        $toOptions = array("byID" => array($_GET['user']));
        $toAry   = UserAggregator::find($toOptions);
        $to = $toAry[0];

        $options = array('postID' => $_GET['regarding_post']);
        Notifier::sendEmailAddress($from, $to, $options);
        $_SESSION['send_email_flash'] = "<p class=\"success\">Successfully sent email address to {$to->name}</p>";
        header("Location:{$root}offers.php");
    }
}

