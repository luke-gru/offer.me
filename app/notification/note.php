<?php

class Note extends TableObject {

    // gets all by default, can also get the new ones only
    public static function findForUser(User $user, $options=array("all" => true)) {
        if ($options['all']) {
            $SQL = "SELECT * FROM notifications WHERE user_to_id = '$user->id';";
        } elseif ($options['new']) {
            $SQL = "SELECT * FROM notifications WHERE user_to_id = '$user->id' AND received = '0';";
        }
        $res = DB::try_query($SQL);
        $notes = array();
        while ($row = mysql_fetch_assoc($res)) {
            $notes[] = new Note($row['id'], $row['user_from_id'],
                $row['user_to_id'], $row['type'], $row['received'],
                $row['regarding_post']);
        }
        // array of all notes
        return $notes;
    }

    public $id;
    public $user_from_id;
    public $user_to_id;
    public $type;
    public $received;
    public $regardingPost;

    function __construct($id, $user_from_id, $user_to_id, $type, $received, $regardingPost=NULL) {
        $this->id = $id;
        $this->user_from_id = $user_from_id;
        $this->user_to_id = $user_to_id;
        $this->type = $type;
        $this->received = $received;
        // optional
        $this->regardingPost = $regardingPost;
    }

    function update() {
        $SQL = "UPDATE notifications SET received = '1' WHERE id = '{$this->id}';";
        $res = DB::try_query($SQL);
        return true;
    }

    // will implement later
    function destroy() {
    }
    // will implement later
    function save() {
    }

}
