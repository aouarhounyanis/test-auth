<?php
require_once '../includes/config.php';

if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    redirect('../login.php');
}

require_once '../includes/auth.php';

// Traitement des actions
if (isset($_GET['action'])) {
    $id = $_GET['id'] ?? 0;
    
    switch ($_GET['action']) {
        case 'delete':
            $auth->deleteUser($id);
            break;
        case 'activate':
            $auth->updateUser($id, '', '', '', 1);
            break;
        case 'deactivate':
            $auth->updateUser($id, '', '', '', 0);
            break;
    }
    
    redirect('dashboard.php');
}

$users = $auth->getAllUsers();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .actions a {
            margin-right: 10px;
            text-decoration: none;
            padding: 3px 8px;
            border-radius: 3px;
        }
        .edit { background: #4CAF50; color: white; }
        .delete { background: #f44336; color: white; }
        .activate { background: #2196F3; color: white; }
        .deactivate { background: #ff9800; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Dashboard Administrateur</h2>
            <p>Bienvenue, <?php echo $_SESSION['username']; ?>!</p>
            <a href="../logout.php" class="logout">Déconnexion</a>
        </div>
        
        <h3>Gestion des utilisateurs</h3>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom d'utilisateur</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Statut</th>
                    <th>Date d'inscription</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo $user['role']; ?></td>
                    <td><?php echo $user['is_active'] ? 'Actif' : 'Inactif'; ?></td>
                    <td><?php echo $user['created_at']; ?></td>
                    <td class="actions">
                        <?php if ($user['role'] != 'admin'): ?>
                            <a href="?action=delete&id=<?php echo $user['id']; ?>" 
                               class="delete" 
                               onclick="return confirm('Supprimer cet utilisateur ?')">Supprimer</a>
                            
                            <?php if ($user['is_active']): ?>
                                <a href="?action=deactivate&id=<?php echo $user['id']; ?>" 
                                   class="deactivate">Désactiver</a>
                            <?php else: ?>
                                <a href="?action=activate&id=<?php echo $user['id']; ?>" 
                                   class="activate">Activer</a>
                            <?php endif; ?>
                            
                            <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="edit">Modifier</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>