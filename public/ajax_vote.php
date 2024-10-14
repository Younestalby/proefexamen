<?php
// public/ajax_vote.php

include_once '../classes/Database.php';
include_once '../classes/Vote.php';
include_once '../classes/Session.php';

Session::init();

// Set header for JSON response
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if user is logged in
    if(!Session::get('user_id')) {
        echo json_encode(["error" => "Niet ingelogd"]);
        exit();
    }

    // Sanitize input
    $party_id = intval($_POST['party_id']);

    // Initialize Database and Vote
    $database = new Database();
    $db = $database->getConnection();
    $vote = new Vote($db);
    $vote->user_id = Session::get('user_id');
    $vote->party_id = $party_id;

    if($vote->vote()) {
        echo json_encode(["success" => "Je stem is succesvol uitgebracht!"]);
    } else {
        echo json_encode(["error" => "Je hebt al gestemd."]);
    }
} else {
    echo json_encode(["error" => "Ongeldig verzoek"]);
}
?>
