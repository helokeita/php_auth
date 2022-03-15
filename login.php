<?php
session_start();

// 変数
$error_message = '';
$id = '';

// セッション変数があれば、値を取得する
if ( !empty( $_SESSION['error_message'] ) ) {
    $error_message = $_SESSION['error_message'];
    // 使ったセッションをクリアしておく
    unset( $_SESSION['error_message'] );
}

if ( !empty( $_SESSION['id'] ) ) {
    $id = $_SESSION['id'];
    // 使ったセッションをクリアしておく
    unset( $_SESSION['id'] );
}

// テンプレートとなるhtmlファイルを読み込む
$html = file_get_contents( 'login.html' );

// htmlファイルの変更したい部分を変換する
$html = str_replace( '#error_message#', htmlspecialchars( $error_message ), $html );
$html = str_replace( '#id#', htmlspecialchars( $id ), $html );

// 変換したhtmlを表示する
print( $html );