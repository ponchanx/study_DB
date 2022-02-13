<?php

//lIKEを使って抽出しよう!


try {
    $pdo = new PDO(
        'mysql:host=db;dbname=myapp;charset=utf8mb4', 
        'myappuser',                                
        'myapppass',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,  
        ]                             
    );

    $pdo->query("DROP TABLE IF EXISTS posts");  

    $pdo->query(
        "CREATE TABLE posts (
            id INT NOT NULL AUTO_INCREMENT,
            message VARCHAR(140),  
            likes INT,             
            PRIMARY KEY (id)
            )"
    );

    $pdo->query(
        "INSERT INTO posts (message, likes) VALUES
         ('Thanks', 12),
         ('thanks', 4),
         ('Arigato', 15)"
    );

    // $search = 't';
    $search = 't%'; //こちらに％をつける
 

    // $stmt = $pdo->query("SELECT * FROM posts");  
    $stmt = $pdo->prepare(
        // "SELECT * FROM posts WHERE message LIKE ':search%'" //LIKEを使う場合、こちらに%をつけない。
        "SELECT * FROM posts WHERE message LIKE :search" //ここの％を消すとうまくtのついたレコードが抽出される
    );
    $stmt->execute(['search' => $search]);

    $posts = $stmt->fetchAll();
    foreach ($posts as $post) {
        printf(
            '%s (%d)' . PHP_EOL,
            $post['message'],
            $post['likes']
        );
    }
    
} catch (PDOException $e) {
    echo $e->getMessage() . PHP_EOL;
    exit;

}   