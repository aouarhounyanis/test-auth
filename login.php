<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

if (isLoggedIn()) {
    // Rediriger selon le rôle
    if ($_SESSION['role'] === 'admin') {
        redirect('admin/dashboard.php');
    } else {
        redirect('user/dashboard.php');
    }
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    $result = $auth->login($username, $password);
    
    if ($result === true) {
        // Redirection selon le rôle
        if ($_SESSION['role'] === 'admin') {
            redirect('admin/dashboard.php');
        } else {
            redirect('user/dashboard.php');
        }
    } else {
        $error = $result;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Connexion</h2>
        
        <?php if ($error): ?>
            <div class="alert error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Nom d'utilisateur ou Email:</label>
                <input type="text" name="username" required>
            </div>
            
            <div class="form-group">
                <label>Mot de passe:</label>
                <input type="password" name="password" required>
            </div>
            
            <button type="submit">Se connecter</button>
        </form>
        
        <p>Pas encore de compte ? <a href="register.php">Inscrivez-vous ici</a></p>
    </div>
</body>
</html>