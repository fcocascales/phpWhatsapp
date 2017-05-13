<?php

  require_once "UploadZip.php";

  $action = empty($_GET['action'])? '' : $_GET['action'];
  $id = empty($_GET['id'])? 0 : $_GET['id'];
  if ($action == 'delete' && !empty($id)) {
    UploadZip::delete($id);
  }

  $list = UploadZip::list();

?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Whatsapp</title>
	<style media="screen">
		body { background-color:#ddd; margin:0 2em; }
		textarea { width:100%; height:20em; }
    form p { margin:0.5em 0; }
    .delete { color:#933; font-size:0.8em; margin-left:1em; }
    button { font-weight:bold; padding:0.5em 2em; }
	</style>
</head>
<body>
	<h1>Whatsapp</h1>

  <?php if (!empty($list)): ?>
  <h2>Recently uploaded chats list</h2>
  <ul>
    <?php
      foreach($list as $id=>$params) {
        extract($params); // path, reverse, title
        echo "<li>\n";
        echo "<a href=\"chat.php?path=$path&reverse=$reverse\">$title</a>\n";
        echo "<a href=\"?action=delete&id=$id\" class=\"delete\">delete</a>\n";
        echo "</li>\n";
      }
    ?>
  </ul>
  <?php endif; ?>

  <h2>Upload a zipped chat</h2>
  <form
		action="uploaded.php"
		method="post"
		enctype="multipart/form-data">
    <input type="hidden" name="nose" value="quepasa">
		<p><input type="file" name="zip" id="zip"></p>
		<p><label><input type="checkbox" name="reverse" value="1">Reverse</label></p>
		<p><button>Upload</button></p>
	</form>

</body>
</html>
