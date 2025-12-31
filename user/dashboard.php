<?php
require_once '../includes/config.php';

if (!isLoggedIn()) {
    redirect('../login.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Utilisateur</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .welcome-box {
            text-align: center;
            padding: 50px;
            background: #f9f9f9;
            border-radius: 10px;
            margin-top: 50px;
        }
        .welcome-box h2 {
            color: #333;
            font-size: 2.5em;
        }
        .welcome-box p {
            color: #666;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Dashboard Utilisateur</h2>
            <a href="../logout.php" class="logout">Déconnexion</a>
        </div>
        
        <div class="welcome-box">
            <h2>Bonjour <?php echo $_SESSION['username']; ?> !</h2>
            <p>Bienvenue sur votre espace personnel.</p>
            <p>Vous êtes connecté en tant qu'utilisateur standard.</p>
        </div>
    </div>
</body>
</html>