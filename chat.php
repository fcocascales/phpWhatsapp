<?php
	$path = isset($_REQUEST['path'])? strip_tags($_REQUEST['path']) : '';
	$reverse = isset($_REQUEST['reverse'])? boolval($_REQUEST['reverse']) : false;

	require_once "Whatsapp.php";
  $wa = new Whatsapp();
	$wa->setPath($path);
	$wa->setReverse($reverse);

?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title><?php echo $wa->getTitle(); ?></title>
  <link href="styles/styles.css" rel="stylesheet" />
  <link id="favicon" rel="shortcut icon" href="styles/favicon.png" type="image/png" />
</head>
<body>
  <h1><?php echo $wa->getTitle(); ?></h1>
  <?php echo $wa->asHTML(); ?>
</body>
</html>
