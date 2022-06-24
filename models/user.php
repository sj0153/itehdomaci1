<?php

class User {
    public $id;
    public $username;
    public $password;
    public $name;

    public function __construct($id, $username, $password, $name)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;
    }

    public static function logIn($password,$uname, mysqli $conn)
    {
        $q ="select * from users where username='".$uname."' and password='".$password."' limit 1";
        return $conn->query($q);
    }


}