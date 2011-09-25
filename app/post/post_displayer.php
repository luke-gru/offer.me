<?php

class PostDisplayer extends BaseDisplayer {
    public $html;

    public function __construct($html="") {
        parent::__construct($html);
    }

    public function __toString() {
        return $this->html;
    }

    // takes a post object and shows it in full
    public function longFormat(TableObject $post) {
        // TODO: fix this
        $userWhoPosted = UserRetriever::build($post->username['username']);
        User::retrieveOffers($userWhoPosted);
        $userDisplayer = new UserDisplayer($userWhoPosted);
        $userDisplayer->shortFormat($userWhoPosted);
        $this->html  = <<<HTML
        <div class="post">
HTML;
        $this->html .= "<h2>$post->title</h2>";
        $this->html .= $userDisplayer;

        $this->html .= '<div class="user_wants">';
        $this->html .= "<h3>Wants</h3>";
        foreach($post->services as $s) {
            $this->html .= '<i class="service_name">';
            $this->html .= $s->name;
            $this->html .= '</i><br />';
        }
        $this->html .= '</div>';

        $this->html .= '<div class="user_offers">';
        $this->html .= "<h3>Offers</h3>";
        foreach($userWhoPosted->offers as $o) {
            $this->html .= '<i class="service_name">';
            $this->html .= $o;
            $this->html .= '</i><br />';
        }
        $this->html .= '</div><br class="clear" />';


        $this->html .= <<<HTML
        <h3>Details</h3>
        <div class="content">
        $post->body
        </div>
        </div>
HTML;

    }

    // Takes a post object and shows it as a link.
    public function shortFormat(TableObject $post) {
        $postWantString  = "";
        $postWantString  = "<div class=\"want\"><a class=\"want_link\" href=\"offers?id={$post->id}\">$post->title</a>\n</div>\n";
        $this->html = $postWantString;
    }

}

