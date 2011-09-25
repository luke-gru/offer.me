<?php

class NoteDisplayer extends BaseDisplayer {
    public $html;

    function __construct($html="") {
        $this->html = $html;
    }

    function __toString() {
        return $this->html;
    }

    function shortFormat(TableObject $note) {
        // get both users by their ids
        $options = array("byID" => array($note->user_from_id, $note->user_to_id));
        $users = UserAggregator::find($options);
        foreach($users as $u) {
            if ($u->id == $note->user_from_id) {
                $userFrom = $u;
            } elseif ($u->id == $note->user_to_id) {
                $userTo = $u;
            }
        }
        //display them
        $noteType = ucfirst($note->type);
        $root = $_SESSION['root'];
        $this->html .= <<<HTML
        <a href="{$root}notes.php?to={$userTo->name}&id={$note->id}">{$noteType} note</a>
        <br />
HTML;
    }

    function longFormat(TableObject $note) {
        // get both users by their ids
        $options = array("byID" => array($note->user_from_id, $note->user_to_id));
        $users = UserAggregator::find($options);
        foreach($users as $u) {
            if ($u->id == $note->user_from_id) {
                $userFrom = $u;
            } elseif ($u->id == $note->user_to_id) {
                $userTo = $u;
            }
        }
        //display them
        $noteType = ucfirst($note->type);
        $root = $_SESSION['root'];
        $this->html .= <<<HTML
        <div class="note">
        From <a href="{$root}users/profile.php?user={$userFrom->name}">{$userFrom->name}</a><br />
        Type of note: <i>{$userFrom->name}'s email</i><br />
        Email: <i>{$userFrom->email}</i>
        </div>
HTML;
        if (!is_null($note->regardingPost)) {
            $this->html .= <<<HTML
            Regarding <a href="{$root}offers.php?id={$note->regardingPost}">this post</a>
HTML;
        }
    }

}
