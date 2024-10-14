<?php
// classes/Database.php

class Database {
    private $host = "localhost";
    private $db_name = "verkiezing_db";
    private $username = "root"; // Change if different
    private $password = "";     // Change if different
    private $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            // Use PDO for secure database interactions
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4", 
                                  $this->username, 
                                  $this->password);
            // Set PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            // Handle connection error
            echo "Connection error: " . $exception->getMessage();
            exit();
        }
        return $this->conn;
    }
}
?>
