<?php
// this is for checking sessions

if (isset($_SESSION['user_id'])) {
    header("Location: /src/posts/board.php");
    exit();
}
?>
