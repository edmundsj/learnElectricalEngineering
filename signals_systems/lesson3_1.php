<?php

echo'<html>';
include $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/head.php";
beginPage();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/header_menu.php";
beginWrapper();
?>

<!-- Main content goes here -->
<h1>Signals and Systems Part 3: Fourier Transform</h1>
<span class="image main"><img src="/images/pic13.jpg" alt="" /></span>
<h1>Lesson 1: Stretching the Period of Periodic Signals</h1>
<?php
addLessonNavigationE("lesson2_8.php", "lesson2_10.php", "syllabus.php", "Fourier Series", "Next", "Syllabus");
?>
<h2>The trick to deal with aperiodic signals</h2>
<p>
So far we have been dealing with signals which are <i>periodic</i> - they repeat themselves in time. We used the Fourier Series to represent these signals as an infinite sum of complex exponentials. That's all fine and good for when we meet periodic signals in the wild, but most signals aren't periodic! How do we deal with those? Let's be concrete. Let's say that we want to represent a rectangular pulse using the Fourier Series. This rectangular pulse, to be exact:
This would be great, because complex exponentials make it spectacularly easy to deal with linear systems. But th
</p>
<?php
$counter = 0;
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
