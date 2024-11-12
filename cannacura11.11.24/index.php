<?php
// index.php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CannaCura</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
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

    <!-- Main Content Container -->
    <div class="container">
        <h1>Welcome to Cannacura!</h1>
        
        <?php if (isset($_SESSION['username'])): ?>
            <p>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
            <p>Ready to start your wellness journey?</p>
            <br>
            <div class="button-group">
                <button onclick="window.location.href='questions.php'">Start Questionnaire</button>
                <button onclick="window.location.href='profile.php'">View Your Profile</button>
            </div>
        <?php else: ?>
            <p>Your personalized wellness journey begins here.</p>
            <div class="button-group">
                <button onclick="window.location.href='register.php'">Create Account</button>
                <button onclick="window.location.href='login.php'">Sign In</button>
            </div>
        <?php endif; ?>
        <br>
        <br>

        <!-- Video Section -->
        <div class="video-container">
            <video width="100%" controls>
                <source src="video/cannacura_video.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>
</body>
</html>