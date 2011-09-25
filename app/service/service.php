<?php

class Service extends TableObject {

    public $id;
    public $name;


    //options["all"]
    //options["byID" => [1,2,3]]
    public static function find($table="services", array $options) {
        if (isset($options["all"])) {
            $customSQL = "SELECT * FROM $table;";

            $res = TableObject::findAll($table, $customSQL);
            if (!$res) {
                die("There was a problem calling TableObject:::findALL in [Service]");
            }

            $services = array();
            while ($row = mysql_fetch_assoc($res)) {
                $service = new Service($row['id'], $row['name']);
                $services[] = $service;
            }
            return $services;
        }
        elseif (isset($options["byID"])) {
            TableObject::findById($table, $options['byID']);
        }
    }


    public function __construct($id, $name) {
        $this->id   = $id;
        $this->name = $name;
    }

    public function save() {
    }

    public function update() {
    }

    public function destroy() {
    }

}

