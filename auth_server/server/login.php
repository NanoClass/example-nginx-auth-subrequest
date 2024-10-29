<?php
session_start();

$sessionLifetime = getenv('SESSION_LIFETIME'); 
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $sessionLifetime) {
    session_unset();
    session_destroy();
}
$_SESSION['LAST_ACTIVITY'] = time();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Username and password cannot be empty.";
        header("Location: /");
        exit();
    }

    $dbFile = getenv('DB_PATH');

    try {
        $pdo = new PDO("sqlite:$dbFile");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT password, is_admin FROM user WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['is_admin'] = $user['is_admin'];
            $_SESSION['IS_LOGIN'] = 1;
            header("Location: /");
            exit();
        } else {
            $_SESSION['error'] = "Invalid username or password.";
            header("Location: /");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        header("Location: /");
        exit();
    }
} else {
    header("Location: /");
    exit();
}
?>
