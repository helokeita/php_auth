<?php
session_start();

$id = '';
$error_message ='';

// セッションを受け取る
if(!empty($_SESSION['id'])){
    $id = $_SESSION['id'];
}

$db = new PDO('mysql:host=localhost;dbname=login','root','');

// SQL文実行
$sql = 'SELECT pass_key password FROM login_session WHERE login_users_id = :login_users_id;';

// 事前にSQL登録
$sth = $db->prepare($sql);

// 変数名をバインド
$sth->bindParam(':login_users_id', $id);

// 実行
$sth->execute();

// 結果を取得する
$result = $sth->fetch();

// 結果は出ているか判定
if(!empty($result)){
    $html = file_get_contents('ok.html');
    print($html);
}else{
    $error_message = 'ログインしてください';
    $_SESSION['error_message'] = $error_message;
    header('Location:login.php');
    exit;
}