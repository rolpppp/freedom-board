<?php

session_start();

// security check (only logged-in users can post)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");      // redirect to login if not logged in
    exit();
}

require 'db.php'; // this loads the database connection which means that $pdo is now available

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty(trim($_POST['content']))) {
    $user_id = $_SESSION['user_id'];
    $content = trim($_POST['content']);

    // this handles the replies. if no parent_id is passed, it will default to NULL
    $parent_id = isset($_POST['parent_id']) && is_numeric($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;

    // prepared statements
    $stmt = $pdo->prepare(
        "INSERT INTO posts (user_id, content, parent_id) VALUES (?, ?, ?)"
    );

    $stmt->execute([$user_id, $content, $parent_id]);
}

header("Location: board.php");
exit();
?>