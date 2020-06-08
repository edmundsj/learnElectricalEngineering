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
<h1>Lesson 4: Energy and Power</h1>
<?php
addLessonNavigationE("lesson2_3.php", "lesson2_5.php", "syllabus.php", "Decomposition", "Fourier Series", "Syllabus");
?>
<h2>How 'much' is there - Energy</h2>
<p>
The "energy" of a signal lets us get precise about how "much" of a signal there is. It's called energy because it is, in a real sense, the ability of the signal to <i>do work or carry information</i>. A signal that has zero energy cannot carry information. A signal that has <i>lots</i> of energy can carry lots of information, or if it represents a physical force, can do lots of work on objects. Fortunately, you already know how to compute the energy - you just take the <a href="lesson2_1.php">inner product</a> of a signal with itself. If we have some arbitrary signal \(f(x)\) its energy is \(\langle f(x), f(x) \rangle \), where you integrate over the entire region over which the signal exists (in math-speak, you integrate from \(-\infty\) to \(+\infty\)). If you're more comfortable with the math form of this, where \(E\) is the signal energy, then the energy is just:
</p>
\begin{equation}
E = \int_{-\infty}^{\infty}|f(x)|^2dx
\end{equation}
<p>
For now you can just <i>square</i> signals, but when we start using complex signals we will actually need to take their magnitude.
</p>
<h2>Periodic vs. Aperiodic signals</h2>
For signals that start and stop at some point, this means we just need to grab the inner product over the region where that signal is nonzero. Some signals are never really "zero" exactly, but you can still integrate them over everywhere they exist. For example, take this signal, the one-sided exponential:
<?php addMobileImageFull('signals_systems/one_sided_exponential.svg'); ?>
<p>
It has a nonzero value all the way off to \(+\infty\), but as long as its integral converges when we try to integrate from \(-\infty\) to \(\infty\), everything is OK. So all we need to do is integrate from \(0\) to \(\infty\). The energy of this signal is just:
</p>
\begin{equation}
E = \int_{0}^{\infty}|e^{-x}|^2 dx
\end{equation}
<p>
In fact, let's actually have you do this integral to get some practice computing the energy.
</p>
<?php
$counter = 0;
$counter = appendToQuiz($counter, 'What is the energy of the signal above, \(e^{-x}*u(x)\) (an exponential zero everywhere from \(-\infty\) to 0)',
	array('1', '1/2', '2'), 1);
?>
<h2>Average power, or energy per period</h2>
<p>
For periodic signals, or signals that never end, if we tried to take the inner product from \(-\infty\) to \(\infty\), we would get a value of \(\infty\). Not terribly insightful. But we still want some estimate of how "much" of a signal is left. You might imagine one way to do it for periodic signals - just integrate over a single period and take that to be the "energy". This is pretty much excatly what we do. We integrate over a single period, and divide by that period, to get the "avergae power", or energy density / energy per unit time. So if \(P\) is our signal period, then the average power for a periodic signal \(f(x)\) is defined as:
</p>
\begin{equation}
P_{avg} = \frac{1}{P}\langle f(x), f(x) \rangle = \frac{1}{P}\int_{0}^{P}|f(x)|^2dx
\end{equation}
<p>
You could have also integrated from \(-P/2\) to \(P/2\), or \(-P/4\) to \(3P/4\), it doesn't matter. As long as you get a single period in the integration the answer will be the same. Let's do some practice below to get a feel for this:
</p>

<?php
$counter = appendToQuiz($counter, 'What is the energy of 2-pi periodic a sinewave over a single period?',
	array('1', '\(\pi\)', '2'), 1);
$counter = appendToQuiz($counter, 'What is the average power of a 2-pi periodic sinewave?',
	array('4', '\(2 \pi\)', '1/2'), 2);
?>

<p>
<?php addMobileImageFull('signals_systems/square_wave_minus_sinewave.svg'); ?>
Now what if we go back to the original question we were asking - how much of our square wave signal is left after we take out the sinewave part? Well, now we can answer this question quantitatively - we can find the <i>energy</i> over a single period of the signal (or the average power) before and after taking out the sinewave. What is the average power of the signal beforehand? Well, we can calculate it. The period is \(2\pi\), and if we take the magnitude squared of our square wave, that's just \(1\) over our region of integration, so the average power is 1. What about after we subtract the sinewave (properly scaled by \(4/\pi\) as we found <a href="lesson2_3.php">before</a>)? Well, we can actually calculate the average power in our left-over signal using the definition above. I'll leave that to you as an exercise in calculus :)

<?php
$counter = appendToQuiz($counter, 'What is the energy of the left-over signal, \(sq(x) - 4/\pi sin(x)\)?',
	array('\(\pi\)', '~\(0.227\)', '~\(0.4\)'), 1);
?>
<p>
You should have found the average power is <i>lower</i> than it was before! That means, in a <i>literal sense</i>, there is a sinewave <i>contained within</i> our square wave, because when we remove it, our signal's average power is lower. Now, here's something really spooky. If you <i>slightly increase</i> or <i>slightly decrease</i> the amplitude of the subtracted sinewave from \(4/\pi\), the energy of the left-over signal will go <i>up</i> in both cases. Give it a try! This means that the amount we found when we asked the question 'how much sinewave is in my square wave'? is the precise amount that <i>minimizes</i> the left-over energy. We take out exactly the amount of sinewave that does this and no more.
</p>
<p>
But why stop after just a single sinewave? Can we reduce the energy of the left over signal even further? Yes, and that leads us directly into the <a href="lesson2_5.php">next lesson</a> on the Fourier Series.
</p>
<?php
addLessonNavigationE("lesson2_3.php", "lesson2_5.php", "syllabus.php", "Decomposition", "Fourier Series", "Syllabus");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
