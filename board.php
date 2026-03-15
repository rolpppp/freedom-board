<?php
session_start();
require 'db.php';

// Search Logic
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchQuery = "";
$params = [];

if ($search) {
    $searchQuery = " AND (posts.content LIKE ? OR users.username LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

// Pagination Logic
$limit = 5; // Posts per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Count total pages
$countSql = "SELECT COUNT(*) FROM posts JOIN users ON posts.user_id = users.id WHERE posts.parent_id IS NULL" . $searchQuery;
$stmtCount = $pdo->prepare($countSql);
$stmtCount->execute($params);
$totalPosts = $stmtCount->fetchColumn();
$totalPages = ceil($totalPosts / $limit);

// Get all top-level posts (not replies) with search and pagination
$sql = "SELECT posts.id, posts.content, posts.time_posted, posts.user_id, users.username 
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        WHERE posts.parent_id IS NULL" . $searchQuery . " 
        ORDER BY posts.time_posted DESC 
        LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$posts = $stmt->fetchAll();

// Helper function to fetch replies
function getReplies($pdo, $parentId) {
    $stmt = $pdo->prepare("SELECT posts.id, posts.content, posts.time_posted, posts.user_id, users.username FROM posts JOIN users ON posts.user_id = users.id WHERE posts.parent_id = ? ORDER BY posts.time_posted ASC");
    $stmt->execute([$parentId]);
    return $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Freedom Board</title>
    <link rel="stylesheet" href="style.css"/>
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

    <div class="search-container">
        <form action="board.php" method="GET">
            <input type="text" name="search" placeholder="Search authors or topics..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Search</button>
            <?php if($search): ?>
                <a href="board.php" style="margin-left: 10px; font-size: 0.9em;">Clear</a>
            <?php endif; ?>
        </form>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
        <form action="post.php" method="POST" class="post-form">
            <textarea name="content" placeholder="Write a message..." required></textarea><br>
            <button type="submit">Post to Board</button>
        </form>
    <?php else: ?>
        <p style="text-align: center; margin: 20px;">Please <a href="login.php">login</a> to post a message.</p>
    <?php endif; ?>

    <hr>
    <h2>Messages</h2>

    <div class="board-container">
        <?php if (count($posts) > 0): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <strong><?= htmlspecialchars($post['username']) ?></strong>:
                    <?= htmlspecialchars($post['content']) ?>
                    <div class="meta">Posted on: <?= $post['time_posted'] ?></div>

                    <div class="actions">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="#" onclick="document.getElementById('reply-form-<?= $post['id'] ?>').style.display='block'; return false;">Reply</a>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['user_id']) && $post['user_id'] == $_SESSION['user_id']): ?>
                            | <a href="delete.php?id=<?= $post['id'] ?>" class="delete-btn">Delete</a>
                        <?php endif; ?>
                    </div>

                    <div id="reply-form-<?= $post['id'] ?>" class="reply-form" style="display: none;">
                        <form action="post.php" method="POST">
                            <input type="hidden" name="parent_id" value="<?= $post['id'] ?>">
                            <textarea name="content" placeholder="Write a reply..." required></textarea>
                            <button type="submit">Send Reply</button>
                        </form>
                    </div>

                    <?php $replies = getReplies($pdo, $post['id']); ?>
                    <?php foreach($replies as $reply): ?>
                        <div class="post reply">
                            <strong>↳ <?= htmlspecialchars($reply['username']) ?></strong>:
                            <?= htmlspecialchars($reply['content']) ?>
                            <div class="meta">Posted on: <?= $reply['time_posted'] ?></div>
                            <?php if (isset($_SESSION['user_id']) && $reply['user_id'] == $_SESSION['user_id']): ?>
                                <a href="delete.php?id=<?= $reply['id'] ?>" class="delete-btn">Delete</a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No messages found.</p>
        <?php endif; ?>
    </div>

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="board.php?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>">« Previous</a>
        <?php endif; ?>
        
        <?php if ($totalPages > 0): ?>
            <span>Page <?= $page ?> of <?= $totalPages ?></span>
        <?php endif; ?>

        <?php if ($page < $totalPages): ?>
            <a href="board.php?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>">Next »</a>
        <?php endif; ?>
    </div>
</body>
</html>