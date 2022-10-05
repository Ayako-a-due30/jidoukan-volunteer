<?php
error_reporting(E_ALL);
ini_set('display_errors','On');


if(!empty($_POST)){
    define('MSG01','入力必須です。');
    define('MSG02','Emailの形式で入力してください。');
    define('MSG03','メールアドレス（再入力）が一致しません');

    $err_msg=array();
    
    if(empty($_POST['volunteerName'])){
        $err_msg['volunteerName'] = 'MSG01';
    }
    if(empty($_POST['mail'])){
        $err_msg['mail'] = 'MSG01';
    }
    if(empty($_POST['re-mail'])){
        $err_msg['re-mail'] = 'MSG01';
    }
    if(empty($_POST['gender'])){
        $err_msg['gender'] = 'MSG01';
    }
    if(empty($_POST['activities[]'])){
        $err_msg['activities[]'] = 'MSG01';
    }
    
    if(empty($err_msg)){
        $volunteerName = $_POST['volunteerName'];
        $mail = $_POST['mail'];
        $gender = $_POST['gender'];
        $activities = implode($_POST['activities']);
        $comment = $_POST['comment'];
        $success = '';
        
        $dsn = 'mysql:dbname=sample;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
        );
        $dbh = new PDO($dsn, $user, $password, $options);
        $stmt = $dbh->prepare('INSERT INTO `volunteer`(volunteerName, mail, gender, activities, comment, login_time) VALUES (:volunteerName, :mail, :gender, :activities, :comment, :login_time)');
        $stmt->execute(array(':volunteerName' => $volunteerName,':mail' => $mail, ':gender' => $gender, ':activities' => $activities, ':comment' => $comment,':login_time' => date('Y-m-d H:i:s')));
        
        $success='ご登録ありがとうございます。あらためてメールをお送りいたします。';
    }
}
    
    

?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>さくらんぼじどうかん</title>
        <link rel="stylesheet" href="../fontawesome-free-6.2.0-web/css/all.css">
        <link rel="stylesheet" href="jidoukan.css">
        <link rel="stylesheet" href="jidoukan.php">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1p:wght@100&family=Tiro+Bangla&display=swap" rel="stylesheet">
    </head>
    <body>
        <header>
            <div class ="titleSign">
                <img src="fruit_cherry.png" alt="" class="fruit_cherry cherry1">
                <a href="jidoukan.php"><h1> さくらんぼじどうかん</h1></a>
                <img src="fruit_cherry.png" alt="" class="fruit_cherry cherry2">
            </div>
            <nav class="top-nav">
                <ul>
                <a href="jidoukan.php"><li class="about"><i class="fa-solid fa-seedling"></i>児童館について</li></a>
                <a href=""><li class="club"><i class="fa-solid fa-paper-plane"></i>放課後児童クラブ</li></a>
                <a href=""><li class="event"><i class="fa-solid fa-heart"></i>イベント</li></a>
                <a href="exchange.php"><li class="exchange"><i class="fa-solid fa-child-dress"></i>子育てグッズゆずります</li></a>
                </ul>
            </nav>
        </header>
        <main>
            <div value="<?php if(!empty($success)) echo $success;?>" class="message-block"></div>
            <h2 class="volunteer-form">ボランティア登録フォーム</h2>
            <form action="" method="post">
                <div class="form-group">
                    <table>
                        <tr class="form-group"><label for="">
                            <th>
                                お名前：必須
                            </th>
                            <td><span class="err_msg"><?php (!empty($err_msg['volunteerName']))?></span>
                                <input type="text" name="volunteerName" id="name" cols="30" rows="10" class="valid-name">
                                <span class="help-block"></span>
                            </td>
                            </label>
                        </tr>
                        <tr class="form-group">
                            <label for="">
                                <th>
                                    メールアドレス：必須
                                </th>
                                <td><span class ="err_msg"><?php (!empty($err_msg['mail']))?></span>
                                    <input type="email" name="mail" id="email" class="valid-mail">
                                    <span class="help-block"></span>
                                </td>
                            </label>
                        </tr>
                        <tr class="form-group"><label for="">
                            <th>
                                メールアドレス（再入力）：必須
                            </th>
                            <td>
                                <input type="email" name="re-mail" class="revalid-mail">
                                <span class="help-block"></span>
                            </td>
                            </label>
                        </tr>
                        <tr class="form-group"><label for="">
                            <th>
                                性別：必須
                            </th>
                            <td>
                                <input type="radio" name="gender" value="male">男性
                                <input type="radio" name="gender" value="female">女性
                                <input type="radio" name="gender" value="noComment">選択しない
                                <span class="help-block"></span>
                            </td>
                            </label>
                        </tr>
                        <tr class="form-group"><label for="">
                            <th>
                                参加いただける活動：必須
                            </th>
                            <td>
                                <input type="checkbox" name="activities[]" value="屋外/" >屋外遊び
                                <input type="checkbox" name="activities[]" value="室内/">室内遊び
                                <input type="checkbox" name="activities[]" value="動物・昆虫/">動物・昆虫遊び
                                <input type="checkbox" name="activities[]" value="ものづくり/">ものづくりワークショップ
                                <input type="checkbox" name="activities[]" value="学習/">学習イベント
                            </td>
                            </label>
                        </tr>
                        <tr class="form-group">
                            <th>
                                コメント：任意
                            </th>
                            <td>
                                <textarea name="comment" id="count-text" cols="30" rows="10" class="valid-text"></textarea>
                                <div class="counter"><span class ="show-count">0</span>/100
                                </div>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <th colspan=2>
                                <p class="confirmation">登録を完了された方にはこちらからイベントへの参加募集のメールを送らせていただきます。</p>
                            <input type="submit" value="送信">
                            </th>
                        </tr>
                    </table>
                </div>
            </form>
        </main>
        <footer>
            <div class="flowerLine">
                <img src="line_flowers.png" alt="flowers"> 
            </div>
            <p>copyright <a href="jidoukan.php">さくらんぼ児童館</a> All right reserved.</p>
        </footer>
    </body>
    <script src ="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src ="jidoukan.js"></script>

</html>

