<?php
class User{

    public $id, $un, $pw, $rn, $la;

    public function __construct($cand_un = "", $cand_pw = "", $cand_rn = "") {
        global $database;
        if ($cand_un != "") {
            $this->un = $cand_un;
            $this->pw = md5($cand_pw);
            $this->rn = $cand_rn;
        }
    }

    public function erase() {
        global $database;
        $database->query("DELETE FROM users WHERE id = ".$this->id);
    }

    public function register() {
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
