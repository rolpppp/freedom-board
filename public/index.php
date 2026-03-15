<?php
// Entry point — redirect to login (auth_check will forward to board if already logged in)
header("Location: /src/auth/login.php");
exit();
?>