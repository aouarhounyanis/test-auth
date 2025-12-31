<?php
require_once 'includes/config.php';

if (isLoggedIn()) {
    // Rediriger selon le rôle
    if ($_SESSION['role'] === 'admin') {
        redirect('admin/dashboard.php');
    } else {
        redirect('user/dashboard.php');
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Système d'Authentification</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>AZUL</h1>
        <p>Choisissez une action :</p>
        <div class="actions">
            <a href="login.php" class="btn">Se connecter</a>
            <a href="register.php" class="btn">S'inscrire</a>
        </div>
    </div>
</body>
</html>