<?php

class Matcher {
    // user here must have public property $offers (not empty)
    public static function getRelevantMatches(User $user) {
        if (empty($user->offers)) {
            throw new Exception('Matcher::getRelevantMatches must take a user with ' .
                                'non-empty +offers property [array]');
        }
        // let's match them up
            $SQLStart = "SELECT users.id FROM users INNER JOIN user_services ON user_services.user_id = users.id WHERE (";

            $offerMatchesSQL = $SQLStart;
        foreach($user->offers as $offer) {
            $offerMatchesSQL .= "(user_services.service = '{$offer}' && user_services.want = 1) OR ";
        }
        $offerMatchesSQL = substr($offerMatchesSQL, 0, -5);
        $offerMatchesSQL .= "))";

        $resultOfferMatches = mysql_query($offerMatchesSQL);
        if (!$resultOfferMatches) {
            die("Invalid query: ({$offerMatchesSQL})" . mysql_error());
        }
        $offerMatchIDs = array();
        while ($row = mysql_fetch_assoc($resultOfferMatches)) {
            $offerMatchIDs[] = $row;
        }
    }

}
