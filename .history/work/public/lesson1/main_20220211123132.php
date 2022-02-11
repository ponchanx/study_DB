<?php

$pdo = new PDO(
    'mysql:host=db;dbname=myapp;charset=utf8mb4',
    'dbuser',
    'dbpass'
);

$stmt = $pdo->query("SELECT 5 + 3");
$result = $stmt->fetch();
va