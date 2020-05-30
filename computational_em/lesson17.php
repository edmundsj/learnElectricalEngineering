<?php

echo'<html>';
include $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/head.php";
beginPage();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/header_menu.php";
beginWrapper();
?>

<!-- Main content goes here -->
<h1>Computational Electromagnetics with MEEP</h1>
<span class="image main"><img src="/images/pic13.jpg" alt="" /></span>
<h1>Lesson 17: Dielectric Mirrors</h1>
<?php
addLessonNavigation("/computational_em.php", "computational_em_lesson1.php", "Introduction", "Next");
?>
<h2>The topic</h2>
<p>
The <a href="https://en.wikipedia.org/wiki/Distributed_Bragg_reflector">dielectric mirror</a> (also known as the Bragg Mirror, or Bragg Reflector, or Distributed Bragg Reflector), is an awesome idea. Loosely speaking, it says if one film can give us constructive interference, can more films give us better constructive interference? Let's set up the simulation. We're going to want it to look something like this:
<?php addMobileImageFull('computational_em/DBR_simulation.svg'); ?>
</p>
<p>
Where I have shown three pairs of material alternating between high index (shown in orange), and low index (shown in blue). To make things easy on ourselves, let's say the blue regions have an index of 1 and the orange regions have an index of 2. Each individual layer is a quarter-wavelength long, and just to keep things simple let's stay with the dimensions of the <a href="lesson16.php">previous lesson</a>, so that we want our high-index film to have a thickness of 0.125 and the low-index film to have a thickness of 0.25 (MEEP units, as usual).
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
