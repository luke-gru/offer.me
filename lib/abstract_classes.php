<?php

abstract class TableObject {
    protected static function findAll($table=NULL, $customSQL=NULL) {
        if (!$table || !is_string($table)) {
            throw new Exception('abstract class TableObject requires a table [string]');
        }

        if (!$customSQL) {
            $SQL = "SELECT * FROM $table WHERE id = ?";
        } else {
            $SQL = $customSQL;
        }
        $res = DB::try_query($SQL);
        return $res;
    }

    protected static function findById($table=NULL, array $ids) {
        if (!$table || !is_string($table)) {
            throw new Exception('abstract class TableObject requires a table [string]');
        }
        $SQL = "";

    }



    abstract function save();
    abstract function update();
    abstract function destroy();

} // end of {abstract} TableObject

abstract class BaseDisplayer {
    public $html;

    public function __construct($html="") {
        $this->html = $html;
    }

    abstract function shortFormat(TableObject $obj);
    abstract function longFormat(TableObject $obj);
    abstract function __toString();

}

