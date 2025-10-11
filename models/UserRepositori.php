<?php

class UserRepository {
    public static function login($username, $password) {
        $db = Connection::connect();
        
        $stmt = $db->prepare('SELECT * FROM user WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['user'] = new User($row['id'], $row['username'], null, $row['role']);
                return true;
            }
        }

        return false;
    }

    public static function register($username, $password, $password2) {
        
        if ($password !== $password2) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        try {
            $db = Connection::connect();

            $sql = "INSERT INTO user (username, password, role) VALUES (?, ?, 'user')";

            $stmt = $db->prepare($sql);
            $result = $stmt->execute([$username, $hashedPassword]);

            return $result;

        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
