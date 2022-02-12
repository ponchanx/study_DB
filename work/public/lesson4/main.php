<?php

//抽出条件を指定する方法

try {
    $pdo = new PDO(
        'mysql:host=db;dbname=myapp;charset=utf8mb4', 
        'myappuser',                                
        'myapppass',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            /*エミュレートモードをオフにする。
            　idやlikesなどの整数型を正しく表示するため。
            　デフォだと文字列（string)ででる
            */
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
        "INSERT INTO posts (message, likes) VALUE
         ('Thanks', 12),
         ('thanks', 4),
         ('Arigato', 15)"
    );
    // $n = 10;
    $n = '10 OR 1=1';

     //10より小さいいいね（likes)を消す。
    // $pdo->query("DELETE FROM posts WHERE likes < 10 ");

     /*$n(変数)の値を直接書いてはいけない。
       1=1は常にTRUEになるため片方がTRUEなら常にTUREになるため全て消されてしまことになる
     */  
    $pdo->query("DELETE FROM posts WHERE likes < $n ");

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