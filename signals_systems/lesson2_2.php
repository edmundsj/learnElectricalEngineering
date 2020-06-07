<?php

echo'<html>';
include $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/head.php";
beginPage();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/header_menu.php";
beginWrapper();
?>

<!-- Main content goes here -->
<h1>Signals and Systems</h1>
<span class="image main"><img src="/images/pic13.jpg" alt="" /></span>
<h1>Lesson X: </h1>
<?php
addLessonNavigation("/signals_systems.php", "shifting_scaling_lesson2.php", "Introduction", "Next");
?>
<h2>The topic</h2>
<p>
Some stuff
</p>

<?php
$counter = 0;
$counter = appendToQuiz($counter, 'A quiz question',
	array('A quiz option'), 0);
?>
<?php
addLessonNavigation("/signals_systems.php", "lesson2.php", "Introduction", "Next");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
