<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset = utf-8">
<title>画像一覧</title>
</head>
<body>
  <?php 
  //保存先のディレクトリ
  $dir = 'uploads/';
  $dir_s = 'uploads/s/';

  //ディレクトリ内のファイルを取り出す
  $files = scandir($dir_s);

  //ファイル数を取り出す
  $count = count($files);

  ?>
画像一覧
<br>
<table border = 0>
<?php
  //1 列の位置　
  $col = 0;
  //ファイルの取り出し
  for($i = 0; $i < $count; $i++){
    //ファイル情報を取り出す　パス情報を返す　
    $file = pathinfo($files[$i]);
    //ファイル名
    $file_name = $file['basename'];
    //ファイル拡張子
    $file_ext = $file['extension'];

    //JPEG形式のファイルを表示する
    if($file_ext === 'jpg' || ($file_ext === 'gif')){
      //2 列の加算
      $col++;
      //先頭ならばTRタグ開始
      if($col === 1) echo '<tr valign = "top">';
      
      //TDタグ開始
      echo '<td bgcolor = #EEEEEE>';
      //ファイル名の表示
      echo $file_name;
      echo '<br>';

      //リンク、画像の表示
      echo '<a href = "'.$dir.  $file_name .'" target = "_blank"><img src = "'.$dir_s.$file_name . '" </a>';

      //TDタグ終わり
      echo '</td>';

      //3 五列目ならばTRタグ終わり、列位置を0に戻す
      if($col === 5){
        echo '</tr>';
        $col = 0;
      }
    }
}

//4 列の残りを埋める
  if($col > 0){
    echo '<td colspan = "' . (5 - $col) . '" bgcolor = "#CCCCCC"></td></tr>'; 
  }

?>

</table>
  <a href="upload.html">トップへ戻る</a>
</body>
</html>