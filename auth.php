<?php
require_once 'config.php';

class Auth {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($email, $password) {
        $query = "SELECT id, username, email, password, role, full_name FROM " . $this->table_name . " WHERE email = :email AND status = 'active'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // For demo purposes, using simple password check
            // In production, use password_verify()
            if ($password === 'admin123' && $email === 'admin@rps.edu' ||
                $password === 'teacher123' && $email === 'teacher@rps.edu' ||
                $password === 'student123' && $email === 'student@rps.edu') {
                
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['full_name'] = $row['full_name'];
                
                return array(
                    "status" => "success",
                    "message" => "Login successful",
                    "user" => $row
                );
            }
        }
        
        return array(
            "status" => "error",
            "message" => "Invalid credentials"
        );
    }

    public function logout() {
        session_destroy();
        return array("status" => "success", "message" => "Logged out successfully");
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function getUserRole() {
        return $_SESSION['role'] ?? null;
    }
}

// Handle login request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'login') {
    $database = new Database();
    $db = $database->getConnection();
    $auth = new Auth($db);
    
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $result = $auth->login($email, $password);
    echo json_encode($result);
    exit;
}

// Handle logout request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'logout') {
    $database = new Database();
    $db = $database->getConnection();
    $auth = new Auth($db);
    
    $result = $auth->logout();
    echo json_encode($result);
    exit;
}
?>