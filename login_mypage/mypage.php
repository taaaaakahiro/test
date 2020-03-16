<?php

mb_internal_encoding("utf8");
session_start();

if(empty($_SESSION['id'])){
 //try catch文 DBに接続できなければエラーメッセージを表示   
    try{$pdo = new PDO("mysql:dbname=lesson01;host=localhost;","root","");}catch(PDOException $e){
    die("<p>申し訳ございません。現在サーバーが込み合っており一時的にアクセスができません。<br>しばらくしてから再度ログインしてください。</p>
    <a href='http://localhost/login_mypage/login.php'>ログイン画面へ</a>");
}
    
//プリペアードステートメントでSQL文の型を作る（DBとpostデータを照合させる。）
$stmt = $pdo->prepare("select * from login_mypage where mail = ? && password = ?"); 
    
//bindValueメソッドでパラメーターをセット 
$stmt->bindValue(1,$_POST["mail"]);
$stmt->bindValue(2,$_POST["password"]);    
    
//executeでクエリを実行
$stmt->execute();    



//fetch・while文でデータ取得し、sessionに代入
while($row=$stmt->fetch()){
    $_SESSION['id']=$row['id'];
    $_SESSION['name']=$row['name'];
    $_SESSION['mail']=$row['mail'];
    $_SESSION['password']=$row['password'];
    $_SESSION['picture']=$row['picture'];
    $_SESSION['comments']=$row['comments'];
}

    if(empty($_SESSION['id'])){
        header("Location:login_error.php");
    }
//データ取得ができずに（emptyを併用して判定）sessionがなければ、リダイレクト（エラー画面へ）



}

setcookie('mail',$_SESSION['mail'],time()+60*60*24*7,'/');
setcookie('password',$_SESSION['password'],time()+60*60*24*7,'/');

//データベースを切断
$pdo = NULL;

?>

<!DOCTYPE HTML>
<html lang="ja">
<head>
    <meta charset="utf8">
    <title>マイページ登録</title>
    <link rel="stylesheet" type="text/css" href="mypage.css">
</head>
    
<body>
    <header>
        <img src="4eachblog_logo.jpg">
        <div class="logout"><a href="log_out.php">ログアウト</a></div>
    </header>
    
    <main>
        <div class="box">
            <h2>会員情報</h2>
            <div class="hello">
                <?php echo "こんにちは! ".$_SESSION['name']."さん"; ?>
            </div>
            <div class="profile_pic">
                <img src="<?php echo $_SESSION['picture']; ?>">
            </div>
            <div class="basic_info">
                <p>氏名:
                    <?php echo $_SESSION['name']; ?>
                </p>
                <p>メール:
                    <?php echo $_SESSION['mail']; ?>
                </p>
                <p>パスワード:
                    <?php echo $_SESSION['password']; ?>
                </p>
            </div>
            <div class="comments">
                <?php echo $_SESSION['comments']; ?>
            </div>
            <form action="mypage_hensyu.php" method="post" class="form_center">
                <input type="hidden" value="<?php echo rand(1,10); ?>" name="from_mypage">
                
                <div class="hensyubutton">
                    <input type="submit" class="submit_button" size="35" value="編集する">
                </div>
            </form>
        </div>              
    </main>
    <footer>
        © 2018 InterNous.inc All rights reserved 
    </footer>
<!--        このbodyの中に、マイページとして表示する部分を記述していく（HTMLと代入したsessionを記述）-->

</body>
</html>