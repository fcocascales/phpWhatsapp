<?php

	try {
		require_once "UploadZip.php";
		$uz = new UploadZip();
		$uz->upload();
		$path = $uz->getPath();
		$reverse = $uz->getReverse();
		//require_once "Whatsapp.php";
	  //$wa = new Whatsapp();
		//$wa->setPath($path);
		//$wa->setReverse($reverse);
		require_once "submit_post.php";
		$html = submit_post(get_url('chat.php'), array('path'=>$path, 'reverse'=>$reverse));
		echo $html;
		exit();
	}
	catch (Exception $ex) {
		$message = $ex->getMessage();
	}

?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Whatsapp</title>
  <link href="styles/styles.css" rel="stylesheet" />
	<style media="screen">
		.error { color:#c00; }
	</style>
</head>
<body>
	<?php
		if (!empty($message)):
			echo "<h1>Uploaded Whatsapp</h1>";
			echo "<p class=\"error\">".htmlspecialchars($message)."</p>";
		else:
			/*echo "<h1>".$wa->getTitle()."</h1>";
			echo $wa->asHTML();
			/*echo '<form id="autoform" action="chat.php" method="submit">';
			echo '<input type="hidden" name="path" value="'.$path.'">';
			echo '<input type="hidden" name="reverse" value="'.$reverse.'">';
			echo '</form>';
			echo '<script>document.getElementById("autoform").submit();</script>';*/
		endif;
	?>
</body>
</html>
