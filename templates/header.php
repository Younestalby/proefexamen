<?php
// templates/header.php
include_once '../classes/Session.php';
Session::init();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verkiezing Systeem</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="results.php">Resultaten</a></li>
                <?php if(Session::get('user_id')): ?>
                    <li><a href="logout.php">Uitloggen</a></li>
                    <?php if(Session::get('is_admin')): ?>
                        <li><a href="../admin/manage.php">Beheer</a></li>
                    <?php endif; ?>
                <?php else: ?>
                    <li><a href="login.php">Inloggen</a></li>
                    <li><a href="register.php">Registreren</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
