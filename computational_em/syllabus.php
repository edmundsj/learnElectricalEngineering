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
<h1>Syllabus and Course Outline</h1>
<?php
addLessonNavigationE("computational_em.php", "lesson1_1.php", "syllabus.php", "Introduction", "Getting Started", "Outline");
?>
<h2>Part 1: Getting Started with FDTD and MEEP</h2>
<ol>
<li><a href="lesson1_1.php">Getting Started</a>
<li><a href="lesson1_2.php">Dealing with Units in MEEP</a></li>
<li><a href="lesson1_3.php">(Extreme) Basics of FDTD</a></li>
<li><a href="lesson1_4.php">Hello World - First Program</a></li>
<li><a href="lesson1_5.php">Visualizing Fields with MEEP</a></li>
<li><a href="lesson1_6.php">Perfectly Matched Loayers (PMLs)</a></li>
</ol>
<h2>Part 2: MEEP In One Dimension</h2>
<ol>
<li><a href="lesson2_1.php">Reflection off an Interface</a></li>
<li><a href="lesson2_2.php">Transmitted Power through an interface</a></li>
<li><a href="lesson2_3.php">Convergence Testing with MEEP</a></li>
<li><a href="lesson2_4.php">Reflected Power from an Interface</a></li>
<li><a href="lesson2_5.php">Efficient Multi-Frequency Simulations in FDTD</a></li>
<li><a href="lesson2_6.php">Frequency-Dependent Reflection from Dispersive Materials</a></li>
<li><a href="lesson2_7.php">Angular-Dependent Reflection</a></li>
<li><a href="lesson2_8.php">Multi-Frequency Oblique Incidence Reflection</a></li>
<li><a href="lesson2_9.php">Efficient Multi-Frequency Multi-Angle FDTD Simulations</a></li>
<li><a href="lesson2_10.php">Thin film Interference</a></li>
<li><a href="lesson2_11.php">Distributed Bragg Reflectors</a></li>
<li><a href="lesson2_12.php">Resonators in MEEP</a></li>
</ol>
<h2>Part 3: MEEP in Two Dimensions</h2>
<li><a href="lesson3_1.php">MEEP in Two Dimensions: Propagation</a></li>
<li><a href="lesson3_2.php">Gaussian Beam Propagation</a></li>
<p>
Some stuff
</p>

<?php
addLessonNavigationE("computational_em.php", "lesson1_1.php", "syllabus.php", "Introduction", "Getting Started", "Outline");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
