<?php
// Database file
$dbFile = getenv('DB_PATH');
if (empty($dbFile)) {
    echo "DB_PATH is empty\n";
    exit; 
}

// Create a new SQLite database connection
try {
    $pdo = new PDO("sqlite:$dbFile");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the 'user' table exists
    $tableCheck = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='user'")->fetch();

    // Create the table if it doesn't exist
    if (!$tableCheck) {
        $createTableSql = "CREATE TABLE IF NOT EXISTS user (
            username TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL,
            is_admin BOOLEAN NOT NULL DEFAULT 0
        );";
        $pdo->exec($createTableSql);
        echo "Table 'user' created successfully.\n";
    } else {
        echo "Table 'user' already exists.\n";
    }

    // Get username and password from command-line arguments
    if ($argc < 3) {
        echo "Usage: php script.php <username> <password>\n";
        exit; // Stop the script if arguments are not provided
    }

    $username = $argv[1]; // First argument is the username
    $password = $argv[2]; // Second argument is the password
    $isAdmin = 1;

    // Check if username and password are empty
    if (empty($username) || empty($password)) {
        echo "Username and password cannot be empty.\n";
        exit;
    }

    // Hash the password using bcrypt
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Prepare and execute the insert statement
    $stmt = $pdo->prepare("INSERT INTO user (username, password, is_admin) VALUES (:username, :password, :is_admin)");

    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':is_admin', $isAdmin);

    // Execute the statement
    if ($stmt->execute()) {
        echo "User '$username' created successfully.\n";
    } else {
        echo "Error creating user.\n";
    }
} catch (PDOException $e) {
    // Handle specific errors, particularly for unique constraint violations
    if ($e->getCode() === '23000') { // Unique constraint violation
        echo "Error: Username '$username' already exists. Please choose a different username.\n";
    } else {
        echo "Database error: " . $e->getMessage() . "\n";
    }
}
?>
