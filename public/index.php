<?php
// public/index.php

include_once '../classes/Database.php';
include_once '../classes/Vote.php';
include_once '../classes/Session.php';

Session::init();

// Check if user is logged in
if(!Session::get('user_id')) {
    header("Location: login.php");
    exit();
}

// Initialize Database and Vote
$database = new Database();
$db = $database->getConnection();
$vote = new Vote($db);

// Handle vote submission via POST
$vote_success = false;
$vote_error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input
    $vote->user_id = Session::get('user_id');
    $vote->party_id = intval($_POST['party_id']);

    if($vote->vote()) {
        $vote_success = true;
    } else {
        $vote_error = "Je hebt al gestemd.";
    }
}
?>

<?php include_once '../templates/header.php'; ?>

<div class="container">
    <h2>Stem Nu</h2>

    <?php if($vote_success): ?>
        <p class="success">Je stem is succesvol uitgebracht!</p>
    <?php endif; ?>

    <?php if($vote_error): ?>
        <p class="error"><?php echo $vote_error; ?></p>
    <?php endif; ?>

    <form method="POST" id="vote-form">
        <label for="party_id">Selecteer een partij:</label>
        <select name="party_id" required>
            <option value="" disabled selected>Kies een partij</option>
            <?php
                // Fetch parties from the database
                $stmt = $db->prepare("SELECT id, name FROM parties");
                $stmt->execute();
                $parties = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($parties as $party):
            ?>
                <option value="<?php echo $party['id']; ?>"><?php echo htmlspecialchars($party['name']); ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Stem</button>
    </form>

    <h2>Live Resultaten</h2>
    <div id="results">
        <!-- Live results will be loaded here via AJAX -->
    </div>
</div>

<?php include_once '../templates/footer.php'; ?>
