<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function login($email, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                return $user; 
            } elseif ($user['password'] === $password) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $updateStmt = $this->pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
                $updateStmt->execute([$hashedPassword, $email]);
                
                $user['password'] = $hashedPassword;
                return $user;
            }
        }
        return false; 
    }

    public function register($name, $email, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return 'Користувач з таким email вже існує.';
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hashedPassword]);

        return 'Реєстрація успішна! Ви можете увійти на сайт.';
    }

    public function logout() {

        session_start();
        session_unset();
        session_destroy();
    }
}
?>
