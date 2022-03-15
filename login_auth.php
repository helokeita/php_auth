<?php
session_start();

// 変数の宣言
$id = '';
$password = '';
$key = '';

// 情報の取得
$id = $_GET['id'];
$password = $_GET['password'];

if( empty($id) || empty($password)){
    $error_message = '入力されていません';
    $_SESSION['error_message'] = $error_message;
    header('Location:login.php');
    exit;
}

// セッションを削除しておく
unset($_SESSION['password']);

// セッションを残しておく
$_SESSION['id'] = $id;


// データベース処理
$db = new PDO('mysql:host=localhost;dbname=login','root','');

try{
    // トランザクション開始
    $db->beginTransaction();
    
    // ログイン情報の登録
    // SQL文実行
    $sql = 'SELECT  login_users_id, login_id, password FROM login_users WHERE login_id = :login_id;';
    
    // 事前にSQL登録
    $sth = $db->prepare($sql);
    
    // 変数名をバインド
    $sth->bindParam(':login_id', $id);
    
    // 実行
    $sth->execute();
    
    // 結果を取得する
    $result = $sth->fetch();
    
    
    // 結果は出ているか判定
    if(!empty($result)){
        // パスワードとハッシュ値の確認　/あっていたらログイン
        if(password_verify($password,$result['password'])){
            // 抽出されたユーザのIDを取得
            $login_user_id = $result['login_users_id'];
            // キー　簡単な乱数
            $key = random_int(0, 255);
    
            $sql = 'INSERT INTO login_session ( login_users_id, pass_key )  VALUES( :login_users_id, :pass_key )';
    
            $sth = $db->prepare($sql);
    
            $sth->bindParam(':login_users_id', $login_user_id);
            $sth->bindParam(':pass_key', $key);
    
            $sth->execute();
    
            $db->commit();
    
            $_SESSION['id'] = $login_user_id;
            header( 'Location: ok.php' );
            exit;
        }else{
            $error_message = '入力値が間違えています';
        }
    }else{
        $error_message = '入力値が間違えています';
    }
}catch (Exception $e) {
    $db->rollback();
    echo $e->getMessage();
}


if(!empty($error_message)){
    $_SESSION['error_message'] = $error_message;
    header('Location:login.php');
    exit;
}


