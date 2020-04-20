<?php

echo'<html>';
include $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/head.php";
beginPage();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/header_menu.php";
beginWrapper();
?>

<!-- Main content goes here -->
<h1>Lesson 1: Sinewaves</h1>
<span class="image main"><img src="/images/pic13.jpg" alt="" /></span>

<?php
addLessonNavigation("/signals_systems", "lesson2");
?>

<p>
Some text goes here.
</p>


<?php
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
