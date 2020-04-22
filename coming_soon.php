<?php

echo'<html>';
include $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/head.php";
beginPage();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/header_menu.php";
beginWrapper();
?>

<!-- Main content goes here -->
<h1>This Content is Coming Soon</h1>
<span class="image main"><img src="images/pic13.jpg" alt="" /></span>
<p>I'm currently working on this content. Come back in a few weeks to see if I have made any progress :)p. Or, if you're interested in helping, shoot me an email with the contact form below.</p>

<?php
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
