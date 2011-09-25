<?php

class UserRetriever {

    // User($id, $name, $country, $city, $email, $bio, array $offers, $password=NULL, $dateJoined=NULL) {
    public static function build($username) {
        $selectUserSQL = "SELECT * FROM users WHERE username = '{$username}'";
        $result = mysql_query($selectUserSQL);
        if (!$result) {
            die("Invalid query: ({$selectUserSQL})" . mysql_error());
        }
        while ($row = mysql_fetch_assoc($result)) {
            $id         = $row['id'];
            $username   = $row['username'];
            $country    = $row['country'];
            $city       = $row['city'];
            $email      = $row['email'];
            $bio        = $row['bio'];
            $pass       = $row['encrypted_password'];
            $dateJoined = $row['date_joined'];
            // User takes: ($name, $email, $country, $city,
            // array $offers, $password=NULL,
            // $id=NULL, $dateJoined=NULL)
            return new User($id, $username, $country, $city, $email, $bio,  array(), $pass, $dateJoined);
        }
    }
}

class UserAggregator {
    public static $userList = array();

    // options["all"] = true **ALL**
    //
    // options["byID"] => [1,2,3] **SELECTIVE BY ID** (array in array)
    //
    // options["byUsername"] => ["luke", "shabbir"] **SELECTIVE BY USERNAME**
    // (array in array)
    public static function find(array $options) {
        $SQL = "";
        if (!empty($options["all"])) {
            $SQL = "SELECT * FROM users ORDER BY id DESC";
        } else if (!empty($options["byID"])) {
            $ids = $options["byID"];
            $SQL .= "SELECT * FROM users WHERE ";
            foreach($ids as $id) {
                $SQL .= "id = $id OR ";
            }
            $SQL  = substr($SQL, 0, -4);
            $SQL .= " ORDER BY id DESC";

        }
        $result = mysql_query($SQL);
        if (!$result) {
            die("Invalid query: ({$SQL}) " . mysql_error());
        }
        while ($row = mysql_fetch_assoc($result)) {
            $id         = $row['id'];
            $username   = $row['username'];
            $country    = $row['country'];
            $city       = $row['city'];
            $email      = $row['email'];
            $bio        = $row['bio'];
            $dateJoined = $row['date_joined'];
            // User takes: ($name, $email, $country, $city,
            // array $offers, $password=NULL,
            // $id=NULL, $dateJoined=NULL)
            $user = new User($id, $username, $country, $city, $email, $bio, array(), NULL, $dateJoined);
            User::retrieveOffers($user);
            self::$userList[] = $user;
        }
        return self::$userList;
    }

}

class User extends TableObject {
    // save the user to the database
    //
    // User($id, $name, $country, $city, $email, $bio, array $offers, $password=NULL, $dateJoined=NULL) {
    //
    public function save() {
        $date = date('Y-m-d H:i:s');
        $hashed_pass = sha1($this->pass);

        $saveUserSQL = "INSERT INTO users VALUES (NULL, '{$this->name}', " .
            "'{$this->country}', '{$this->city}', '{$this->email}', '{$this->bio}'" .
            ", '$hashed_pass', '$date');";

        $result = mysql_query($saveUserSQL);
        if (!$result) {
            die("Invalid query: ({$saveUserSQL}) " . mysql_error());
        }
        $userID = mysql_insert_id();
        $this->id = $userID;

        foreach ($this->offers as $offer) {
            $id = self::getOfferIDByName($offer);

            $saveUserOffersSQL = "INSERT INTO user_services VALUES (NULL, " .
            "'{$this->id}', $id, 1); ";
            // should use mysqli_multi_query or joins
            $result = mysql_query($saveUserOffersSQL);
            if (!$result) {
                die("Invalid query: ({$saveUserOffersSQL}) " . mysql_error());
            }
        }
        return true;
    }


    public function update($update_offers=false) {
        if (empty($this->id)) {
            throw new Exception("User::update (static) must take an already " .
                "constructed user (user with an id)");
        }

        $updateUserSQL = "UPDATE users SET ";
        $updateUserSQL .= "username='{$this->name}', country='{$this->country}'" .
            ", city='{$this->city}', email='{$this->email}', bio='{$this->bio}', encrypted_password=".
            "'{$this->pass}' WHERE id = {$this->id};";
        $result = mysql_query($updateUserSQL);
        if (!$result) {
            die("Invalid query: ({$updateUserSQL})\n" . mysql_error());
        }

        if ($update_offers) {
            //first, delete the current offers with this user_id
            $deleteOffersSQL = "DELETE FROM user_services WHERE user_id = $this->id AND offer = 1;";
            $result = mysql_query($deleteOffersSQL);
            if (!$result) {
                die("Invalid query: ({$deleteOffersSQL})\n" . mysql_error());
            }

            foreach($this->offers as $offer) {
                $offerID = User::getOfferIDByName($offer);
                print_r($offerID);
                $updateOffersSQL = "INSERT INTO user_services VALUES (";
                $updateOffersSQL .= "NULL, $this->id, '$offerID', 1);";
                $result = mysql_query($updateOffersSQL);
                if (!$result) {
                    die("Invalid query: ({$updateOffersSQL})\n" . mysql_error());
                }
            }

        }
        return true;
    }

    public function destroy() {
    }

    private static function getOfferIDByName($offer) {
        $SQL = "SELECT id FROM services WHERE name='{$offer}'";
        $id = mysql_query($SQL);
        if (!$id) {
            die("Invalid query: ({$SQL})\n" . mysql_error());
        }
        while ($row = mysql_fetch_assoc($id)) {
            $offerID = $row['id'];
        }
        return $offerID;
    }


    public static function retrieveOffers(User $user) {
        // do a select to get all offers for the specified user
        $selectOffersSQL = "SELECT services.name FROM services INNER JOIN (users INNER JOIN user_services ON users.id = user_services.user_id) WHERE " .
            "user_services.user_id = {$user->id} AND user_services.service_id = services.id;";
        $offers = mysql_query($selectOffersSQL);
        if (!$offers) {
            die("Invalid query ({$selectOffersSQL}):\n" . mysql_error());
        }

        $offersList = array();
        while ($row = mysql_fetch_assoc($offers)) {
            $offersList[] = $row['name'];
        }

        $user->offers = $offersList;
        return true;
    }


    public $id;
    public $name;
    public $country;
    public $city;
    public $email;
    public $bio;
    public $offers; //array
    public $pass;
    public $dateJoined;

    function __construct($id, $name, $country, $city, $email, $bio, array $offers, $password=NULL, $dateJoined=NULL) {
        $this->id      = $id;
        $this->name    = $name;
        $this->country = $country;
        $this->city    = $city;
        $this->email   = $email;
        $this->bio     = $bio;
        $this->offers  = $offers; // array
        $this->pass    = $password;
        $this->dateJoined = $dateJoined;
    }



}

