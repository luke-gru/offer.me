<?php

class Post extends TableObject {
    public $id;
    public $userID;
    public $title;
    public $body;
    public $timestamp;
    // array of service names
    public $services;
    // in the username associated with the post
    public $username;


    //options["all"]
    //options["byID" => [1,2,3]]
    //options["filter" => "byCategory", "sql" => SQL]
    public static function find($table="posts", array $options) {
        if (isset($options["all"])) {
            $SQL = "SELECT posts.id, posts.user_id, posts.title, posts.content, posts.time, post_details.service_id FROM $table INNER JOIN post_details ON posts.id = post_details.post_id ORDER BY id DESC;";
        } elseif (isset($options["byID"])) {
            $SQL = "SELECT posts.id, posts.user_id, posts.title, posts.content, posts.time, post_details.service_id FROM $table INNER JOIN post_details ON posts.id = post_details.post_id WHERE ";
            foreach($options["byID"] as $id) {
                $SQL .= "posts.id = $id OR ";
            }
            // get rid of the last 'or'
            $SQL  = substr($SQL, 0, -4);
            $SQL .= " ORDER BY posts.id DESC;";
        } elseif (isset($options["filter"])) {
            $SQL = $options["SQL"];
        } else {
            $SQL = 'error';
        }

        $res = mysql_query($SQL);
        if (!$res) {
            die("sql error: ($SQL)");
        }

        $posts = array();
        $allServices = Service::find("services", array("all" => true));
        // myServices['id'] = array(Service Obj1, Service Obj2) etc...
        $myServices = array();
        $idTracker = array();
        while ($row = mysql_fetch_assoc($res)) {
            // I have no idea why I need to enforce this, but debugging told
            // me I need to (i.e: checking print_r told me there were two
            // copies of each entry. TODO: ask why!
            if (!in_array($row['id'], $idTracker)) {
                $idTracker[] = $row['id'];

                foreach($allServices as $service) {
                    if ($service->id == $row['service_id']) {
                        if (!isset($myServices[ $row['id'] ])) {
                            $myServices[ $row['id'] ] = array(new Service($service->id, $service->name));
                        } else {
                            array_push($myServices[ $row['id'] ], new Service($service->id, $service->name));
                        }
                    }
                }
                $usernameSQL = "SELECT users.username FROM users INNER JOIN posts ON users.id = posts.user_id WHERE users.id = '{$row['user_id']}' LIMIT 1;";
                $res2 = DB::try_query($usernameSQL);
                $username = mysql_fetch_assoc($res2);
                $post = new Post($row['id'], $row['user_id'], $row['title'], $row['content'], $row['time'], $myServices[ $row['id'] ], $username);
                $posts[] = $post;
            }
        }
        return $posts;
    }


    function __construct($id, $userID, $title, $body, $timestamp, $services=NULL, $username=NULL) {
        $this->id = $id;
        $this->userID = $userID;
        $this->title = $title;
        $this->body = $body;
        $this->timestamp = $timestamp;
        $this->services = $services;
        $this->username = $username;
    }

    function save() {
        $SQL  = "INSERT INTO posts VALUES (NULL, '{$this->userID}', 1, '{$this->title}', '{$this->body}', NULL);";
        DB::try_query($SQL);
        $postID = mysql_insert_id();

        $idAry = array();
        // to make each post be able to have more than 1 want... (which was the
        // original idea), make the radio buttons checkboxes. Everything
        // should work as is
        if (!is_array($this->services)) {
            $this->services = array($this->services);
        }

        foreach($this->services as $serviceName) {
            $servicesSQL = "SELECT id FROM services WHERE name='{$serviceName}';";
            $res = mysql_query($servicesSQL);
            if (!$res) {
                die("Invalid query: ({$servicesSQL}) " . mysql_error());
            }
            while ($row = mysql_fetch_assoc($res)) {
                $idAry[] = $row['id'];
            }
        }

        foreach($idAry as $serviceID) {
            $postDetailsSQL = "INSERT INTO post_details VALUES (NULL, '{$postID}', '{$serviceID}');";
            $res = mysql_query($postDetailsSQL);
            if (!$res) {
                die("Invalid query: ({$postDetailsSQL}) " . mysql_error());
            }
        }
        return true;
    }

    function update() {

    }

    function destroy() {

    }


}

?>

