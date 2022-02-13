<?php

//ロールバックで変更を取り消そー

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

    /*トランザクションはデータの書き換えなどの干渉を受けないように使うが
    　トランザクション中にエラーが出てしまった時に、エラー時に処理を取りけす必要がある。
    　それがrollback。
      そうしないと処理が中途半端になるため。
      */
    $pdo->beginTransaction();
    $stmt = $pdo->query(
        "UPDATE posts SET likes = likes + 1 WHERE id = 1"
    );
    $stmt = $pdo->query(
        // "UPDATE posts SET likes = likes - 1 WHERE id = 2"
        "UPDATE post SET likes = likes - 1 WHERE id = 2"
    );
    $pdo->commit();
 
    
} catch (PDOException $e) {
    $pdo->rollBack();
    echo $e->getMessage() . PHP_EOL;
    // exit;

    /*例外が起きても起きなくて実行したい処理はfinally
     今回レッスンの為まず最後まで実行する。上記のexitで
     処理が止まらないようにコメントにする。
     */
} finally {
    $stmt = $pdo->query("SELECT * FROM posts");  
    $posts = $stmt->fetchAll(PDO::FETCH_CLASS, 'Post');
    foreach ($posts as $post) {
        $post->show();
    }
    
}  