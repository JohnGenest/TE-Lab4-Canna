<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CannaCura</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <?php if (isset($_SESSION['username'])): ?>
            <a href="profile.php">Profile</a>
            <a href="questions.php">Questions</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </nav>
    <?php
// register.php
session_start();
include_once 'db.php'; // Use include_once to avoid redeclaration errors

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (register_user($username, $password)) {
        header("Location: login.php?message=" . urlencode("Registration successful. Please log in."));
        exit();
    } else {
        $error_message = "Registration failed: Username already exists.";
    }
}
?>
<div class="container">
<form method="POST">
    <h1>Register</h1>
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

            <button type="submit">Register</button>
        </form>

<div>


