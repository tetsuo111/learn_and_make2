<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content = "text/html; charset = utf8" >
  <title>お問い合わせフォーム</title>
</head>
<body>
<?php
//お問い合わせタイトル、詳細のセット
$title     = htmlspecialchars($_POST['title'], ENT_QUOTES);
$message   = htmlspecialchars($_POST['message'], ENT_QUOTES);
$your_name = htmlspecialchars($_POST['your_name'], ENT_QUOTES);
?>

お問い合わせ内容を確認してください
<br>
<br>
<form action = "send_inquiry.php" method = "post">
<input type = "hidden" name = "title" value = "<?php echo $title;?>">
<input type = "hidden" name = "message" value = "<?php echo $message;?>">
<input type = "hidden" name = "your_name" value = "<?php echo $your_name;?>">
お問い合わせ名
<br>
<?php echo $your_name;?>
<br>
お問い合わせタイトル;
<br>
<?php echo $title;?>
<br>
  お問い合わせ内容詳細:
<br>
<?php
//改行部分にBRタグを埋め込む
echo nl2br($message);

?>
<br>
<br>
<input type = "submit" value = "お問い合わせ内容の送信">
</form>
</body>
</html>