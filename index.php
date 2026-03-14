<?php 
session_start();
require 'db.php';
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
        <form action="post.php" method="POST">
            <textarea name="content" placeholder="Write a message..." required></textarea><br><br>
            <button type="submit">Post to Board</button>
        </form>
    <?php else: ?>
        <p>Please <a href="login.php">login</a> or <a href="register.php">register</a> to post a message.</p>
    <?php endif; ?>

    <hr>
    <h2>Recent Messages</h2>
    <?php
    $stmt = $pdo->query(
        "SELECT posts.id, posts.content, posts.time_posted, posts.user_id,
                users.username
         FROM posts
         JOIN users ON posts.user_id = users.id
         ORDER BY posts.time_posted ASC"
    );
    $posts = $stmt->fetchAll();

    if (count($posts) > 0):
        foreach ($posts as $post):
    ?> 
        <div class="post">
                <strong><?= htmlspecialchars($post['username']) ?></strong>:
                <?= htmlspecialchars($post['content']) ?>
                <div class="meta">Posted on: <?= $post['time_posted'] ?></div>

                <!-- Delete button — only visible to the post owner -->
                <?php if (isset($_SESSION['user_id']) && $post['user_id'] == $_SESSION['user_id']): ?>
                    <a href="delete.php?id=<?= $post['id'] ?>">Delete</a>
                <?php endif; ?>
            </div>
        <?php
            endforeach;
        else:
            echo "<p>No messages yet. Be the first to post!</p>";
        endif;
        ?>
</body>
</html>
