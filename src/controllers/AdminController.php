<?php
include_once '../models/User.php';

class AdminController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createUser($userData) {
        $user = new User($this->conn);
        $user->username = $userData['username'];
        $user->password = $userData['password'];
        $user->role = $userData['role'];
        $user->name = $userData['name'];
        $user->email = $userData['email'];
        $user->phone = $userData['phone'];

        if ($user->create()) {
            return array("message" => "User was created.");
        } else {
            return array("message" => "Unable to create user.");
        }
    }

    public function readUsers() {
        $user = new User($this->conn);
        $stmt = $user->read();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    public function updateUser($userData) {
        $user = new User($this->conn);
        $user->user_id = $userData['user_id'];
        $user->username = $userData['username'];
        $user->password = $userData['password'];
        $user->role = $userData['role'];
        $user->name = $userData['name'];
        $user->email = $userData['email'];
        $user->phone = $userData['phone'];

        if ($user->update()) {
            return array("message" => "User was updated.");
        } else {
            return array("message" => "Unable to update user.");
        }
    }

    public function deleteUser($user_id) {
        $user = new User($this->conn);
        $user->user_id = $user_id;

        if ($user->delete()) {
            return array("message" => "User was deleted.");
        } else {
            return array("message" => "Unable to delete user.");
        }
    }
}
?>
