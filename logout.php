<?php
session_start();

$id = '';

if(!empty($_SESSION['id'])){
    $id = $_SESSION['id'];
}

$db = new PDO('mysql:host=localhost;dbname=login','root','');

try{
    // トランザクション開始
    $db->beginTransaction();
    // データを削除するSQLを設定する
    $sql = 'DELETE FROM login_session WHERE login_users_id = :login_users_id;';

    // データベースに事前にSQLを登録する
    $sth = $db->prepare($sql);


    // 変数名をバインド
    $sth->bindParam(':login_users_id', $id);

    // SQLを実行する
    $sth->execute();

    // コミット
    $db->commit();

}catch (Exception $e) {
    $db->rollback();
    echo $e->getMessage();
}

// ここでセッションを消す
unset($_SESSION['id']);

// ログイン画面へ遷移
$error_message = 'ログアウトしました';
$_SESSION['error_message'] = $error_message;
header( 'Location: login.php' );
exit;
