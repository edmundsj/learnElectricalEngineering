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
<h1>Syllabus</h1>
<?php
addLessonNavigation("/signals_systems.php", "sinewaves_lesson1.php", "Introduction", "Sinewaves");
?>
<h2>Part 1: Sinewaves and Linear Time-Invariant Systems</h2>
<ol>
<li><a href="sinewaves_lesson1.php">Playing with Sinewaves</a></li>
<li><a href="shifting_scaling_lesson2.php">Shifting and Scaling</a></li>
<li><a href="pendulum_lesson3.php">The Linear Pendulum system</a></li>
<li><a href="linearity_lesson4.php">Linearity</a></li>
<li>Time-Invariance</li>
<li>Other fun signals: Square Waves, Triangle Waves, Unit Steps</li>
<li>The Complex Exponential</li>
<li>RC Circuits (or why we love complex numbers)</li>
<li>The complex exponential as an Eigenfunction</li>
</ol>
<h2>Part 2: Fourier Series Representation</h2>
<ol>
<li><a href="lesson2_1.php">The Inner Product (or how many peas are in my soup?)</a></li>
<li><a href="lesson2_2.php">Orthogonal Functions</a></li>
<li><a href="lesson2_3.php">Decomposing Periodic Signals</a></li>
<li><a href="lesson2_4.php">Signal Energy and Average Power</a></li>
<li><a href="lesson2_5.php">The (Sine) Fourier Series</a></li>
<li><a href="lesson2_6.php">Even and Odd Signals</a></li>
<li><a href="lesson2_7.php">The Cosine Fourier Series</a></li>
<li><a href="lesson2_8.php">Dealing with Offsets</a></li>
<li><a href="lesson2_9.php">The Sine/Cosine Fourier Series</a></li>
<li><a href="lesson2_10.php">The Complex Fourier Series</a></li>
<li><a href="lesson2_11.php">Fourier Series with Time Instead of x</a></li>
</ol>
<h2>Part 3: The Fourier Transform and its Applications</h2>
<ol>
<li>Stretching the Period</li>
<li>The limit as the period becomes infinite</li>
<li>Examples of the Fourier Transform</li>
<li>Filtering</li>
<li>The Transfer function
<li>The RC circuit and its cousins: First-order systems</li>
<li>The RLC circuit and its cousins: Second-order systems</li>
<li>Modulation and frequency-shifting</li>
</ol>
<h2>Part 4: Time-Domain Analysis of Systems</h2>
<ol>
<li>The Impulse 'Function'</li>
<li>The Impulse Response</li>
<li>The transfer function and the impulse response</li>
<li>Response to A bunch of impulses: Convolution</li>
<li>Response to a continuous function</li>
<li>The convolution integral</li>
<li>The convolution integral and the Fourier Transform</li>
</ol>
<h2>Part 5: The Laplace Transform</h2>
<ol>
<li>When does the Fourier Transform not exist? Stability</li>
<li>The Laplace Transform</li>
<li>The Laplace Transform graphically</li>
<li>When to use the Laplace Transform</li>
<li>Region of Convergence</li>
<li>The inverse Laplace Transform</li>
</ol>

<h2>Additional Things to cover I haven't added yet</h2>
<ul>
<li>Causality</li>
<li>Stability</li>
<li>Fourier Series Convergence</li>
<li>Parseval's Theorem</li>
<li>Properties of the Fourier series (teach by example)</li>
<li>Properties of the Fourier Transform</li>
<li>Replacing the derivative with \(j\omega\)</li>
<li>Unilateral vs. bilateral Laplace transform</li>
</ul>
Some stuff
</p>
<h2>Planned For</h2>
<ol>
<li>Power</li>
<li>Inner products</li>
</ul>

<?php
$counter = 0;
$counter = appendToQuiz($counter, 'A quiz question',
	array('A quiz option'), 0);
?>
<?php
addLessonNavigation("/signals_systems.php", "sinewaves_lesson1.php", "Introduction", "Sinewaves");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
