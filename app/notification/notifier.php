<?php

class Notifier {

    // regardingPost is an optional array of
    // array("postID" => $postID)
    public static function sendEmailAddress(User $from, User $to, $regardingPost=array()) {
        if (empty($regardingPost)) {
            $SQL = "INSERT INTO notifications VALUES (NULL, '$from->id', '$to->id', 'email', 0, NULL);";
        } else {
            $SQL = "INSERT INTO notifications VALUES (NULL, '$from->id', '$to->id', 'email', 0, {$regardingPost['postID']});";
        }
        $res = DB::try_query($SQL);
        return true;
    }

}

