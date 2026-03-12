<?php

// --------------------------------------------------------------------------------------------------------
// this is just for the JOIN query

require 'db.php';

$stmt = $pdo->query(
    "SELECT posts.id, posts.content, posts.time_posted, posts.user_id, posts.parent_id, users.username
    FROM posts
    JOIN users ON posts.user_id = user.id
    WHERE posts.parent_id IS NULL
    ORDER BY posts.posted_at DESC"
);

$posts = $stmt->fetchAll();

// --------------------------------------------------------------------------------------------------------


// --------------------------------------------------------------------------------------------------------
// this is for the pagination feature
$posts_per_page = 10;

// cursor paging is used for better scalability capabilities than simple pagination via offset
$cursor = isset($_GET['cursor']) ? (int) $_GET['cursor'] : null;

if ($cursor) {
    $stmt = $pdo->prepare(
        "SELECT posts.id, posts.content, posts.created_at, posts.user_id, posts.parent_id,
                users.username
         FROM posts
         JOIN users ON posts.user_id = users.id
         WHERE posts.parent_id IS NULL
           AND posts.id < ?
         ORDER BY posts.id DESC
         LIMIT ?"
    );

    $stmt->execute([$cursor, $posts_per_page]);
} else {
    // First page
    $stmt = $pdo->prepare(
        "SELECT posts.id, posts.content, posts.created_at, posts.user_id, posts.parent_id,
                users.username
         FROM posts
         JOIN users ON posts.user_id = users.id
         WHERE posts.parent_id IS NULL
         ORDER BY posts.id DESC
         LIMIT ?"
    );

    $stmt->execute([$posts_per_page]);
}

$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// this will be used for next-paging
$last_post = end($posts);
$next_cursor = $last_post['id'] ?? null;
?>