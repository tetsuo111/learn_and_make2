<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content = "html/text; charset = utf-8 " >
  <title>アンケート</title>
</head>
<?php
//購入日 1　とにかく送られてきたもののセキュリティ対策はすること
$pdate = htmlspecialchars($_POST['pdate'] , ENT_QUOTES);
//平均購入額
$pprice = htmlspecialchars($_POST['pprice'] , ENT_QUOTES);
//評価

$star = htmlspecialchars($_POST['star'] , ENT_QUOTES);
//興味のある言五　offset対策として配列を二個用意して配列二つに値が入っている時に
//表示するようにしている
$ver = array();
for($i = 0; $i < 6; $i++){
  if(isset($_POST['lang'][$i]) ){
    $lang[$i] = htmlspecialchars($_POST['lang'][$i] , ENT_QUOTES);
    $ver[$i] = $lang[$i];
  }
}

//職業
$job = htmlspecialchars($_POST['job'] , ENT_QUOTES);

?>
<body>
アンケートの内容を確認してください
<br>
この本の購入日を教えてください<br>
<?php
  //全角から半角へ変換 2
  $pdate = mb_convert_kana($pdate , 'a' , 'UTF-8');
  //「/」で分割 3
  list($year , $month , $day) = explode('/', $pdate);
  //日付チェック　4
  if(checkdate($month , $day , $year)){
    echo $pdate;
  }else{
    echo $pdate . '(日付に誤りがあります)';
  }

?>
<br><br>
1ヶ月あたりの書籍の平均購入額を教えてください<br>
<?php
/*
送信されたものは半角にしておくことが必要、大文字だと判定されないから


*/
  //全角から半角へ変換
  $pprice = mb_convert_kana($pprice , 'a' , 'UTF-8');
  //数値チェック　
  if(is_numeric($pprice)){
    echo $pprice . '円';
  }else{
    echo $pprice . '円(数値ではありません)';
  }
?>
<br><br>
本書の評価を教えてください。(五段階)<br>
<?php echo $star; ?>
<br><br>
興味のある言語を教えてください。(複数選択可)<br>
<?php
  for($i = 0; $i < 6; $i++){
    //チェックされているもののみ表示
    if(isset($lang[$i])  ) echo '['.$lang[$i].']';
  }

  ?>
<br><br>
あなたの職種を教えてください。<br>
<?php echo $job; ?>

<br><br>
<form action = "write_question.php" method = "POST">
<input type = "hidden" name = "pdate" value = "<?php echo $pdate; ?>">
<input type = "hidden" name = "pprice" value = "<?php echo $pprice; ?>">
<input type = "hidden" name = "star" value = "<?php echo $star; ?>">
<?php 
  for($i = 0; $i < 6; $i++){
    if(isset($lang[$i])) 
    echo '<input type = "hidden" name = "lang['.$i.']" value = "'.$lang[$i].'">';
  }

?>
<input type = "hidden" name = "job" value = "<?php echo $job; ?>">
<br><br>
<input type = "submit" value = "アンケートを送信する">


</form>
</body>
</html>