<?php
// classes/Vote.php

class Vote {
    private $conn;
    private $table_name = "votes";

    public $id;
    public $user_id;
    public $party_id;
    public $vote_time;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Check if the user has already voted
    public function hasVoted() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Cast a vote
    public function vote() {
        if(!$this->hasVoted()) {
            $query = "INSERT INTO " . $this->table_name . " (user_id, party_id) VALUES (:user_id, :party_id)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":party_id", $this->party_id);
            if($stmt->execute()) {
                return true;
            }
        }
        return false;
    }

    // Get vote counts per party
    public function getVotes() {
        $query = "SELECT parties.name, COUNT(votes.id) AS vote_count 
                  FROM " . $this->table_name . " 
                  JOIN parties ON votes.party_id = parties.id 
                  GROUP BY votes.party_id 
                  ORDER BY vote_count DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Reset all votes (Admin functionality)
    public function resetVotes() {
        $query = "DELETE FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }
}
?>
