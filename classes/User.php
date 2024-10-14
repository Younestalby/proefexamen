<?php
// classes/User.php

class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $naam;
    public $email;
    public $password;
    public $role;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Register a new user
    public function register() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (naam, email, password, role) 
                  VALUES (:naam, :email, :password, 'user')";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":naam", $this->naam);
        $stmt->bindParam(":email", $this->email);
        // Hash the password before storing
        $hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(":password", $hashed_password);

        // Execute the query
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // User login
    public function login() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // Verify password
            if(password_verify($this->password, $row['password'])) {
                // Assign properties
                $this->id = $row['id'];
                $this->naam = $row['naam'];
                $this->role = $row['role'];
                return true;
            }
        }
        return false;
    }

    // Check if user is admin
    public function isAdmin() {
        return $this->role === 'admin';
    }
}
?>
