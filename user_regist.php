<?php
session_start();

// 変数の宣言
$error_message = '';
$mail = '';


// エラーが発生している時の処理
if(!empty($_SESSION['error_message'])){
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

// それぞれの変数に値を代入
if ( !empty( $_SESSION['mail'] ) ){
    $mail = $_SESSION['mail'];
    unset( $_SESSION['mail'] );
}
// パスワードは保持しない
if ( !empty( $_SESSION['password'] ) ){
    unset( $_SESSION['password'] );
}

// テンプレートとなるhtmlファイルを読み込む
$html = file_get_contents( 'user_regist.html' );

// htmlファイルの変更したい部分を変換する
$html = str_replace( '#error_message#', htmlspecialchars( $error_message ), $html );
$html = str_replace( '#mail#', htmlspecialchars( $mail ), $html );

// 変換したhtmlを表示する
print( $html );
