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

        if ($user && password_verify($password, $user['password'])) {
            return $user;
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

    public function updateUsername($userId, $newName) {
        $stmt = $this->pdo->prepare("UPDATE users SET name = ? WHERE id = ?");
        return $stmt->execute([$newName, $userId]);
    }

    public function updateProfilePhoto($userId, $photoPath) {
        $stmt = $this->pdo->prepare("SELECT profile_photo FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user['profile_photo'] && file_exists(__DIR__ . '/../' . $user['profile_photo'])) {
            unlink(__DIR__ . '/../' . $user['profile_photo']);
        }

        $stmt = $this->pdo->prepare("UPDATE users SET profile_photo = ? WHERE id = ?");
        return $stmt->execute([$photoPath, $userId]);
    }

    public function uploadPhoto($file) {
        $targetDir = __DIR__ . "/../images/profile_photos/";
        $fileName = basename($file["name"]);
        $targetFilePath = $targetDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        $validExtensions = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $validExtensions)) {
            return "Невірний формат файлу. Дозволені формати: jpg, jpeg, png, gif.";
        }

        if ($file["size"] > 5 * 1024 * 1024) {
            return "Файл занадто великий. Максимальний розмір: 5MB.";
        }

        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            return $fileName;
        } else {
            return "Помилка завантаження файлу.";
        }
    }

    public function changePassword($userId, $currentPassword, $newPassword) {
        $stmt = $this->pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($currentPassword, $user['password'])) {
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateStmt = $this->pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $updateStmt->execute([$hashedNewPassword, $userId]);
            return "Пароль успішно змінено.";
        }
        return "Неправильний поточний пароль.";
    }
    
    public function logout() {
        session_start(); 
        session_unset();  
        session_destroy();  
        header('Location: index.php'); 
        exit;
    }
}
