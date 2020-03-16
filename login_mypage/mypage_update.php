<?php

mb_internal_encoding("utf8");

//セッションスタート
session_start();

if(empty($_POST['from_mypage_hensyu'])){
    header("Location:http://localhost/login_mypage\login_error.php");
}


try{
    //DB接続　-try catch文
    
    $pdo =new PDO("mysql:dbname=lesson01;host=localhost;","root","");
}catch(PDOException $e){
    die("<p>申し訳ございません。現在サーバーが込み合っており一時的にアクセス出来ません。<br>
    しばらくしてから再度ログインをしてください。</p>
    <a href='http://localhost/login_mypage/login.php'>ログイン画面へ</a>"
        );
}



//preparedステートメント（update）でSQLをセット $ bindValueめメソッドでパラメーターをセット
$stmt = $pdo->prepare("update login_mypage set name=?,mail=?,password=?,comments=? where id=?;");

$stmt->bindValue(1,$_POST['name']);
$stmt->bindValue(2,$_POST['mail']);
$stmt->bindValue(3,$_POST['password']);
$stmt->bindValue(4,$_POST['comments']);
$stmt->bindValue(5,$_SESSION['id']);


//executeでクエリを実行
$stmt->execute();

//preparedステートメント(更新された情報をDBからselect文で取得)でSQLをセット　$ bindValueメソッドでパラメーターをセット
$stmt = $pdo->prepare("select * from login_mypage where mail = ? && password = ?");

$stmt->bindValue(1,$_POST['mail']);
$stmt->bindValue(2,$_POST['password']);

$stmt->execute();

while($row=$stmt->fetch()){
    $_SESSION['id']=$row['id'];
    $_SESSION['name']=$row['name'];
    $_SESSION['mail']=$row['mail'];
    $_SESSION['password']=$row['password'];
    $_SESSION['picture']=$row['picture'];
    $_SESSION['comments']=$row['comments'];    
}




//fetch・whileぶんでデータを取得し、sessionに代入

//mypage.phpへリダイレクト

header("Location:http://localhost/login_mypage/mypage.php");


?>