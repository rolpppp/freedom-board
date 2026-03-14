<?php

require 'db.php';

// Get all top-level posts (not replies)
$stmt = $pdo->query(
    "SELECT posts.id, posts.content, posts.time_posted, posts.user_id, posts.parent_id, users.username
    FROM posts
    JOIN users ON posts.user_id = users.id
    WHERE posts.parent_id IS NULL
    ORDER BY posts.time_posted DESC"
);

$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Freedom Board</title>
    <link rel="stylesheet" href="style.css"/>
    <style>
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f0f0f0;
            padding: 10px 20px;
            border-bottom: 1px solid #ccc;
            margin-bottom: 20px;
        }
        .navbar a {
            color: #1976d2;
            text-decoration: none;
            margin-left: 15px;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .user-info {
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1 style="margin: 0;">Freedom Board</h1>
        <div>
            <?php session_start(); ?>
            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="user-info">Welcome, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></span>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
        </div>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
        <form action="post.php" method="POST" style="background: #f9f9f9; padding: 15px; border-radius: 5px; margin: 20px auto; max-width: 600px;">
            <textarea name="content" placeholder="Write a message..." required style="width: 100%; height: 80px; padding: 8px; box-sizing: border-box;"></textarea><br><br>
            <button type="submit" style="padding: 10px 20px; cursor: pointer;">Post to Board</button>
        </form>
    <?php else: ?>
        <p style="text-align: center; margin: 20px;">Please <a href="login.php">login</a> or <a href="register.php">register</a> to post a message.</p>
    <?php endif; ?>

    <hr>
    <h2 style="max-width: 600px; margin: 20px auto;">Recent Messages</h2>

    <div style="max-width: 600px; margin: 0 auto;">
        <?php if (count($posts) > 0): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <strong><?= htmlspecialchars($post['username']) ?></strong>:
                    <?= htmlspecialchars($post['content']) ?>
                    <div class="meta">Posted on: <?= $post['time_posted'] ?></div>

                    <!-- Delete button — only visible to the post owner -->
                    <?php if (isset($_SESSION['user_id']) && $post['user_id'] == $_SESSION['user_id']): ?>
                        <a href="delete.php?id=<?= $post['id'] ?>" style="color: #d32f2f; text-decoration: none; font-size: 0.9em;">Delete</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No messages yet. Be the first to post!</p>
        <?php endif; ?>
    </div>
</body>
</html>