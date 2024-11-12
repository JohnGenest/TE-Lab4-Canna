<?php
// db.php

// Define JSON file paths in the `data` folder
define('USERS_FILE', __DIR__ . '/data/users.json');
define('RESPONSES_FILE', __DIR__ . '/data/responses.json');

// Functions to read/write to JSON files
function read_json_file($file_path) {
    if (!file_exists($file_path)) {
        file_put_contents($file_path, json_encode([])); // Create file if not exists
    }
    return json_decode(file_get_contents($file_path), true);
}

function write_json_file($file_path, $data) {
    file_put_contents($file_path, json_encode($data, JSON_PRETTY_PRINT));
}

// Register a new user
function register_user($username, $password) {
    $users = read_json_file(USERS_FILE);
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            return false; // User already exists
        }
    }
    $users[] = [
        'username' => $username,
        'password' => password_hash($password, PASSWORD_DEFAULT)
    ];
    write_json_file(USERS_FILE, $users);
    return true;
}

// Validate user login
function validate_user($username, $password) {
    $users = read_json_file(USERS_FILE);
    foreach ($users as $user) {
        if ($user['username'] === $username && password_verify($password, $user['password'])) {
            return true;
        }
    }
    return false;
}

// Save user responses
function save_responses($username, $responses) {
    $all_responses = read_json_file(RESPONSES_FILE);
    $all_responses[$username] = $responses;
    write_json_file(RESPONSES_FILE, $all_responses);
}

// Retrieve user responses
function get_user_responses($username) {
    $all_responses = read_json_file(RESPONSES_FILE);
    return isset($all_responses[$username]) ? $all_responses[$username] : [];
}
?>
