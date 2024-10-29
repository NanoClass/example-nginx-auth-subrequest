<?php
session_start();

$sessionLifetime = getenv('SESSION_LIFETIME'); 
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $sessionLifetime) {
    session_unset();
    session_destroy();
}
$_SESSION['LAST_ACTIVITY'] = time();

?>

<!DOCTYPE html>
<html>
    <head>
        <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full height of the viewport */
            margin: 0; /* Remove default margin */
            background-color: #f9f9f9; /* Optional: light background color */
        }

        .centered-container {
            text-align: center; /* Center text within the container */
            border: 1px solid #ccc; /* Border for visibility */
            padding: 20px; /* Padding for the container */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Shadow for depth */
            background-color: white; /* White background for the form */
        }

        form {
            display: flex;
            flex-direction: column; /* Stack elements vertically */
            gap: 10px; /* Space between form elements */
        }

        label {
            font-weight: bold; /* Make labels bold */
        }

        input[type="text"],
        input[type="password"] {
            padding: 10px; /* Padding inside input fields */
            border: 1px solid #ccc; /* Border for input fields */
            border-radius: 4px; /* Rounded corners for inputs */
            font-size: 16px; /* Font size for inputs */
        }

        button {
            padding: 10px; /* Padding for buttons */
            border: none; /* Remove default border */
            border-radius: 4px; /* Rounded corners for buttons */
            background-color: #007bff; /* Bootstrap primary color */
            color: white; /* Text color for buttons */
            font-size: 16px; /* Font size for buttons */
            cursor: pointer; /* Pointer cursor on hover */
            transition: background-color 0.3s; /* Transition effect */
        }

        button:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }
        </style>
    </head>
<body>
<?php
if (isset($_SESSION['IS_LOGIN']) && $_SESSION['IS_LOGIN'] === 1) {
    ?>

    <div class="centered-container">
        <h1>Welcome, <?php echo($_SESSION['username']); ?></h1>    
        <form method="GET" action="logout.php">
            <button type="submit">Logout</button>
        </form>
    </div>

<?php
} else {
    ?>

    <div class="centered-container">
        <h1> Please Login </h1>
<?php
        if (isset($_SESSION['error'])) {
            echo "<p style='color:red;'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
?>
        <form method="POST" action="login.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <button type="submit">Login</button>
        </form>
    </div>

<?php
}
?>

</body>
</html>