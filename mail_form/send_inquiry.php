<html>
<head>
<meta http-equiv="Conten-Type" content = "text/html; charset= utf8">
  <title>お問い合わせフォーム</title>
</head>
<body>
<?php
//お問い合わせタイトル、詳細のセット
$title     = htmlspecialchars($_POST['title'], ENT_QUOTES);
$message   = htmlspecialchars($_POST['message'], ENT_QUOTES);
$your_name = htmlspecialchars($_POST['your_name'], ENT_QUOTES);

//日本語の指定
mb_language('ja');
mb_internal_encoding('UTF-8');

//Fromアドレスの設定（自動送信<送信元のアドレス>)
$name    = '自動送信';
$email   = 'tetsuochikazawa11@gmail.com';
$header  = 'From: '.mb_encode_mimeheader($name).'<'.$email.'>';
$message = $message."\n[".$your_name."]";

//メール送信
$result = mb_send_mail("tetsuochikazawa11@gmail.com", $title, $message, $header);

//メール送信の確認
if ($result) {
	//メール送信の成功
	echo 'お問い合わせ内容を担当者へ送信しました。';
} else {
	//メール送信の失敗
	echo '担当者への送信に失敗しました';
}

?>
</body>
</html>