<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_1-27</title>
</head>
<body>
    <form action="" method="post">
        数字を入力：<input type="number" name="num" placeholder="半角数字">
        <input type="submit" name="submit">
    </form>
    
    
<?php
if(!empty($_POST["num"])) {
    $num = $_POST["num"];
    $filename = "mission_1-27.txt";
    $fp = fopen($filename , "a");
    fwrite($fp, $num. PHP_EOL);
    fclose($fp);
    echo "書き込み成功！<br>";
    

    
    if(file_exists($filename));{
        $values = file($filename, FILE_IGNORE_NEW_LINES);
        foreach($values as $value){
            if($value % 15 == 0){
                echo "FizzBuzz<br>";
            }elseif($value % 3 == 0){
                echo "Fizz<br>";
            }elseif($value % 5 == 0){
                echo "Buzz<br>";
            }else{
                echo $value;
                echo "<br>";
            }
        }        
    }
}    
?>
</body>
</html>