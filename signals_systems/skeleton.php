<?php

echo'<html>';
include $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/head.php";
beginPage();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/header_menu.php";
beginWrapper();
?>

<!-- Main content goes here -->
<h1>Signals and Systems Part 2: Fourier Series</h1>
<span class="image main"><img src="/images/pic13.jpg" alt="" /></span>
<h1>Lesson X: </h1>
<?php
addLessonNavigationE("lesson2_8.php", "lesson2_10.php", "syllabus.php", "Fourier Series", "Next", "Syllabus");
?>
<h2>What about time?</h2>
<p>
<?php
$counter = appendToQuiz($counter, 'What is the coefficient \(a_0\) and the signal offset?',
    array('\(a_0 = 4, offset=2\)', '\(a_0 = 2, offset = 1\)', '\(a_0 = 1, offset=2\)'), 1);
?>
<?php
addLessonNavigationE("lesson2_8.php", "lesson2_10.php", "syllabus.php", "Fourier Series", "Next", "Syllabus");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
