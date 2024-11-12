<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Retrieve username
$username = $_SESSION['username'];

// Load user responses from responses.json
$dataFilePath = __DIR__ . '/data/responses.json';
$questionsFilePath = __DIR__ . '/data/questions.json';

if (!file_exists($dataFilePath) || !file_exists($questionsFilePath)) {
    die("Data files not found.");
}

$data = json_decode(file_get_contents($dataFilePath), true);
$responses = $data[$username] ?? null;

$questions_array = json_decode(file_get_contents($questionsFilePath), true);
$questions = $questions_array['questions'] ?? [];

// Check if user responses exist
if ($responses) {
    $xAxis = array_sum(array_slice($responses, 0, 5)) / 5;
    $yAxis = array_sum(array_slice($responses, 5, 5)) / 5;

    // Initialize strain scores
    $strainScores = array_fill(0, 5, 0);

    // Calculate scores for each strain
    foreach ($questions as $index => $question) {
        $weight = $question['weight'];
        $userChoiceIndex = $responses[$index];

        for ($i = 1; $i <= 5; $i++) {
            $strainWeight = $question["strain_weight" . $i][$userChoiceIndex] ?? 0;
            $strainScores[$i - 1] += $weight * $strainWeight;
        }
    }

    arsort($strainScores);
} else {
    $xAxis = $yAxis = 0;
}
// Define strain names
$strainNames = ["Zkittlez", "Runtz", "GSC", "Chemdawg", "OG Kush"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<br>
<br>
 <br>
 <br>
    <title>User Profile</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Bar graph styling */
        .bar-chart {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            height: 200px;
            margin: 20px 0;
            padding: 10px;
            background: #f0f0f0;
            border-radius: 10px;
        }

        .bar {
            width: 18%;  /* Adjust width based on the number of bars */
            display: flex;
            justify-content: center;
            align-items: flex-end;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }

        .bar span {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            padding-top: 5px;
        }
    </style>
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

    <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>

    <h2>Your Responses</h2>
    <ul>
        <?php
        if ($responses) {
            foreach ($responses as $index => $answer_index) {
                $question = $questions[$index]['question'];
                $answer = $questions[$index]['options'][$answer_index];
                echo "<li><strong>$question</strong>: $answer</li>";
            }
        } else {
            echo "<li>No responses available.</li>";
        }
        ?>
    </ul>

    <h2>Recommended Strains</h2>

    <div class="bar-chart">
        <?php
        $minScore = min($strainScores);
        $maxScore = max($strainScores);

        foreach ($strainScores as $index => $score) {
            // Normalize score to a range of 0 to 100
            $normalizedScore = ($score - $minScore) / ($maxScore - $minScore) * 100;
            
            // Calculate color gradient from green to red
            $red = (int)(255 - ($normalizedScore * 2.55));  // Less score = more red
            $green = (int)($normalizedScore * 2.55);        // More score = more green
            $color = "rgb($red, $green, 0)";
            
            // Display each bar with the strain name
            echo "<div class='bar' style='height: {$normalizedScore}%; background-color: $color;'>
                    <span>{$strainNames[$index]}</span>
                  </div>";
        }
        ?>
    </div>

    <h2>Strain Scores</h2>
    <?php if ($responses): ?>
        <ul>
            <?php
            foreach ($strainScores as $index => $score) {
                // Format and display the strain name and its score
               echo "<li>{$strainNames[$index]}: Score - " . number_format($score, 2) . "</li>";
            }
           ?>
        </ul>
    <?php else: ?>
        <p>No recommendations available.</p>
    <?php endif; ?>

    <script>
        const xAxis = <?php echo ($xAxis / 5) * 100; ?>;
        const yAxis = <?php echo ($yAxis / 5) * 100; ?>;

        function plotUserDot() {
            const dot = document.getElementById("userDot");
            const chart = document.querySelector(".chart");

            const xPos = (xAxis / 100) * chart.clientWidth;
            const yPos = chart.clientHeight - (yAxis / 100) * chart.clientHeight;

            dot.style.left = `${xPos}px`;
            dot.style.top = `${yPos}px`;
        }

        plotUserDot();
    </script>
</body>
</html>