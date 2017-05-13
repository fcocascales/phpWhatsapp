<?php
	$chat = isset($_POST['chat'])? $_POST['chat'] : '';
	$reverse = isset($_POST['reverse'])? boolval($_POST['reverse']) : false;

	require_once "Whatsapp.php";
  $wa = new Whatsapp();
	$wa->setChat($chat);
	$wa->setReverse($reverse);

?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Whatsapp</title>
  <link href="styles/styles.css" rel="stylesheet" />
</head>
<body>
  <h1>Whatsapp</h1>
  <?php echo $wa->asHTML(); ?>
</body>
</html>
