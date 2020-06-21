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
<ol>
<li><a href="lesson3_1.php">MEEP in Two Dimensions: Propagation</a></li>
<li><a href="lesson3_2.php">Gaussian Beam Propagation</a></li>
<li>Gaussian Beam Focusing</li>
<li>Gaussian Beam Thin-Film Interference</li>
<li>Modes in a Slab Waveguide</li>
<li>Coupling Gaussian Beams into Slab Waveguide</li>
<li>Modes in a Slab Waveguide Resonator (Longitudinal and Transverse)</li>
<li>Coupling Gaussian Beams into Slab Resonator</li>
<li>Radiation Leaking from a Resonator</li>
<li>Scattering (Diffraction) off an Infinite Cylinder</li>
<li>Diffraction Gratings</li>
</ol>

<h2>Part 4: MEEP in Three Dimensions</h2>
<ol>
<li>Point Source in Free Space (dipole antenna)</li>
<li>Line Source in Free Space</li>
<li>Sheet Source (plane wave) in Free Space</li>
<li>Free Space Gaussian Beam Propagation</li>
<li>Cylindrical Waveguide Modes</li>
<li>Cylindrical Waveguide Modes using MEEP Symmetry</li>
<li>Coupling a Gaussian Beam into a Cylindrical Waveguide</li>
<li>3D Cylindrical Resonator Modes</li>
<li>Coupling a Gaussian Beam into a Cylindrical Resonator</li>
<li>Rectangular Resonator Modes</li>
<li>Coupling a Gaussian Beam into a Rectangular Resonator</li>
<li>Rectangular Resonator Modes with Dispersive Materials</li>
<li>Rectangular Resonator Modes with Lossy Materials</li>
<li>Rectangular Resonator Modes with Contacts</li>
<li>Mie Scattering off a Sphere</li>
<li>Plasmonics - Mie Scattering off a Metal Sphere</li>
</ol>
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
