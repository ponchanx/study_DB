<?php

//PDO::FETCH_CLASSを使ってみよう

class Post
{
    //全てがpublicの場合自動的にカラム名が作られるので省略できる
    // public $id;
    // public $message;
    // public $likes;

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