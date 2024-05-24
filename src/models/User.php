<?php
class User {
    private $conn;
    private $table_name = "users";

    public $user_id;
    public $username;
    public $password;
    public $role;
    public $name;
    public $email;
    public $phone;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET username=:username, password=:password, role=:role, name=:name, email=:email, phone=:phone";
        
        $stmt = $this->conn->prepare($query);

        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->role = htmlspecialchars(strip_tags($this->role));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));

        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", password_hash($this->password, PASSWORD_BCRYPT));
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->user_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->username = $row['username'];
            $this->password = $row['password'];
            $this->role = $row['role'];
            $this->name = $row['name'];
            $this->email = $row['email'];
            $this->phone = $row['phone'];
            return true;
        }

        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET username = :username, password = :password, role = :role, name = :name, email = :email, phone = :phone 
                  WHERE user_id = :user_id";
        
        $stmt = $this->conn->prepare($query);

        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->role = htmlspecialchars(strip_tags($this->role));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', password_hash($this->password, PASSWORD_BCRYPT));
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':user_id', $this->user_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->user_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function usernameExists() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->username);
        $stmt->execute();
        $num = $stmt->rowCount();

        if ($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->user_id = $row['user_id'];
            $this->username = $row['username'];
            $this->password = $row['password'];
            $this->role = $row['role'];
            $this->name = $row['name'];
            $this->email = $row['email'];
            $this->phone = $row['phone'];
            return true;
        }

        return false;
    }
}
?>
