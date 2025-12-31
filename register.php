<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

if (isLoggedIn()) {
    redirect('index.php');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];
    
    // Validation
    if (empty($username) || empty($email) || empty($password)) {
        $error = "Tous les champs sont obligatoires";
    } elseif ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas";
    } elseif (strlen($password) < 6) {
        $error = "Le mot de passe doit contenir au moins 6 caractères";
    } else {
        $result = $auth->register($username, $email, $password, $role);
        
        if ($result === true) {
            $success = "Inscription réussie ! Vous pouvez vous connecter.";
        } else {
            $error = $result;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Inscription</h2>
        
        <?php if ($error): ?>
            <div class="alert error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Nom d'utilisateur:</label>
                <input type="text" name="username" required>
            </div>
            
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label>Mot de passe:</label>
                <input type="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label>Confirmer le mot de passe:</label>
                <input type="password" name="confirm_password" required>
            </div>
            
            <div class="form-group">
                <label>Rôle:</label>
                <select name="role">
                    <option value="user">Utilisateur</option>
                    <option value="admin">Administrateur</option>
                </select>
            </div>
            
            <button type="submit">S'inscrire</button>
        </form>
        
        <p>Déjà inscrit ? <a href="login.php">Connectez-vous ici</a></p>
    </div>
</body>
</html>