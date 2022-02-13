<?php


//トランザクションを使ってみよう

class Post
{
    public function show()
    {
        echo "$this->message ($this->likes)" . PHP_EOL;
    }
}
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
    
    /*何らかの障害などの影響を受けないようにトランザクションを使う
     データの書き換えられたりすると、整合性が取れなくなるため
     */
    $pdo->beginTransaction();

    /*上記の'Thanks'に+1、'thanks'は-1にしたかた時。
    　間違っていいねした時。UPDATEを使って
    */
    $stmt = $pdo->query(
        "UPDATE posts SET likes = likes + 1 WHERE id = 1"
    );
    $stmt = $pdo->query(
        "UPDATE posts SET likes = likes - 1 WHERE id = 2"
    );
    //commitで囲ってあげればよい
    $pdo->commit();

 
    $stmt = $pdo->query("SELECT * FROM posts");  
    $posts = $stmt->fetchAll(PDO::FETCH_CLASS, 'Post');
    foreach ($posts as $post) {
        // printf(
        //     '%s (%d)' . PHP_EOL,
        //     $post['message'],
        //     $post['likes']
        // );
        $post->show();
    }
    
} catch (PDOException $e) {
    echo $e->getMessage() . PHP_EOL;
    exit;

}     