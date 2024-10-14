<?php
// public/login.php

include_once '../classes/Database.php';
include_once '../classes/User.php';
include_once '../classes/Session.php';

Session::init();

// Initialize Database and User
$database = new Database();
$db = $database->getConnection();
$user = new User($db);

// Handle form submission
$login_success = false;
$login_error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input
    $user->email = htmlspecialchars(strip_tags($_POST['email']));
    $user->password = $_POST['password']; // Password verification handled in class

    if($user->login()) {
        // Set session variables
        Session::set('user_id', $user->id);
        Session::set('user_name', $user->naam);
        Session::set('is_admin', $user->isAdmin());
        header("Location: index.php");
        exit();
    } else {
        $login_error = "Inloggen mislukt. Controleer je e-mail en wachtwoord.";
    }
}
?>

<?php include_once '../templates/header.php'; ?>

<div class="container">
    <h2>Inloggen</h2>

    <?php if($login_error): ?>
        <p class="error"><?php echo $login_error; ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <label for="email">E-mail:</label>
        <input type="email" name="email" required>

        <label for="password">Wachtwoord:</label>
        <input type="password" name="password" required>

        <button type="submit">Inloggen</button>
    </form>
</div>

<?php include_once '../templates/footer.php'; ?>
