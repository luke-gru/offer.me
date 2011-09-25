<?php
ob_start();
session_start();
require_once(realpath('../../config/app_tie.php'));
?>

<?php

if (isset($_SESSION['user'], $_POST['post'], $_POST['want'])) {
    $username = $_SESSION['user'];
    $root = $_SESSION['root'];
    $user = UserRetriever::build($username);

    $content = addslashes($_POST['content']);
    $title   = addslashes($_POST['title']);
    $want   = $_POST['want'];

    //Post takes ($id, $userID, $title, $body, $services=NULL, $username=NULL) {
    $post    = new Post(NULL, $user->id, $title, $content, NULL, $want, $user->name);
    $res     = $post->save();
    if ($res) {
        $_SESSION['post_flash'] = "<p class=\"success\">Post successful</p>\n";
        session_write_close();
        header("Location:{$root}offers.php");
    }
}

?>
<html>
<head>
<style type="text/css">
.spacer {
margin-bottom:30px;
}
</style>

<script type="text/javascript">
</script>

</head>
<body>

<h1>Post Want</h1>

<form action="new.php" method="post">

Title<input type="text" name="title" /><br />

<div id="wants_section">

<h3>Pick a Want</h3>
<p>What kind of services are you looking for?</p><br />
<input type="radio" name="want" value="home_repair" />
Home Repair<br />
<input type="radio" name="want" value="gardening" />
Gardening<br />
<input type="radio" name="want" value="carpooling_moving" />
Carpooling/Moving<br />
<input type="radio" name="want" value="teaching" />
Teaching<br />
<input type="radio" name="want" value="care_giving" />
Caregiving<br />
<input type="radio" name="want" value="cooking" />
Cooking<br />
<input type="radio" name="want" value="designing" />
Designing<br />
<input type="radio" name="want" value="accounting" />
Accounting<br />
<input type="radio" name="want" value="dog_walking" />
Dog Walking<br />

</div>
<br class="spacer"/>

<textarea class="post" name="content" rows="7" cols="40">
</textarea>


<input type="submit" value="Done" name="post" />
</form>
</body>
</html>

