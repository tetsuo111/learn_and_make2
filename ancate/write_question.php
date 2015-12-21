<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content = "text/html; charset = UTF-8">
  <title>アンケート</title>
</head>
<?php
//購入日
$pdate = htmlspecialchars($_POST['pdate'], ENT_QUOTES);
//平均購入額
$pprice = htmlspecialchars($_POST['pprice'], ENT_QUOTES);
//評価
$star = htmlspecialchars($_POST['star'], ENT_QUOTES);
$ver  = array();
//興味のある言語　一　1,0に変換
for ($i = 0; $i < 7; $i++) {
    /*
    古い方　
		$lang[$i] = isset($_POST['lang'][$i]) ? htmlspecialchars($_POST['lang'][$i], ENT_QUOTES):null;
    $ver = $lang[$i];
    */    
      //$lang[$i] = $_POST['lang'][$i]　=== '' ? 0 : 1;
    $lang[$i] = isset($_POST['lang'][$i]) ? 0 : 1;
}



//職業
$job = htmlspecialchars($_POST['job'], ENT_QUOTES);

//日付チェック　１
//全角から半角へ変換
$pdate = mb_convert_kana($pdate, 'a', 'utf-8');
// / で分割
list($year, $month, $day) = explode('/', $pdate);
//日付チェック
if (!checkdate($month, $day, $year)) {$pdate = '';
}

//数値チェック
//全角から半角へ変換
$pprice = mb_convert_kana($pprice, 'a', 'utf-8');
//数値チェック
if (!is_numeric($pprice)) {
  $pprice = '';
}
/*
//保存データ 2
//ここの部分の配列はなんとかしないとダメ

	$data = array($pdate, $pprice, $star, $lang[0], $lang[1], $lang[2], $lang[3], $lang[4], $lang[5], $job);

//保存ファイル名 3
//別のディレクトリにある時は不可能
$filename = 'uploads/question.csv';

パスを調べる
$path     = dirname($filename);

$dir = new DirectoryIterator($path);
foreach ($dir as $file) {
	echo $file->getPathname(), PHP_EOL;
}


//appendモードで開く　4
$handle = fopen($filename, 'a');

//排他的ロック 5
flock($handle, LOCK_EX);

//CSV書き込み 6
fputcsv($handle, $data);

//閉じる 7
fclose($handle);
*/
//Mysqlへの接続
$conn = mysqli_connect('127.0.0.1' , 'root' , 'root');

if($conn){
  //データベースの選択
  mysqli_select_db($conn ,'sample_db');
  //文字化け対策
  mysqli_query($conn , 'SET NAMES utf8' );
  //データベースへの書き込みSQL文
 $sql = 'INSERT INTO question_tb(purchase_date,purchase_price,star,lang_php,lang_perl , lang_java , lang_cs , lang_cpp , lang_basic,job)
    VALUES ("' . $pdate . '",' . $pprice. ',' . $star . ',' .$lang[0] . ',' .$lang[1] . ',' .$lang[2] . ',' . $lang[3] . ',' . $lang[4] . ',' . $lang[5] . ',"' . $job . '")';

//SQL文の実行 5
$query = mysqli_query($conn , $sql);
}


?>
<body>
アンケートを登録しました
<br>
<br>
  <a href="query_question.php">アンケート結果</a>

</body>
</html>