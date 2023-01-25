<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-5</title>
    <h1>好きな食べ物を書き込んでください</h1>
</head>
<body>
    
<?php
$filename = "mission_3-5.txt";
$error = "* パスワードが間違っています";
    
    if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["pass1"])) {
        $name = $_POST["name"];
        $comment = $_POST["comment"];
        $date = date("Y/m/d H:i:s");
        $pass = $_POST["pass1"];
        //条件分岐：新規投稿の場合
        if(empty($_POST["editform"])){
            if(file_exists($filename)){
                $num = count(file($filename)) + 1;
            }else{
                $num = 1;
            }
            $content = $num. "<>". $name. "<>". $comment. "<>". $date. "<>". $pass. "<>";
            $fp = fopen($filename , "a");
            fwrite($fp, $content. PHP_EOL);
            fclose($fp);
        }else{
            $editform = $_POST["editform"];
            if(file_exists($filename)){
                $edit_content = $editform. "<>" . $name. "<>" . $comment . "<>". $date;
                $lines = file($filename, FILE_IGNORE_NEW_LINES);
                $fp = fopen($filename , "w");
                foreach($lines as $line){
                    $editdata = explode("<>", $line);
                    if($editform == $editdata[0]){
                        fwrite($fp, $edit_content . PHP_EOL);
                    }else {
                        fwrite($fp, $line. PHP_EOL);
                    }
                }
                fclose($fp);
            }
            
        }

    }elseif(!empty($_POST["edit_num"]) && !empty($_POST["pass3"])){
        $edit = $_POST["edit_num"];
        $edit_pass = $_POST["pass3"];
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        $fp = fopen($filename , "r");
        foreach($lines as $line){
            $editdata = explode("<>", $line);
            if($edit == $editdata[0]){
                if($edit_pass == $editdata[4]){
                    $editdata = explode("<>", $line);
                    $edit_num = $editdata[0];
                    $edit_name = $editdata[1];
                    $edit_comment = $editdata[2];
                }else{
                    echo $error. "<br>";
                }
            
            }
        }
        fclose($fp);
        
    //削除機能
    }elseif(!empty($_POST["delete_num"]) && !empty($_POST["pass2"])){
        $number = $_POST["delete_num"];
        $sql = 'delete from tbtest where number=:number';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':number', $number, PDO::PARAM_INT);
        $stmt->execute();
    }
    ?>
        
    <form action="" method="post">
        <p>
        <legend>投稿</legend>
        <input type="text" name="name" placeholder="お名前" value="<?php if(isset($edit_name)) {echo $edit_name; } ?>"> <br>
        <input type="text" name="comment" placeholder="好きな食べ物" value="<?php if(isset($edit_comment)){ echo $edit_comment; } ?>"> <br>
        <input type="hidden" name="editform" value="<?php if(isset($edit_num)) { echo $edit_num; } ?>">
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
    
    <?PHP
    $filename = "mission_3-5.txt";
        if(file_exists($filename)){
            $lines = file($filename, FILE_IGNORE_NEW_LINES);
            foreach($lines as $line){
                $linearray = explode("<>", $line);
                $str = $linearray[0]. "  ". $linearray[1]. "  ". $linearray[2]. "  ". $linearray[3];
                echo $str;
                echo "<br>";
            }
        }
    
    ?>

</body>
</html>