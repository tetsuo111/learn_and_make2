<!DOCTYPE html>
<html>
<head>
  <meta name="name" http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>アンケート</title>
</head>
<body>
<?php
//日付チェック関数の作成1
//引数の値を全角から半角に変換し、日付として正しいものかどうかチェックする
  function get_checked_date($date){
    //全角から半角へ変換
    $checked_date = mb_convert_kana($date , 'a' , 'UTF-8');
    //[/]で分割　右から左の変数に入れていく
    list($year , $month , $day) = explode('/' , $checked_date);
    //日付チェック
    if(!checkdate($month ,$day , $year)){
      //現在の日付　
      $checked_date = date('Y/m/d');
    }
    return $checked_date;
  }
  $sdate = get_checked_date($_POST['sdate']);
  $edate = get_checked_date($_POST['edate']);
  $sort = htmlspecialchars($_POST['sort'] , ENT_QUOTES);


?>
アンケート結果
<br>
<table border="1">
<tr bgcolor = "#CCCCCC">
  <td> ID</td>
<td>購入日</td>
<td>評価</td>
<td>本書の評価</td>
<td>PHP</td>
<td>Perl</td>
<td>Java</td>
<td>C#</td>
<td>C++</td>
<td>Basic</td>
<td>職業</td>
  <td>登録日</td>
</tr>

<?php

/*
  //ファイル名
$filename = 'uploads/question.csv';

//ロケール設定　1　
setlocale(LC_ALL, 'ja_JP ' );

//readモードで開く　2　
$handle = fopen($filename , 'r');

//CSVデータを取り出す３　データを読み取り、配列として取り出す関数
while($data = fgetcsv($handle , 1000)){
  //一行分のデータを取り出す　４
 list($pdate , $pprice , $star , $lang[0] , $lang[1] , $lang[2] , $lang[3] , $lang[4] , $lang[5] , $job) = $data;



  //一行分のデータを表示５
  echo '<tr>';
  echo '<td>' . $pdate . '</td>';
  echo '<td>' . $pprice . '</td>';
  echo '<td>' . $star . '</td>';
  for($i = 0; $i < 6; $i++){
    if($lang[$i] !== ''){
      echo '<td align = "center">○</td>';
    
    }else{
      echo '<td align = "center">-</td>';
    }

  }
  echo '<td>' . $job . '</td>';
  echo '</tr>';

}
  //閉じる
  fclose($handle);

*/
//mysqlへの接続2
$conn = mysqli_connect('127.0.0.1' , 'root'  ,'root');

if($conn){
  //データベースの選択３
  mysqli_select_db($conn , 'sample_db');
  //文字化け対策
  mysqli_query($conn, 'SET NAMES utf8');
  //データベースへの問い合わせSQL文４
  $sql = 'SELECT question_id , purchase_date , purchase_price , star , lang_php , lang_perl  , lang_java , lang_cs , lang_cpp , lang_basic , job , entry_date 
  FROM question_tb 
  WHERE purchase_date >= "'.$sdate.'" AND purchase_date <= "'.$edate.'"';
 
$sql_avg = 'SELECT AVG(star) AS average FROM question_tb';

  //ソート５ 
  if($sort === 'date'){
    $sql = $sql .'ORDER BY purchase_date';
  }else if ($sort === 'sort'){
    $sql = $sql . 'ORDER BY star';
  }else{
    $sql = $sql . 'ORDER BY entry_date';
  }

  //SQL文の実行６
  $query = mysqli_query($conn , $sql) or die("接続エラー");
  $avg_query = mysqli_query($conn , $sql_avg);
  //データの取り出し７
  while($row = mysqli_fetch_object($query)){
    echo '<tr>';
    echo '<td>' . $row->question_id . '</td>';
    echo '<td>' . $row->purchase_date . '</td>';
    echo '<td>' . $row->purchase_price . '</td>' ;
    echo '<td>' . $row->star . '</td>';
    echo '<td>' . $row->lang_php . '</td>';
    echo '<td>' . $row->lang_perl .'</td>' ;
    echo '<td>'  .$row->lang_java . '</td>' ;
    echo '<td>' . $row->lang_cs .'</td>' ;
    echo '<td>' .$row->lang_cpp. '</td>';
    echo '<td>' .$row->lang_basic.'</td>' ;
    echo '<td>' .$row->job.'</td> ';
    echo '<td>' . $row->entry_date. '</td>';
    echo '</td>';
  }
}

?>
</table>
<?php 
  $sql_avg = 'SELECT AVG(star) AS average FROM question_tb';
  $query_avg = mysqli_query($conn , $sql_avg);
  $row_avg = mysqli_fetch_object($query_avg);
  echo '評価平均';
  echo $row_avg->average;
?>



</body>
</html>