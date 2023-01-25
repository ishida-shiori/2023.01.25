<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-1</title>
    <h1>行ってみたい旅行先を書き込んでください</h1>
</head>
<body>
<?php

    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    //テーブルを消すとき
    //$sql = 'DROP TABLE boarddata';
      //  $stmt = $pdo->query($sql);
    
    
    echo "<hr>";
    $sql = "CREATE TABLE IF NOT EXISTS boarddata"
    ." ("
    . "number INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32) NOT NULL,"
    . "comment TEXT NOT NULL,"
    . "date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,"
    . "pass char(32) NOT NULL"
    .");";
    $stmt = $pdo->query($sql);
    
    #構造チェックをするとき
    #$sql ='SHOW CREATE TABLE boarddata';
    #$result = $pdo -> query($sql);
    #foreach ($result as $row){
    #    echo $row[1];
    #}
    #echo "<hr>";

    //投稿欄に入力有
    if(!empty($_POST["name"]) && !empty($_POST["comment"]) &&!empty($_POST["pass1"])){
        $name = $_POST["name"];
        $comment = $_POST["comment"]; 
        $pass1 = $_POST["pass1"];
        
         
    //新規投稿
        if(empty($_POST["editform"])){
            $sql = $pdo -> prepare("INSERT INTO boarddata (name, comment, pass) VALUES (:name, :comment, :pass)");
            $sql -> bindParam(':name', $name, PDO::PARAM_STR);
            $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
            $sql -> bindParam(':pass', $pass1, PDO::PARAM_STR); 
            $sql -> execute(); 
            
            
    //編集での投稿
        }else{
            $number = $_POST["editform"];
            $sql = 'UPDATE boarddata SET name=:name,comment=:comment, pass=:pass WHERE number=:number';
            $stmt = $pdo->prepare($sql);
            $stmt-> bindParam(':name', $name, PDO::PARAM_STR);
            $stmt-> bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt-> bindParam(':pass', $pass1, PDO::PARAM_STR);
            $stmt-> bindParam(':number', $number, PDO::PARAM_INT);
            $stmt-> execute();
        }  

    //編集
    }elseif(!empty($_POST["edit_num"]) && !empty($_POST["pass3"])){
        $edit_num = $_POST["edit_num"];
        $pass3 = $_POST["pass3"];
        $sql = 'SELECT * FROM boarddata WHERE number=:number AND pass=:pass';
        $stmt = $pdo->prepare($sql);                  
        $stmt->bindParam(':number', $edit_num, PDO::PARAM_INT); 
        $stmt->bindParam(':pass', $pass3, PDO::PARAM_STR);
        $stmt->execute();    
        $results = $stmt->fetchAll(); 
        foreach ($results as $row){
            $edit_name =  $row['name'];
            $edit_comment = $row['comment'];
    }
            
    
    //削除機能
    }elseif(!empty($_POST["delete_num"]) && !empty($_POST["pass2"])){
        $number = $_POST["delete_num"];
        $pass2 = $_POST["pass2"];
        $sql = 'delete from boarddata WHERE number=:number AND pass=:pass';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':number', $number, PDO::PARAM_INT);
        $stmt->bindParam(':pass', $pass2, PDO::PARAM_STR);
        $stmt->execute();

    }
 
?>
    <form action="" method="post">
        <p>
        <legend>投稿</legend>
        <input type="text" name="name" placeholder="お名前" value= <?php if(isset($edit_name)){echo $edit_name;}?>> <br>
        <input type="text" name="comment" placeholder="行ってみたい旅行先" value= <?php if(isset($edit_comment)){echo $edit_comment;}?>> <br>
        <input type="hidden" name="editform" value= <?php if(isset($edit_num)){echo $edit_num;}?>>
        <input type="text" name="pass1" placeholder="パスワード"> 
        <input type="submit" name="submit"> </p>
        
        <p>
        <legend>削除</legend>
        <input type="number" name="delete_num" placeholder="削除対象番号"> <br>
        <input type="text" name="pass2" placeholder="パスワード"> 
        <input type= "submit" value="削除"></p>
        
        <p>
        <legend>編集</legend>
        <input type="number" name="edit_num" placeholder="編集対象番号"> <br>
        <input type="text" name="pass3" placeholder="パスワード"> 
        <input type="submit" value="編集"></p>
        
        <hr size="2" width="800" align="left" color="dimgray" noshade>
        <legend>結果一覧</legend>
        <legend></legend>
        
    </form>
<?php
//データベースの中身をブラウザに表示
    $sql = 'SELECT * FROM boarddata';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        echo $row['number'].' ';
        echo $row['name'].' ';
        echo $row['comment'].' ';
        echo $row['date'].'<br>';
    echo "<hr>";
    }
?>
</body>   
</html>
