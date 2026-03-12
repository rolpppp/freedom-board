<?php 
session_start();
require 'db.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>[Your Name]'s Freedom Board</title>
	<link rel="stylesheet" href="style.css"/>

</head>
<body>
    <h1>Freedom Board</h1>

    <!-- Action points to the processing file -->
	<!-- Note that when the form gets submitted, the form data
			is processed by post_message.php.
	-->
	<!-- TODO: Task 1 - Ensure that the form is submitted
				using the POST method. The message and the name of the
				poster must be available via $_POST["name"] and
				$_POST["message"] at the server side.
	-->
    <?php if (isset($_SESSION['user_id'])): ?>
        <form action="post.php" method="POST">
            <textarea name="content" placeholder="Write a message..." required></textarea><br><br>
            <button type="submit">Post to Board</button>
        </form>
    <?php else: ?>
        <p><a href="login.php">Login</a> or <a href="register.php">Register</a> to post.</p>
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
