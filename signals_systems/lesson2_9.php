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
<h1>Lesson 8: The Sine/Cosine Fourier Series</h1>
<?php
addLessonNavigationE("lesson2_8.php", "lesson2_10.php", "syllabus.php", "Fourier Series", "Next", "Syllabus");
?>
<h2>The Full Sine/Cosine Fourier Series</h2>
<p>
In the last few lessons, we learned that you can create odd periodic signals by adding together a bunch of sinewaves, and even periodic signals by adding together a bunch of cosines, as long as each sine and cosine is multiplied by the right amount, which is given by the Fourier Coefficients, \(a_n\) (for the cosines) and \(b_n\) for the sines. We can also handle signal offsets using the \(a_0\) term of the cosine Fourier Series, as long as we remember to divide that by 2. We learned that <i>any signal</i> can be broken up into even and odd parts, and so we can represent <i>any</i> signal using a combination of sines and cosines.
</p>
<h2>The Recipe</h2>
<p>
So, here's the recipe for constructing our signal out of sines and cosines:
</p>
<ol>
<li>Find the Sine Fourier Coefficients \(b_n\)</li>
<li>Find the Cosine Fourier Coefficients \(a_n\)</li>
<li>Add up the offset \(a_0/2\), all the sinewaves \(\sum_{n=1}^{n=\infty}b_n*sin(nx)\), and the cosines \(\sum_{n=1}^{n=\infty}a_n*cos(nx)\) and you've got your original signal!
</ol>
<p>
Now, usually we can't add all the way up to infinity, I have a finite amount of patience and my computer has a finite amount of memory. So when we want to plot the signals or deal with them on a computer, we usually truncate the series at some point. But when dealing with them mathematically, we can usually just leave the sums as-is, or evaluate them ananlytically. The more important part of the Fourier Series, for engineers at least, is getting an intuitive feel for what is going on behind the <i>Fourier Transform</i>.
</p>
</p>
<h2>A shifted, offset square wave</h2>
<p>
To show this, let's bring together everything we have learned so far and attack a signal that is neither even nor odd, a square wave shifted (delayed) by \(\pi/4\):
</p>
<?php addMobileImageFull('signals_systems/square_wave_awkward_shifted.svg'); ?>
<p>
We can't use just a Sine Fourier Series for this, and we can't use just a Cosine Fourier series, we have to use <i>both</i>. Let's do them one at a time. First, let's start with the Sine Fourier Series. Since the sine Fourier series can only represent <i>odd</i> signals, it's going to "pull out", so to speak, the odd part of our signal. We don't actually <i>have to</i> find the odd part of the signal ourselves, the Fourier Series will do that for us. But let's do it anyway, just so we can check that everything makes sense - what is the odd part of our signal? Well, remember, from our <a href="lesson2_6.php">previous lesson on even and odd signals</a> we can find the odd part by mirroring our original signal and subtracting it. If we do that, we'll get something that looks like this:
</p>
<?php addMobileImageFull('signals_systems/square_wave_odd_part.svg'); ?>
<p>
Huh. Cute. What do we actually get if we compute the Fourier Coefficients and add them up? Let's start with just the first Fourier Coefficient \(b_1\).
</p>
<?php
$counter = 0;
$counter = appendToQuiz($counter, 'What is the first Sine Fourier Coefficient, \(b_1\)? (Hint: I recommend integrating from \(\pi/4\) to \(5\pi/4\), since this is the only part of one period where the function is nonzero)',
    array('\(b_1 = 4/\pi\)', '\(b_1 =2\sqrt{2}/\pi\)', '\(b_1 = 1\)'), 1);
