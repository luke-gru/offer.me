<?php

class UserHelper {

    public static function findUserAssocPostID($postID) {
        $SQL = "SELECT users.username FROM users INNER JOIN posts ON users.id = posts.user_id WHERE posts.id = $postID LIMIT 1;";
        $res = DB::try_query($SQL);
        $row = mysql_fetch_assoc($res);
        $username = $row['username'];
        $user = UserRetriever::build($username);
        return $user;
    }

}

