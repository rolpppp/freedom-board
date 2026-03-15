<?php
require __DIR__ . '/../db.php';

// this file fetches the current count of posts for auto fetching
$stmt = $pdo->query("SELECT MAX(id) FROM posts");
echo $stmt->fetchColumn() ?? 0;
