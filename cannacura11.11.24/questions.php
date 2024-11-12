<?php
// questions.php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Load questions from questions.json
$questions_data = file_get_contents(__DIR__ . '/data/questions.json');
$questions_array = json_decode($questions_data, true);
$questions = $questions_array['questions'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $responses = [];

    foreach ($questions as $index => $question) {
        $question_key = "question_" . $index;
        if (isset($_POST[$question_key])) {
            $responses[$index] = (int) $_POST[$question_key];
        }
    }

    save_responses($_SESSION['username'], $responses);
    echo "Responses recorded. <a href='profile.php'>View your profile</a>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questions</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </nav>

    <div class="container">
        <form method="POST">
            <h1>Questionnaire</h1>
            <p>Please answer all questions below</p>

            <?php foreach ($questions as $index => $question): ?>
                <div class="question-block">
                    <h2><?php echo htmlspecialchars($question['question']); ?></h2>
                    
                    <?php foreach ($question['options'] as $option_index => $option): ?>
                        <div class="radio-option">
                            <input 
                                type="radio" 
                                id="question_<?php echo $index; ?>_option_<?php echo $option_index; ?>" 
                                name="question_<?php echo $index; ?>" 
                                value="<?php echo $option_index; ?>" 
                                required
                            >
                            <label for="question_<?php echo $index; ?>_option_<?php echo $option_index; ?>">
                                <?php echo htmlspecialchars($option); ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

            <button type="submit">Submit Answers</button>
        </form>
    </div>
</body>
</html>