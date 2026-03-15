<?php

// this file acts as a router for user actions (post & delete)
session_start();
require __DIR__ . '/../db.php';
// users must be logged in for ALL act
if (!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$action = $_GET['action'] ?? '';

switch($action) {
    case 'post':
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
        break;
    case 'delete':
        if (isset($_GET['id']) && is_numeric($_GET['id'])){
            $post_id = (int)$_GET['id'];
            $user_id = $_SESSION['user_id'];

            $stmt = $pdo->prepare(
                "DELETE FROM posts WHERE id = ? AND user_id = ?"
            );

            $stmt->execute([$post_id, $user_id]);
        }
        break;
}

header("Location: board.php");
exit();
