<?php

// this file is responsible for managing and connecting the mysql database to this project
// reads from system environment variables (Railway) with fallback to local .env file

$env = file_exists(__DIR__ . '/../.env') ? parse_ini_file(__DIR__ . '/../.env') : [];

$host     = getenv('DB_HOST')     ?: ($env['DB_HOST']     ?? '');
$db_name  = getenv('DB_NAME')     ?: ($env['DB_NAME']     ?? '');
$username = getenv('DB_USER')     ?: ($env['DB_USER']     ?? '');
$password = getenv('DB_PASS')     ?: ($env['DB_PASS']     ?? '');

try{
    // using PDO or PHP Data Objects
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db_name;charset=utf8",
        $username,
        $password
    );

    // this is to make PDO throw exceptions on errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // this is so that fetched rows return as associative arrays like $row['username']
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>