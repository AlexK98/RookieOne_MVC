<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>MVC | <?php if(isset($title)) {echo $title;} ?></title>
	<link href="public/styles/normalize.css" rel="stylesheet" type="text/css"/>
	<link href="public/styles/rookie.css" rel="stylesheet" type="text/css"/>
	<script src="public/scripts/rookie.js" type="text/javascript"></script>
</head>
<body>
	<header class="header block">
		<?php if(isset($header)) {echo $header;}?>
	</header>
	<main>
		<?php if(isset($main)) {echo $main;}?>
	</main>
	<footer>
		<?php if(isset($footer)) {echo $footer;}?>
	</footer>
</body>
</html>