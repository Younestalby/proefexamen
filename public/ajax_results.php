<?php
// public/ajax_results.php

include_once '../classes/Database.php';
include_once '../classes/Vote.php';
include_once '../classes/Session.php';

Session::init();

// Set header for JSON response
header('Content-Type: application/json');

// Initialize Database and Vote
$database = new Database();
$db = $database->getConnection();
$vote = new Vote($db);

// Fetch vote results
$results = $vote->getVotes();
$data = [];

while($row = $results->fetch(PDO::FETCH_ASSOC)) {
    $data[] = [
        'name' => htmlspecialchars($row['name']),
        'vote_count' => htmlspecialchars($row['vote_count'])
    ];
}

echo json_encode($data);
?>