?>
<p>
Now, we could go on to compute the second coefficient, and the third coefficient, and so on, but it's much more convenient if we go straight to the nth coefficient. If you do the integral (again, I recommend splitting it into two integrals, from \(\pi/4\) to \(5\pi/4\) and \(5\pi/4\) to \(9\pi/4\)), after the dust settles, you should get this:
</p>
\begin{equation}
b_n=\frac{2}{n\pi}\left( cos\left(\frac{n\pi}{4}\right) - cos\left(\frac{5n\pi}{4}\right)\right)
\end{equation}
<p>
Now, for the big question - does adding up all the sinewaves scaled by their Sine Fourier Coefficients actually produce the signal we expect? Well, let's plot the expected odd part of our signal with just the first sinewave, \(b_1*sin(x)\):
</p>
<?php addMobileImageFull('signals_systems/square_wave_odd_with_approximation_1.svg'); ?>
<p>
Huh. The sinewave <i>does</i> seem to trace out the odd part of our signal, but let's keep adding more sinewaves. Here's what it looks like after adding up to \(b_5 * sin(5x)\):
<?php addMobileImageFull('signals_systems/square_wave_odd_with_approximation_5.svg'); ?>
</p>
<p>
And up to 25 sinewaves:
<?php addMobileImageFull('signals_systems/square_wave_odd_with_approximation_25.svg'); ?>
</p>
<p>
Fascinating! It's doing exactly what we expect. The Sine Fourier Series is creating the odd part of our signal! We could keep going, and it would get more and more accurate, but I think you get the point. Now, what about the cosine part?
</p>
<h2>The Cosine Series</h2>
<p>
Just like we created the <i>odd</i> part of our signal, we can also create the <i>even</i> part, by mirroring our signal and adding it. If you do that, you should get this:
<?php addMobileImageFull('signals_systems/square_wave_awkward_shifted_even.svg'); ?>
</p>
<p>
Notice that this signal has an offset - the even part of the signal contains the offset. This makes sense, because an offset (a constant), is the same everywhere, and so is symmetric about the origin. By now you know the drill, let's just skip straight to finding the nth Cosine Fourier Coefficinet \(a_n\) with our square wave signal (let's call it \(f(x)\) because we're creative like that).
</p>
\begin{equation}
a_n = \frac{2}{P}\langle f(x), cos(nx) \rangle = \frac{2}{2\pi}\int_{\pi/4}^{9\pi/4}f(x)*cos(nx)dx
\end{equation}
As with the Sine Fourier Coefficients, we only actually have to do this integral from \(\pi/4\) to \(5\pi/4\), since that's the only part of \(f(x)\) which is nonzero:
\begin{equation}
a_n = \frac{1}{\pi}\int_{\pi/4}^{5\pi/4}cos(nx)dx
\end{equation}
<p>
And we end up getting basically the same answer as with the Sine Fourier Coefficients, but with cosines replaced by negative sines:
</p>
\begin{equation}
a_n = -\frac{2}{n\pi}\left(sin\left(\frac{n\pi}{4}\right) - sin\left(\frac{5n\pi}{4}\right)\right)
\end{equation}
<p>
Now, let's start adding stuff up and see if we reconstruct the even part of the signal. Let's start with the offset, \(a_0/2\). What is this? Well, if you just try to plug it in above, you'll get \(0/0\), not terribly useful. By taking the <i>limit</i> as \(n\rightarrow0\), you can find the coefficient \(a_0\), and the offset of the signal:
</p>
<?php
$counter = appendToQuiz($counter, 'What is the coefficient \(a_0\) and the signal offset?',
    array('\(a_0 = 4, offset=2\)', '\(a_0 = 2, offset = 1\)', '\(a_0 = 1, offset=2\)'), 1);
?>
<p>
Let's plot the signal we expect to see (the even part of our original signal, in blue) and the offset (in orange) that we found so far:
<?php addMobileImageFull('signals_systems/square_wave_even_with_approximation_0.svg'); ?>
</p>
<p>
Looks reasonable to me. The offset of 1 slices our even signal right in half. Now, what happens when we add \(a_1*cos(1x)\)?
<?php addMobileImageFull('signals_systems/square_wave_even_with_approximation_1.svg'); ?>
</p>
<p>
Let's keep going! Let's add up to \(a_5 * cos(5x)\):
<?php addMobileImageFull('signals_systems/square_wave_even_with_approximation_5.svg'); ?>
</p>
<p>
Let's add all the terms up to \(a_{25} * cos(25x)\):
<?php addMobileImageFull('signals_systems/square_wave_even_with_approximation_25.svg'); ?>
</p>
<p>
Exactly what we expected! Again, we could keep adding terms to get better and better accuracy, but let's stop there for now.
</p>
<h2>Bringing it all together</h2>
<p>
Finally, if we add <i>everything</i> together: the offset \(a_0/2\), all the appropriately-scaled cosines \(a_1*cos(1x) + a_2*cos(2x) + a_3*cos(3x) + ...\), and the appropriately scaled sinewaves \(b_1*sin(1x) + b_2*sin(2x) + b_3*sin(3x) + ...\) we could <i>fully</i> reconstruct our original signal. Here's the first 25 terms of the sine and cosine series added together with the offset, plotted with our original signal:
</p>
<?php addMobileImageFull('signals_systems/square_wave_shifted_full_approximation.svg'); ?>
<p>
Absolutely beautiful. Exactly what we wanted. 
</p>
<h2>But it's so complicated...</h2>
<p>
At this point, you might be seriously doubting the usefulness of the Sine/Cosine Fourier Series. We have to do two integrals (at least!), make sure to divide \(a_0\) by 2, and do two infinite sums just to get back our original signal! That sounds like a lot of work. And indeed, there is a better way. Not only can we do away with having to separate out the offset, but we can unify the Sine/Cosine series into a <i>single</i> series, with a <i>single</i> integral and a <i>single</i> sum, while actually making the integral <i>easier</i>, AND keeping all the same information! Sound too good to be true? It isn't. It's the subject of the next lesson.
</p>
<?php
addLessonNavigationE("lesson2_8.php", "lesson2_10.php", "syllabus.php", "Fourier Series", "Next", "Syllabus");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
