<?php
try {
    $pdo = new PDO(
        'mysql:host=db;dbname=myapp;charset=utf8mb4', 
        'myappuser',                                
        'myapppass',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]                             
    );

    $pdo->query("DROP TABLE IF EXISTS posts");  //同名ポストがあれば削除する命令

    //テーブル、エクセル表のようなもの
    $pdo->query(
        "CREATE TABLE posts (
            id INT NOT NULL AUTO_INCREMENT,
            message VARCHAR(140),  
            likes INT,             
            PRIMARY KEY (id)
            )"
    );

    $pdo->query(
        "INSERT INTO posts (message, likes) VALUE
         ('Thanks', 12),
         ('thanks', 4),
         ('Arigato', 15)"
    );

    $stmt = $pdo->query("SELECT * FROM posts");  
    $results = $stmt->fetchAll();
    var_dump($results);
} catch (PDOException $e) {
    echo $e->getMessage() . PHP_EOL;
    exit;
}  