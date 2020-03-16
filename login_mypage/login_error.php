<?php
session_start();

//ログイン時にアクセスした場合は、マイページにリダイレクトできるようにしましょう。
if(isset($_SESSION['id'])){
    header("Location:mypage.php");
}
?>

<!doctype HTML>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>マイページ登録</title>
    <link rel="stylesheet" type="text/css" href="login_error.css">
</head>
<body>
    <header>
        <img src="4eachblog_logo.jpg">
        <div class="login"><a href="login.php">ログイン</a></div>
    </header>

    <main>
        <form action="mypage.php" method="post">
            <div class="form_contents">
                <div class="error_message">メールアドレスまたはパスワードが間違っています。</div>
                <div class="mail">
                    <label>メールアドレス</label><br>
                    <input type="text" class="formbox" size="40" value="<?php 
																		if(isset($_COOKIE['login_keep'])){
                                                                            echo $_COOKIE['mail'];
																		}
																		?>" name="mail">
                </div>
                <div class="password">
                    <label>パスワード</label><br>
                    <input type="password" class="formbox" size="40" value="<?php 
																		if(isset($_COOKIE['login_keep'])){
																			echo $_COOKIE['password'];
																		}
																		?>" name="password">
                </div>
              
                <div class="loginbutton">
                    <input type="submit" class="submit_button" size="35" value="ログイン">
                </div>
            </div>

        </form>
    </main>








<!--    このbodyの中に、ログイン時に入力欄にメールアドレスとパスワードが表示されるようにコードを記述しましょう-->
</body>
</html>