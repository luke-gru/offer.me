<?php

if (isset($_SESSION['user']) && isset($_SESSION['root'])) {
    $username = $_SESSION['user'];
    $publicRoot = $_SESSION['root'];

    $myProfilePage = $publicRoot . "users/profile.php?user=$username";

    if (!empty($_GET['user'])) {
        $url_user = $_GET['user'];
        $user = UserRetriever::build($url_user);
    }

    $sessionUser = UserRetriever::build($username);

    // get gravatar URL for current user
    $display = new UserDisplayer();
    $gravURL = $display->gravatar($sessionUser->email, 55);
    $gravIMG = "<a href=\"{$myProfilePage}\"><img src=\"{$gravURL}\" /></a>\n";

    $html  = '<div id="header_bar">';
    $html .= $gravIMG . "<br />";
    $html .= "<a href=\"{$publicRoot}offers.php\" id=\"browse_link\">Browse</a>\n<br />\n";
    $html .= "<a href=\"{$publicRoot}index.php?logout=true\" class=\"logout_link\">Log out</a>\n<br />\n";
    $html .= "<a href=\"{$publicRoot}edit.php?user={$username}\">Edit</a>\n<br />\n";
    $html .= "<a href=\"{$publicRoot}post/new.php\">Post want</a>\n";
    $html .= '</div>';
    print $html;
}

?>

