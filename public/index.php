<?php
ob_start();
session_start();
require_once(realpath('../config/app_tie.php'));

if (isset($_GET['logout']) && isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    print "<h3>Bye {$user}!";
    session_destroy();
}

if (isset($_POST['sign_in']) && !empty($_POST['username']) &&
!empty($_POST['password'])) {
    $username = $_POST['username'];
    $pass     = $_POST['password'];

    $hashed_pass = sha1($pass);

    $authUserSQL = "SELECT * FROM users WHERE username = '{$username}' " .
                   " AND encrypted_password = '{$hashed_pass}'";
    $result = mysql_query($authUserSQL);

    if (mysql_num_rows($result) == 0) {
        print "<br />Wrong password";
    } else {
        $_SESSION['user'] = $username;
        session_write_close();
        header("Location: users/profile.php?user={$username}");
    }
}

?>

<html>
  <body>
    <title>Offer me</title>
    <h1>Offer me</h1>
    <a href="register.php">Register</a><br /><br />

    <h4>Login</h4>
    <form action="index.php" method="post">

    <label for="username">Username:</label>
    <input type="text" name="username" id="username" /><br />

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" /><br />

    <input type="submit" value="sign in" name="sign_in" />

    </form>
  </body>
</html>

