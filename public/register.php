<?php
// public/register.php

include_once '../classes/Database.php';
include_once '../classes/User.php';
include_once '../classes/Session.php';

Session::init();

// Initialize Database and User
$database = new Database();
$db = $database->getConnection();
$user = new User($db);

// Handle form submission
$registration_success = false;
$registration_error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input
    $user->naam = htmlspecialchars(strip_tags($_POST['name']));
    $user->email = htmlspecialchars(strip_tags($_POST['email']));
    $user->password = $_POST['password']; // Password will be hashed in the class

    if($user->register()) {
        $registration_success = true;
    } else {
        $registration_error = "Registratie mislukt. Probeer het opnieuw.";
    }
}
?>

<?php include_once '../templates/header.php'; ?>

<div class="container">
    <h2>Registreren</h2>

    <?php if($registration_success): ?>
        <p class="success">Registratie succesvol! <a href="login.php">Klik hier om in te loggen.</a></p>
    <?php endif; ?>

    <?php if($registration_error): ?>
        <p class="error"><?php echo $registration_error; ?></p>
    <?php endif; ?>

    <form method="POST" action="register.php">
        <label for="name">Naam:</label>
        <input type="text" name="name" required>

        <label for="email">E-mail:</label>
        <input type="email" name="email" required>

        <label for="password">Wachtwoord:</label>
        <input type="password" name="password" required>

        <button type="submit">Registreren</button>
    </form>
</div>

<?php include_once '../templates/footer.php'; ?>
