<?php
require_once 'config.php';

class Auth {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Inscription
    public function register($username, $email, $password, $role = 'user') {
        // Vérifier si l'utilisateur existe déjà
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        
        if ($stmt->rowCount() > 0) {
            return "Nom d'utilisateur ou email déjà utilisé";
        }
        
        // Hasher le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Insérer l'utilisateur
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        
        if ($stmt->execute([$username, $email, $hashedPassword, $role])) {
            return true;
        }
        
        return "Erreur lors de l'inscription";
    }
    
    // Connexion
    public function login($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            if (!$user['is_active']) {
                return "Compte désactivé";
            }
            
            // Stocker les informations de session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['email'] = $user['email'];
            
            return true;
        }
        
        return "Identifiants incorrects";
    }
    
    // Récupérer tous les utilisateurs (pour admin)
    public function getAllUsers() {
        $stmt = $this->pdo->query("SELECT id, username, email, role, is_active, created_at FROM users");
        return $stmt->fetchAll();
    }
    
    // Modifier un utilisateur
    public function updateUser($id, $is_active) {
        $stmt = $this->pdo->prepare("UPDATE users SET is_active = ? WHERE id = ?");
        return $stmt->execute([$is_active, $id]);
    }
    
    // Supprimer un utilisateur
    public function deleteUser($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ? AND role != 'admin'");
        return $stmt->execute([$id]);
    }
}

$auth = new Auth($pdo);
?>