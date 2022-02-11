<?php

try {
    //PDO(PHP Database Objects)PHPでデータベースを連動、扱うもの
    //下記はデータベースにアクセスするためのPDOオブジェクト
    $pdo = new PDO(
        //DSN(データソース名)
        'mysql:host=db;dbname=myapp;charset=utf8mb4', 
        //ユーザー名
        'myappuser',
        //パスワード                                  
        'myapppass',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,     //sqlの間違いを教えてくれないので、教えてくれるオプション
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,//カラム名がついた結果だけ常にほしいときのオプション
        ]                             
    );

    $stmt = $pdo->query("SELCT 5 + 3");
    $result = $stmt->fetch();
    var_dump($result);
//try catch エラーメッセージをわかりやすく表示させる    
} catch (PDOException $e) {
    echo $e->getMessage() . PHP_EOL;
    exit;
}  