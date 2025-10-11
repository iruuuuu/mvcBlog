<?php
class User {
    private $id;
    private $username;
    private $password;
    private $role;

    public function __construct($id, $username, $password = null, $role = 'user') {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRole() {
        return $this->role;
    }

    public function isAdmin() {
        return $this->role === 'admin';
    }
}
?>
