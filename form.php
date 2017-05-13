<?php

	//$date = date('d/m/Y');
	$dt = new DateTime();
	$date = $dt->format('d/m/Y');
	$chat =
		$date.", 17:20 - Songoku: Lorem ipsum\n".
		$date.", 17:28 - Bulma: Sed do eiusmod\n".
		$date.", 17:22 - Songoku: Consectetur adipisicing elit\n".
		$date.", 17:29 - Songoku: Ut enim ad minim veniam.\n".
		$date.", 17:41 - Songoku: Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat\n";

	$dt->modify('+1 day');
	$date = $dt->format('d/m/Y');
	$chat .=
		$date.", 20:12 - Bulma: Duis aute irure dolor in reprehenderit in voluptate\n".
		$date.", 20:13 - Bulma: Velit esse cillum dolore eu fugiat nulla pariatur\n".
		$date.", 20:14 - Songoku: Excepteur sint occaecat cupidatat\n".
		$date.", 20:15 - Bulma: Non proident\n".
		$date.", 20:16 - Songoku: Sunt in culpa qui officia deserunt mollit anim id est laborum\n".
		$date.", 20:17 - Bulma: Tempor\n";

	$dt->modify('+1 day');
	$date = $dt->format('d/m/Y');
	$chat .=
		$date.", 16:51 - Bulma: Incididunt ut labore et dolore magna aliqua\n".
		$date.", 17:33 - Bulma: Dolor sit amet\n".
		$date.", 17:33 - Songoku: Minim veniam\n".
		$date.", 14:32 - Bulma: Ullamco laboris nisi ut aliquip\n";

?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Whatsapp</title>
	<style media="screen">
		body { background-color:#ddd; margin:0 2em; }
		textarea { width:100%; height:20em; }
		button { font-weight:bold; padding:0.5em 2em; }
	</style>
</head>
<body>
	<h1>Whatsapp</h1>
	<h2>Submit a chat</h2>
	<form action="submit.php" method="post">
		<p>
			<label for="chat">Chat</label><br>
			<textarea name="chat" id="chat" spellcheck="false" autofocus="on"><?php echo $chat ?></textarea>
		</p>
		<p>
			<label><input type="checkbox" name="reverse" value="1">Reverse</label>
		</p>
		<p>
			<button>Submit</button>
		</p>
	</form>
</body>
</html>
