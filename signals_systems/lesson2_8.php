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
<h1>Lesson 8: What about Offsets? </h1>
<?php
addLessonNavigationE("lesson2_7.php", "lesson2_9.php", "syllabus.php", "Fourier Series", "Next", "Syllabus");
?>
<h2>Cosines of Zero Frequency</h2>
<p>
We saw that we can represent an odd square wave with a Sine Fourier Series, and an even square wave (just a shifted version) with the Cosine Fourier Series, but what if we add an <i>offset</i> to the signal? How do we handle that? Let's add an offset of 1 to the even square wave we were using in the last lesson:
<?php addMobileImageFull('signals_systems/square_wave_offset.svg');?>
</p>
<p>
How do we handle this offset? Well, we can think of an offset as a cosine of <i>zero frequency</i>. \(cos(0x)\) is just 1, regardless of what \(x\) is. So we can represent the offset with the term \(a_0*cos(0x)\), or the "zero harmonic" as it's sometimes called. If we are adding an offset of 1, we would expect this \(a_0\) term to be 1 - we know exactly how much offset is conained in our signal, but what is it if we use the definition?
</p>
\begin{equation}
a_0=\frac{2}{P}\langle 1 + sq_e(x), 1 \rangle = \frac{2}{2\pi}\int_{-\pi}^{\pi}1+sq_e(x)dx = 2
\end{equation}
<p>
Since the square wave itself integrates to 0, we only end up integrating the offset over our period, but the result is twice as large as expected! What gives? We know the offset is 1.
</p>
<h2>Energy Bites us in the Butt</h2>
<p>
The problem turns out to be that \(cos(0x)\) has twice as much <i>energy</i> as all the other cosines over a single period (\(2\pi\)) of our square wave: \(cos(1x), cos(2x)\) and so on all have an energy of \(\pi\), but \(cos(0x)\) has an energy of \(2\pi\). So if we want to deal with offsets, we can still use the cosine Fourier Series, but we have to remember to divide the \(a_0\) coefficient by 2. That's a little awkward, but it works.
</p>
<?php
$counter = 0;
$counter = appendToQuiz($counter, 'What would the coefficient \(a_0\) be if we multiplied the entire signal, \(1+sq_e(x)\), by 2?',
	array('\(a_0 =4\)', '\(a_0 =2\)', '\(a_0 = 1\)'), 0);
$counter = appendToQuiz($counter, 'What would the offset be if we multiplied the entire signal, \(1+sq_e(x)\), by 2?',
	array('\(4\)', '\(2\)', '\(1\)'), 1);
?>
<h2>Intuition behind the math</h2>
<p>
There's a mathy way to calculate the offset, but what does it actually <i>mean</i>? Well, it's just the <i>average</i> value of our signal, or the <i>mean</i> or <i>expected value</i>. In electrical engineering it's also called teh 'DC term' or 'DC offset', to indicate something that doesn't change with time. 
</p>
<h2>Bringing it all together</h2>
<p>
You might be wondering why we went to all this trouble when we <i>know what the offset is in the first place</i> - it's 1. The answer is that usually we don't know the offset. Usually we have some unknown signal, and we want to find out what it is. The Fourier Series lets us do that. In the next lesson, we will bring together everything we have learned about even and odd signals, the sine and cosine Fourier Series, and the 'zero-frequency' offset together in the full Sine/Cosine Fourier Series.
</p>
<?php
addLessonNavigationE("lesson2_7.php", "lesson2_9.php", "syllabus.php", "Fourier Series", "Next", "Syllabus");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
