<?php

echo'<html>';
include $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/head.php";
beginPage();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/header_menu.php";
beginWrapper();
?>

<!-- Main content goes here -->
<h1>Computational Electromagnetics with MEEP: 2D MEEP</h1>
<span class="image main"><img src="/images/pic13.jpg" alt="" /></span>
<h1>Lesson 2: Gaussian Beam Propagation</h1>
<?php
addLessonNavigationE("lesson3_1.php", "lesson3_3.php", "syllabus.php", "2D MEEP", "Next", "Outline");
?>
<h2>But I thought we already used Gaussian beams</h2>
<p>
No, not <a href="https://en.wikipedia.org/wiki/Pulse_(signal_processing)#Gaussian_pulse">that</a> kind of Gaussian pulse, but <a href="https://en.wikipedia.org/wiki/Gaussian_beam">this</a> kind of Gaussian beam. We have been dealing with pulses that turn on and off like Gaussians, now we will deal with when the beam is <i>physically</i> shaped like a Gaussian. Why? Because Gaussian beams are easy to create in the lab, and are the most tractable type of radiation pattern to analyze. They are great starting points for coupling light into and out of finite devices. But most importantly for our purposes, there are closed-form equations that describe how these beams evolve.
</p>

<?php
$counter = 0;
$counter = appendToQuiz($counter, 'A quiz question',
	array('A quiz option'), 0);
?>
<?php
addLessonNavigationE("lesson3_1.php", "lesson3_3.php", "syllabus.php", "2D MEEP", "Next", "Outline");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
