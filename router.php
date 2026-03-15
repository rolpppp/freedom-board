<?php
// Router script for PHP's built-in dev server.
// Usage: php -S localhost:8080 router.php

// If the request is for the root URL, redirect to the entry point
if ($_SERVER['REQUEST_URI'] === '/') {
    header('Location: /public/index.php');
    exit();
}

// Otherwise, let PHP serve the requested file normally
return false;
