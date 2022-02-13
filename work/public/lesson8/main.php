<?php

//bindValue()で値を紐付けする

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

    $message = 'Merci';
    $likes = 8;
    $stmt = $pdo->prepare(
        "INSERT INTO
         posts (message, likes)
        VALUES
         (:message, :likes)"
    );


    $stmt->bindValue('message', $message, PDO::PARAM_STR); //文字型で渡してね
    $stmt->bindValue('likes', $likes, PDO::PARAM_INT);     //整数型で渡してね
    $stmt->execute(); 
    /*execute（）で値を渡すと全て文字列として埋め込まれるので
    明示的に型を指定したい場合はbindValueを使う。
    */

    $stmt = $pdo->query("SELECT * FROM posts");  
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