<?php
require_once(realpath('../config/app_tie.php'));
ob_start();
session_start();

?>
<html>
<head>
<style type="text/css">
.user_pic {
float:left;
}
.user {
max-height:80px;
min-height:80px;
margin-bottom:20px;

}

.username {
float:left;
position:relative;
bottom:22px;
margin-left:17px;
font-style:italic;

}

.user_details {
float:left;
margin-left:3em;
margin-top:-1em;
}
div.offering {
float:left;
position:absolute;
left:270px;
}
.user_offers, .user_wants {
float:left;
margin-top:-3em;
margin-bottom:3em;
}
.user_offers {
margin-left:3em;
}

/* divs */
.want {
margin-bottom:2em;
}

.clear {
clear:both;
}

ul.offers {
margin-bottom:-0.2em;
margin-left:-0.2em;
}

.success {
color:green;
}

</style>

<script type="text/javascript">
function getProperPage(obj) {
    var selectValue = obj.value;
    if (selectValue === '') {

    } else if (selectValue === 'all') {
        if (document.location.pathname !== 'offers.php') {
            window.location = 'offers.php';
        }
    } else if (selectValue === 'category') {
        // let php handle this
        window.location = "offers.php?browse_by=categories";
    }
}
</script>

</head>
<body>

<?php
if (isset($_SESSION['user'])) {
    include('templates/logged_in_header.php');
    print <<<HTML
    <form id="browse" action=offers.php method="get">
        <select id="browse_by" onChange="getProperPage(this);">
        <option value=""         name="browse_by">Browse posts</option>
        <option value="all"      name="browse_by">all</option>
        <option value="category" name="browse_by">by category</option>
        </select>
    </form>
HTML;

}

if (isset($_GET['browse_by'])) {
    $basePath = "offers.php?category=";
    print <<<HTML
<div id="categories">
<a href="{$basePath}home_repair">Home repair</a><br />
<a href="{$basePath}gardening">Gardening</a><br />
<a href="{$basePath}carpooling_moving">Carpooling/Moving</a><br />
<a href="{$basePath}teaching">Teaching</a><br />
<a href="{$basePath}care_giving">Caregiving</a><br />
<a href="{$basePath}cooking">Cooking</a><br />
<a href="{$basePath}designing">Designing</a><br />
<a href="{$basePath}accounting">Accounting</a><br />
<a href="{$basePath}dog_walking">Dog Walking</a><br />
</div>
HTML;

} elseif (isset($_GET['category'])) {
    $cat = $_GET['category'];
    $posts = PostHelper::filterPostsByCat($cat);
    $lastDay = "";
    foreach($posts as $p) {
        if (substr($p->timestamp,0,10) != $lastDay) {
            $date = substr($p->timestamp,0,10);
            print <<<HTML
            <p class="date">
            $date
            </p>
HTML;
            $lastDay = $date;
        }
        $display = new PostDisplayer();
        $display->shortFormat($p);
        print $display;
    }

    // browse by => ALL
    // may not be logged in at all. Everyone can potentially see this
} elseif (!isset($_GET['id'])) {
    // display various flash messages
    if (isset($_SESSION['send_email_flash'])) {
        print $_SESSION['send_email_flash'];
        unset($_SESSION['send_email_flash']);
    }
    if (isset($_SESSION['post_flash'])) {
       print $_SESSION['post_flash'];
       unset($_SESSION['post_flash']);
    }

    $options = array("all" => true);
    $posts = Post::find("posts", $options);
    $displays = array();
    $lastDay = "";
    foreach($posts as $post) {
        if (substr($post->timestamp,0,10) != $lastDay) {
            $date = substr($post->timestamp,0,10);
            print <<<HTML
            <p class="date">
            $date
            </p>
HTML;
            $lastDay = $date;
        }
        $display = new PostDisplayer();
        $display->shortFormat($post);
        print $display;
    }

    // show the longFormat of the post of this ID
} elseif (isset($_GET['id'])) {
    $options = array("byID" => array($_GET['id']));
    $posts = Post::find("posts", $options);
    $displays = array();
    foreach($posts as $post) {
        $display = new PostDisplayer();
        $display->longFormat($post);
        print $display;
    }

    // if the client is logged in and the user isn't the
    // current user, show a 'send your email' link
    if (isset($_SESSION['user'])) {
        // get the user associated w/ this post
        $userOfPoster = UserHelper::findUserAssocPostID($_GET['id']);
        if ($_SESSION['user'] != $userOfPoster->name) {
            $regardingPost = $_GET['id'];
            //show the 'send your email' link
            print <<<HTML
            <br />
            <div id="send_your_email">
            <a href="notify.php?user={$userOfPoster->id}&send_email=true&regarding_post={$regardingPost}">Send {$userOfPoster->name} your email</a>
            </div>
HTML;
        }

    }
}
?>

</body>
</html>

