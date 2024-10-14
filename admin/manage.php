<?php
// admin/manage.php

include_once '../classes/Database.php';
include_once '../classes/Admin.php';
include_once '../classes/Session.php';

Session::init();

// Check if user is logged in and is admin
if(!Session::get('is_admin')) {
    header("Location: ../public/login.php");
    exit();
}

// Initialize Database and Admin
$database = new Database();
$db = $database->getConnection();
$admin = new Admin($db);

// Handle reset votes
$reset_success = false;
$reset_error = "";

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reset_votes'])) {
    if($admin->resetVotes()) {
        $reset_success = true;
    } else {
        $reset_error = "Het resetten van stemmen is mislukt.";
    }
}

// Fetch vote results
$results = $admin->viewResults();
?>

<?php include_once '../templates/header.php'; ?>

<div class="container">
    <h2>Beheer Verkiezingen</h2>

    <?php if($reset_success): ?>
        <p class="success">Alle stemmen zijn succesvol gereset!</p>
    <?php endif; ?>

    <?php if($reset_error): ?>
        <p class="error"><?php echo $reset_error; ?></p>
    <?php endif; ?>

    <h3>Verkiezingsresultaten</h3>
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

    <form method="POST" onsubmit="return confirm('Weet je zeker dat je alle stemmen wilt resetten?');">
        <button type="submit" name="reset_votes">Reset Stemmen</button>
    </form>
</div>

<?php include_once '../templates/footer.php'; ?>
