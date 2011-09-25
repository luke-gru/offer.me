<?php

class UserDisplayer extends BaseDisplayer {
    public $html;

    public function __construct($html="") {
        parent::__construct($html);
    }


    // takes a fully-formed user object
    public function longFormat(TableObject $user) {
        $userOffersString = "<ul class=\"offers\">\n";
        foreach($user->offers as $offer) {
            $userOffersString .= "<li>{$offer}</li>\n";
        }
        $userOffersString .= "</ul>\n";
        $country = strtoupper($user->country);
        $city    = ucfirst($user->city);

        $html  = '<div class="user">';
        $html .= "<div class=\"username\"><h1>{$user->name}</h1></div>";
        $html .= "<div class=\"user_pic\"><a href=\"profile.php?user={$user->name}\"><img src=\"{$this->gravatar($user->email)}\" /></a></div>";
        $html .= "<div class=\"user_details\">" .
            "<i>Country: $country</i>\n<br />\n" .
            "<i>City: $city</i>\n<br />\n" .
            "<div class=\"offering\">\n" .
            "<h3>Offering</h3>\n" .
            "{$userOffersString}" .
            "</div>\n" .
            "</div>\n" .
            "</div>\n" .
            "<br class=\"clear\" />";

        $html .= <<<HTML
        <h3 id="about">About</h3>
        <div class="bio">
        {$user->bio}
        </div>
HTML;
        $this->html = $html;
    }

    public function __toString() {
        return $this->html;
    }

    public function shortFormat(TableObject $user) {
        $this->html  = '<div class="user">';
        $this->html .= "<div class=\"user_pic\"><a href=\"users/profile.php?user={$user->name}\"><img src=\"{$this->gravatar($user->email, 60)}\" /></a></div><br />";
        $this->html .= "<div class=\"username\"><h2>{$user->name}</h2></div>";
        $this->html .= "</div>";
    }

    public function gravatar($email, $size=80) {
        $defaultIMG = "";
        $gravURL = "http://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" .
                    urlencode($defaultIMG) . "&s={$size}";
        return $gravURL;
    }

}

