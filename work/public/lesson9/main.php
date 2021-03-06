<?php

//bindparam()で変数を紐付けしよう

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
    //新しくレコードを追加した場合、bindValueを消しParamにできる
    $stmt->bindParam('message', $message, PDO::PARAM_STR); 
    $stmt->bindParam('likes', $likes, PDO::PARAM_INT);     
    $stmt->execute(); 


    $message = 'Gracias';
    $likes = 5;
    // $stmt->bindValue('message', $message, PDO::PARAM_STR); 
    // $stmt->bindValue('likes', $likes, PDO::PARAM_INT);     
    $stmt->execute(); 

    $message = 'Danke';
    $likes = 11;
    $stmt->execute();

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