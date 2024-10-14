<?php
// classes/Admin.php

class Admin {
    private $conn;
    private $vote;

    public function __construct($db) {
        $this->conn = $db;
        $this->vote = new Vote($db);
    }

    // View all votes (aggregated)
    public function viewResults() {
        return $this->vote->getVotes();
    }

    // Reset all votes
    public function resetVotes() {
        return $this->vote->resetVotes();
    }
}
?>
