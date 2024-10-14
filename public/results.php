<?php
// public/results.php

include_once '../classes/Database.php';
include_once '../classes/Vote.php';
include_once '../classes/Session.php';

Session::init();

// Initialize Database and Vote
$database = new Database();
$db = $database->getConnection();
$vote = new Vote($db);

// Fetch vote results
$results = $vote->getVotes();
?>

<?php include_once '../templates/header.php'; ?>

<div class="container">
    <h2>Verkiezingsresultaten</h2>
    <table>
        <thead>
            <tr>
                <th>Partij</th>
                <th>Aantal Stemmen</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $results->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['vote_count']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include_once '../templates/footer.php'; ?>
