<?php

// this file is responsible for managing and connecting the mysql database to this project
// additionally, a '.env' file is utilized to hide sensitive data

$env = parse_ini_file('.env');

$host     = $env['DB_HOST'];
$db_name  = $env['DB_NAME'];
$username = $env['DB_USER'];
$password = $env['DB_PASS'];

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