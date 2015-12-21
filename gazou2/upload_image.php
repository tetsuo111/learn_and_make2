<!DOCTYPE html>
<html>
<!--
$_FILES['パラメータ名']['キー']
name 送信されたファイル名
type 送信されたファイル名MIMEタイプ
tmp_name サーバーに一時的に保存されたファイル名


一時ファイルの保存先から保存先へ移動する
move_uploaded_file(一時ファイル、保存先のファイル名)





-->

<head>
<meta http-equiv="Content-Type" content = "text/html; charset = utf-8">
  <title>画像ファイルアップロード</title>
</head>
<body>
<?php
//ファイル名の取り出し
$file_name = $_FILES['filename']['name'];
//ファイルタイプの取り出し
$file_type = $_FILES['filename']['type'];
//一時ファイル名の取り出し
$temp_name = $_FILES['filename']['tmp_name'];

//保存先のディレクトリ
$dir = 'uploads/';
//保存先のファイル名
$upload_name = $dir.$file_name;
//サムネイル画像の保存先のディレクトリ
$dir_s = 'uploads/s/';
//サムネイル画像の保存先のファイル名
$upload_name_s = $dir_s.$file_name;

//JPEG形式のファイルをアップロードする
if (($file_type === 'image/jpeg') || ($file_type === 'image/pjpeg' || ($file_type === 'image/gif'))) {
	//アップロード(移動)
	$result = move_uploaded_file($temp_name, $upload_name);

	if ($result) {
		//アップロードの成功
		echo 'アップロード成功';
		//アップロードされた画像情報を取り出す
		$image_size = getimagesize($upload_name);
		//アップロードされた画像の幅と高さを取り出す
		$width  = $image_size[0];
		$height = $image_size[1];

		/*サムネイル用の画像処理    */
		//サムネイル画像の幅と高さを決める
		$width_s  = 120;
		$height_s = round($width_s*$height/$width);

    if($file_type === 'image/gif'){
      //GIF形式
      $image = imagecreatefromgif($upload_name);
    }else{
		//アップロードされた画像を取り出す
		$image = imagecreatefromjpeg($upload_name);
    }
		//サムネイルの大きさの画像を新規作成
		$image_s = imagecreatetruecolor($width_s, $height_s);

		//アップロードされた画像からサムネイル画像を作成
    //画像を再サンプリングしてコピーする
		$result_s = imagecopyresampled($image_s, $image, 0, 0, 0, 0, $width_s, $height_s, $width, $height);

		if ($result_s || $file_type === 'image/gif') {
      //gif形式
			//サムネイル画像作成成功
			//サムネイル画像の保存
      //JPEG形式の画像を保存する関数
			if (imagejpeg($image_s, $upload_name_s) || imagegif($image_s , $upload_name_s)) {
				echo '->サムネイル画像保存';
			} else {
				echo '->サムネイル画像保存失敗';
			}
		} else {
      if(imagejpeg($image_s , $upload_name_s)){
      //JPEG形式
        echo '->サムネイル画像保存';
        }else{
			//サムネイル画像作成失敗
			echo '->サムネイル画像作成失敗';
    }
	}
		//画像の破棄
    //メモリーを解放
		imagedestroy($image);
		imagedestroy($image_s);

	} else {
		//アップロード失敗
		echo 'アップロード失敗';
	}
} else {
	//JPEG形式以外のファイルはアップロードしない
	echo 'JPEG形式の画像をアップロードしてください。';
}

?>
<br>
<br>
画像ファイル:<?php
if (isset($width) || isset($height)) {
	echo $upload_name.'('.$width.'X'.$height.')';
} else {
  echo "error\n";
	echo "ファイルが入ってません。ファイルをアップロードしてください";
}

?>
<br>
<img src="<?php echo $upload_name;?>" >
<br>
<br>
サムネイル:<?php
if(isset($width_s) || isset($height_s)){
  echo $upload_name_s.'('.$width_s.'X'.$height_s.')';
}else{
  echo "error\n";
  echo "ファイルをアップロードしてください";
}
 ?>
<br>
<img src = "<?php echo $upload_name_s;?>">
<br>  
<a href = "show_image.php">一覧へ移動</a>


</body>
</html>