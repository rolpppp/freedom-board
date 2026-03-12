<?php

// this file handles the owner-only deletion

session_start();

// user must be logged in
if (!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

require 'db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])){

    $post_id = (int)$_GET['id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare(
        "DELTE FROM posts WHERE id = ? AND user_id = ?"
    );

    $stmt->execute([$post_id, $user_id]);
}

header("Location: board.php");
exit();
?>