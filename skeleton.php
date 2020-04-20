<?php

echo'<html>';
include $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/head.php";
beginPage();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/header_menu.php";
?>

<!-- Main content goes here -->
<div id="main">
	<div class="inner">
		<h1>Generic Page</h1>
		<span class="image main"><img src="images/pic13.jpg" alt="" /></span>
		<p>Some text goes here</p>
	</div>
</div>

<?php
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage()
?>
