<?php
// login.php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (validate_user($username, $password)) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
}

// Display success message if redirected after registration
$success_message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CannaCura</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="register.php">Register</a>
    </nav>

    <div class="container">
        <h1>Welcome Back</h1>
        
        <?php if (isset($error_message)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="question-block">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="question-block">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit">Login</button>
        </form>

        <p class="register-link">
            Don't have an account? 
            <a href="register.php">Register here</a>
        </p>
    </div>
</body>
<?php if (!empty($success_message)): ?>
    <div class="success-message">
        <?php echo htmlspecialchars($success_message); ?>
    </div>
<?php endif; ?>

</html>