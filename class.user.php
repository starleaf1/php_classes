<?php

/*
This class is for implementing a simple user account system in your application.
It is built with only MySQL in mind.
*/

class User{

    public $id, $un, $pw, $rn, $la;
    // The attributes are:
    // - $id: The ID of the user (integer)
    // - $un: The username of the user
    // - $pw: The MD5 hash of the password
    // - $rn: The real name of the user
    // - $la: The timestamp of last access of the user
    // If you're using PDO, the attributes are automatically set when using any of the PDO's fetching methods with FETCH_CLASS

    public function __construct($cand_un = "", $cand_pw = "", $cand_rn = "") {
        // Use the constructor to declare a new User object in your app.
        // The arguments are:
        // $cand_un: The desired username for the user
        // $cand_pw: The MD5 hash of the desired password for the user.
        // $rn: The real name of the user

        global $database;
        if ($cand_un != "") {
            $this->un = $cand_un;
            $this->pw = md5($cand_pw);
            $this->rn = $cand_rn;
        }
    }

    public function erase() {
        // This method is used to delete the user from the database
        global $database;
        $database->query("DELETE FROM users WHERE id = ".$this->id);
    }

    public function register() {
        // This method is used to insert new user into the database.
        // Use it in conjunction with the constructor.
        // It is also used to modify existing users.
        
        global $database;
        $create_new_user = $database->prepare("INSERT INTO users (un, pw, rn) VALUES (:un, :pw, :rn) ON DUPLICATE KEY UPDATE pw=:pw, rn=:rn");
        $new_user_attrib = array(
            "un" => $this->un,
            "pw" => $this->pw,
            "rn" => $this->rn
        );
        $create_new_user->execute($new_user_attrib);
    }
}
?>
