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
<h1>Lesson 2: Dealing with Units in MEEP</h1>
<?php
addLessonNavigation("/lesson1.php", "lesson3.php", "Getting Started", "Hello World");
?>
<h2>MEEP Length vs. SI Length</h2>
<p>
Phycisists like to be clever. While this is great for the physicsts, it can be endlessly annoying for the student or engineer trying to parse their cleverness. One clever thing the designers behind MEEP did was refuse to enforce a length scale, leaving that up to the user. Are you entering your length in terms of microns? Millimeters? Yards? Football fields? MEEP doesn't care. This is pretty nice once you get a feel for it, and it's ubiquitous in the field of photonics. Buuut it's pretty annoying if you've never seen it before.
</p>

<p>
So, what does this actually mean in terms of using the software? It means, before you do <i>anything</i>, you must choose your <i>characteristic length</i>, \(a\). This can be a unit, like \(\mu m\), or it can be a convenient length, like the side length of a device, or the thickness of a thin film. You will then enter all the distances in terms of this characteristic length (don't worry, we'll go through examples). In math speak, if \(x\) is a particular length you are interested in entering, and \(x_{MEEP}\) is the length you actually type into the software, then:
</p>
<p>
\(x_{MEEP} = \frac{x}{a} \)<br><br>
Let's try a couple of examples. 
</p>

<?php
$counter = 0;
$counter = appendToQuiz($counter, 'Say you choose your characteristic length \(a\) to be 1 \(\mu m\). Your device dimensions are \(10 \mu m\) by \(3.5 \mu m\). What dimensions would you enter into MEEP?',
	array('\(10\) by \(3.5\)', '\(0.1\) by \(2.86\)', '\(1\) by \(0.35\)'), 0);

$counter = appendToQuiz($counter, 'You have a device that measures 0.57 mm by 1.14 mm by 2.28 mm. What is the characteristic length \(a\) that makes the lengths you enter into MEEP 1, 2, and 4?',
	array('\(1\mu m\)', '\(1.14 \mu m\)', '\(0.57mm\)'), 2);
?>

<h2>Time, Frequency in MEEP</h2>
<p>
MEEP does another clever thing, also common in photonics in particular and physics more broadly, and that's to set the speed of light \(c=1\). Or, if you're an engineer and that makes you feel uncomfortable (it makes me queasy), you can instead think of creating a new variable (let's call it \(t_{MEEP}\) which is just regular time multiplied by \(c/a)\) to make it unitless. It just becomes <i>normalized</i> time. In math, that just means that the time displayed by MEEP \(t_{MEEP}\) in terms of the time \(t\) in seconds and the characteristic length \(a\) is just:
</p>
<p>
\(t_{MEEP} = t * \frac{c}{a} \)
</p>
<p>
Since time is multiplied by \(c/a\), anything with units of frequency better get multiplied by \(a/c\), and so the frequency we enter into meep \(f_{MEEP}\) in terms of the actual frequency \(f\) (in Hz) is:
</p>
<p>
\( f_{MEEP} = f * \frac{a}{c} = \frac{a}{\lambda_0}\)
</p>
This actually makes entering frequency extremely convenient (at least if you are comfortable using wavelength, denoted here as \(\lambda_0\), the 0 just means free space), because the frequency we enter is just our characteristic length \(a\) divided by the free-space wavelength. OK, let's do a couple examples to get the hang of it.
<?php

$counter = appendToQuiz($counter, 'Suppose you want to simulate a plane wave in free space of frequency 150THz, and your characteristic length a is 1 micron. What frequency would you enter in MEEP?',
	array('\(1.5\)', '\(0.5\)', '\(1\)', '\(2\)'), 1);

$counter = appendToQuiz($counter, 'Suppose that MEEP tells you the time is 4 units, and you know the characteristic length is 3mm. What is the time in seconds?',
	array('\(40 ps\)', '\(4 ms\)', '\(40 fs\)', '\(3 s\)'), 0);
?>
<h2>Summary</h2>
<p>MEEP uses unitless quantities for length, time, and frequency, and these are summarized by the following three equations, where \(c\) is the speed of light, \(a\) is your chosen characteristic length, \(x\) is the physical distance, \(t\) is the physical time, \(f\) is the physical frequency, and \(\lambda_0\) is the wavelength in free space:
</p>
<p>
\(x_{MEEP} = \frac{x}{a} \)<br><br>
\(t_{MEEP} = t * \frac{c}{a} \)<br><br>
\( f_{MEEP} = f * \frac{a}{c} = \frac{a}{\lambda_0}\)

</p>

<?php
addLessonNavigation("/lesson1.php", "lesson3.php", "Getting Started", "Hello World");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
