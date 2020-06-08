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
<h1>Lesson 3: Function Decomposition</h1>
<?php
addLessonNavigationE("lesson2_2.php", "lesson2_4.php", "syllabus.php", "Inner Product", "Next", "Syllabus");
?>
<h2>So, what can we do with this?</h2>
<p>
So we have this neat way of figuring out <i>how much</i> of a function (for example, a sinewave) is contained within another function (for example, a square wave) using the inner product. But what can we <i>do</i> with that? Well, remember how we learned with LTI systems, that sinewaves are SUPER convenient to work with? This lets us convert <i>any</i> periodic signal into a bunch of sinewaves. How exactly? Let's find out.
</p>
<h2>How much sinewave is in my sinewave?</h2>
<p>
First, let's do something so simple it seems ridiculous: let's ask the question of how much of \(sin(x)\) is in \(sin(x)\) using the inner product. Why on earth would we want to do this? Well, what do we <i>want</i> the answer to be? Personally, I would really like it to be 1. That makes everything easy to interpret - a value of 1 would mean our signal is <i>nothing but</i> sinewave. If we would take away the sinewave, there would be nothing left. So, let's actually calculate the inner product:
</p>
\begin{equation*}
\int_{0}^{2\pi}sin(x)*sin(x)dx = \pi
\end{equation*}
<p>
It turns out you actually get the same exact answer for any sinewave that's an integer multiple of this frequency (so \(sin(2x), sin(3x), sin(4x)\), and so on). This means to answer the question, how much sinewave is in my sinewave, for the answer to be 1, we just need to divide the inner product by \(\pi\). 
</p>
<h2>But what about all the other periods?</h2>
<p>
At this point you might be saying: OK, fine, but what if I took the inner product not over the range from \(0\) to \(2\pi\), but maybe 0 to \(4\pi\), or \(-100\pi\) to \(100\pi\)? These signals go on forever, shouldn't we be able to do that too? 
</p>
<?php addMobileImageFull('signals_systems/sinewave_two_periods.svg'); ?>
<p>
I'm glad you asked. Well, let's give it a try. What if we took the region from \(0\) to \(4\pi\) as an example? Then, if we compute the inner product, we get a value of \(2\pi\). If we did the same thing from \(-100\pi\) to \(100\pi\), we would get \(100\pi\). Starting to notice the pattern? We can integrate over whatever range we want, so long as we divide by <i>half the period</i>. We can then finally answer the question above, how much sinewave is in my sinewave:
</p>
<p>
Amount of sinewave in my sinewave = \( \frac{2}{P}\langle sin(x), sin(x) \rangle \)
</p>

<?php
$counter = 0;
$counter = appendToQuiz($counter, 'Try integrating from \(0\) to \(4\pi\) using the formula above. How much sinewave is in our sinewave?',
	array('0.5', '1', '2'), 1);
?>
<h2>Solution</h2>
<p>
If we integrate over the region from \(0\) to \(4\pi\), then our period \(P\) is just \(4\pi\), and the amount of sinewave in our sinewave is:
</p>
\begin{equation*}
\frac{2}{P}\langle sin(x), sin(x) \rangle = \frac{2}{4\pi}\int_{0}^{4\pi}sin(x)*sin(x)=1
\end{equation*}
<p>
Exactly as we wanted.
</p>
<p>
Now that we know the amount of sinewave in our sinewave, we can move on to less ridiculous-sounding things, like how much of our sinewave is in <i>other</i> signals? This is given by the same formula as above, but replacing one of the \(sin()\) functions left with something else - let's take the example of a square wave.
</p>
<h2>How much sinewave is in my square wave?</h2>
<p>
<?php addMobileImageFull('signals_systems/sinewave_and_square_wave.svg'); ?>
Now we are ready to quantitatively answer the question - how much of a sinewave is present in another signal, like the square wave above (both plotted over a single period)? Another way of putting this is - if we could approximate our square wave as a sinewave, how big would that sinewave have to be for the best approximation possible? Well, let's find out using the formula that we found before in terms of the inner product, replacing \(sin(x)\) with our square wave \(sq(x)\):
</p>
\begin{equation*}
\frac{2}{P}\langle sq(x), sin(x) \rangle = \frac{2}{2\pi}\int_{0}^{2\pi}sq(x)*sin(x)dx
\end{equation*}
<p>
If you actually carry out this integral, you'll get a value of \(4/\pi\). This might seem a little odd at first. How can the coefficient by greater than 1? Well, let's plot the sinewave, multiplied by \(4/\pi\), and the square wave together:
</p>
<?php addMobileImageFull('signals_systems/sinewave_squarewave_approximation_1.svg'); ?>
<p>
While the sinewave does have a bigger <i>amplitude</i> than the square wave, it looks like that might be because it's trying to be a better approximation <i>on average</i> - it minimizes the amount left over.
</p>
<h2>Getting quantitative with the left overs - Energy</h2>
<p>
What do I mean exactly when I say this size of the sinewave "minimizes the amount left over"? I mean that it minimizes what's called the <i>energy</i> of the signal. If we were to subtract the sinewave that is present inside the square wave, we would get something like this:
<?php addMobileImageFull('signals_systems/square_wave_minus_sinewave.svg'); ?>
</p>
<p>
Pretty ugly. If we square this ugly mess, and then we integrate it over a period, that is what is called the "energy" of a signal over a single period. It's called that because it does really represent a form of energy - the ability of the signal to push or pull stuff, or to do work, or <i>carry information</i> and be robust to noise. If you actually compute the energy of the left-over signal, you'll get about 1.19. If you <i>slightly increase</i> or <i>slightly decrease</i> the amplitude of the subtracted sinewave from \(4/\pi\), the left over energy will get <i>larger</i>. In other words, it looks like that amplitude is <i>exactly</i> the amplitude that you would want to minimize the energy of the remaining signal. You might also have noticed that the energy is smaller than the original signal itself (\(2\pi\)). This means, in a literal sense, <i>there is a sinewave inside the square wave</i>, and removing it made the signal have less energy.
</p>
<h2>Energy and Power</h2>
<p>
But, you might say, what if we had integrated over a longer time? Won't this signal have more energy? Why yes, you are correct, that does seem to be kind of annoying. For this reason, we can instead choose to use <i>average power</i>, or just the energy in some window of time divided by the time over which we integrate. 
</p>
<p>
But why stop after just a single sinewave? Can we reduce the energy of the left over signal even further? Yes, and that leads us directly into the <a href="lesson2_4.php">next lesson</a> on the Fourier Series.
</p>
<?php
addLessonNavigationE("lesson2_2.php", "lesson2_4.php", "syllabus.php", "Inner Product", "Next", "Syllabus");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
