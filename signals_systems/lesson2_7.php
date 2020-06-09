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
<h1>Lesson 7: The Cosine Fourier Series</h1>
<?php
addLessonNavigationE("lesson2_6.php", "lesson2_8.php", "syllabus.php", "Fourier Series", "Next", "Syllabus");
?>
<h2>Can we represent any signal this way?</h2>
<p>
So in <a href="lesson2_5.php">the last lesson on Fourier Series</a> we saw we could represent a square wave as an infinite sum of sinewaves, but is that <i>always</i> the case? For example, what if we <i>shifted</i> the square wave? So instead of being positive from \(0\) to \(\pi\), and negative from \(\pi\) to \(2\pi\), it looks like this (plotted over two periods):
<?php addMobileImageFull('signals_systems/squarewave_shifted_two_periods.svg'); ?>
</p>
<p>
In other words, the square wave is now <i>even</i>. Does this change our Fourier Coefficients? Well, let's compute them again and see if they change. We need to multiply our new square wave by a sinewave and integrate that over a period. Here I chose \(-\pi\) to \(\pi\), to do the integration, instead of \(0\) to \(2\pi\), which is totally fine, and it will help to make a point. Let's call this new signal \(sq_e\) instead of just \(sq\), to distinguish it from the odd square wave:
</p>
\begin{equation}
b_n = \frac{2}{P}\langle sq_{e}(x), sin(x) \rangle = \frac{2}{2\pi} \int_{-\pi}^{\pi}sq_{e}(x)sin(x)dx
\end{equation}
<p>
You can do the integral, or you can just plot what the two look like when multiplied together:
<?php addMobileImageFull('signals_systems/square_sin_multiplied.svg'); ?>
</p>
<p>
Notice anything? This is an <i>odd</i> function, which we should have expected, because we are multiplying an even signal (our shifted square wave) by an odd one (a sinewave). If we integrate this, <i>everything cancels</i>, with the negative regions being matched by positive regions. Well, this was just the first coefficient. What about \(b_2\), where we multiply by \(sin(2x)\)? What does that look like?
</p>
<?php addMobileImageFull('signals_systems/square_sin2x_multiplied.svg'); ?>
<p>
It's the <i>same thing again</i>. The positive regions look like they get canceled by the negative ones. You could keep doing this for higher and higher frequencies, and you would keep seeing the same thing over and over again. 
</p>
<h2>Orthogonal Signals</h2>
<p>
What do all of the Fourier Coefficients being zero mean? It means that we cannot create an <i>even</i> signal out of a bunch of <i>odd</i> ones. We might have expected this since even and odd signals are orthogonal - each contains none of the other. In order to make an even signal, then, we need a bunch of even signals. We need to use <i>cosines</i>.
</p>
<h2>The Cosine Fourier Series</h2>
<p>
Let's try instead to use cosines, rather than sinewaves, to construct the square wave. We need to ask the question <i>how much of a cosine is in our square wave?</i> Now, after alreading going through this once before, we know how to answer this question - we just need to use the inner product. As with the sinewaves, though, there is a \(\frac{2}{P}\) out front - we want to make sure that if our signal is purely a cosine, then the 'amount of cosine' in it is 1. Let's try to compute how much of \(cos(x)\) is in our square wave. First, let's plot the two to see what they look like together:
</p>
<?php addMobileImageFull('signals_systems/squarewave_shifted_with_sinewave.svg'); ?>
<p>
It does look like they have a great deal of overlap - so we might suspect there is some cosine to be found in our square wave, but how much? Want to take a guess? Let's actually do the integral:
</p>
\begin{equation}
\frac{2}{P}\langle sq_{e}(x), cos(x) \rangle = \frac{2}{2\pi} \int_{-\pi}^{\pi}sq_{e}(x)cos(x)dx
\end{equation}
<?php
$counter = 0;
$counter = appendToQuiz($counter, 'How much cosine is there in our shifted square wave?',
	array('\(\frac{4}{\pi}\)', '1', '\(\pi\)'), 0);
?>
<h2>Solution</h2>
<p>
We can do the integral either in three pieces, or we can instead do it in two pieces over a slightly different region, say from \(-pi/2\) to \(3\pi/2\). All that matters is that we cover a single period. From the region \(-\pi/2\) to \(\pi/2\), we just need to integrate 1*cos(x), since the square wave is equal to \(+1\) in this region. This integrates out to \(2/\pi\). The second region, from \(\pi/2\) to \(3\pi/2\), looks exactly the same as the first (cosine is negative in that region, and so is the square wave, so multiplied together they become positive), and this also integrates out to \(2/\pi\). 
</p>
<p>
Interesting... it's the same exact value we got for the sinewave inside the <i>odd</i> square wave (the non-shifted one). In fact, if you calculate how much \(cos(nx)\) is in our shifted square wave, you get the following: 
\begin{equation}
a_n=\frac{4}{n\pi} sin\left(\frac{n\pi}{2}\right)
\end{equation}
</p>
<p>These are also Fourier Coefficients, but for <i>cosines</i> rather than sines, and the nth cosine Fourier Coefficient is denoted \(a_n\). (remember I told you we would meet the letter a? :))
<?php

$counter = appendToQuiz($counter, 'What are the second and third cosine Fourier coefficients in the example above?',
	array('\(a_2 = 0, a_3 = \frac{4}{3\pi}\)', '\(a_2 = \frac{4}{\pi}, a_3 = 0\)', '\(a_2 = 0, a_3 = -\frac{4}{3\pi}\)'), 2);
?>
<p>
Notice that they are excatly the same as the Fourier Coefficients in the sin() case, but now some of them are <i>negative</i>. This has to do with the maxima of the \(cos(nx)\) function being stuck at 0 - so we can't just keep adding more and more cosines together with the same sign, or this region would blow up (when we want it to converge to 1). This wasn't a problem with the sin() case.
</p>
<p>
But what does it even mean for there to be <i>negative</i> cosines in our square wave? Well, it just means that if you want to make a square wave out of cosines, you better multiply some by positive coefficients, and some by negative coefficients. If we plot just the first cosine multiplied by \(a_1\), the first Fourier Coefficient, we get something that looks like this:
</p>
<?php addMobileImageFull('signals_systems/cosine_squarewave_approximation_1.svg'); ?>
<p>
If we add \(a_3*cos(3x)\) to that (and remember, \(a_3\) is negative, we get:
<?php addMobileImageFull('signals_systems/cosine_squarewave_approximation_3.svg'); ?>
</p>
<p>
We can keep adding and adding appropriately-multiplied cosines, here's up to \(a_{25}*cos(25x)\):
<?php addMobileImageFull('signals_systems/cosine_squarewave_approximation_25.svg'); ?>
</p>
<p>
And eventually, as in the case with sinewaves, if we add enough terms the square wave starts to look indistinguishable from the sum of cosines (adding up to \(a_{200}*cos(200x)\):
<?php addMobileImageFull('signals_systems/cosine_squarewave_approximation_200.svg'); ?>
</p>
<h2>Representing any periodic signal</h2>
<p>
We've now seen that when our square wave was odd (as in the last lesson), we could build it out of a bunch of other odd signals - sinewaves. But when our square wave was even (in this lesson), we needed a bunch of even signals (cosines) to create it. But what if our signal was neither even nor odd? Well, remember that we can <i>always</i> 'decompose' a signal into its even parts and its odd parts. So if we had a signal that was neither even nor odd, we could <i>create it</i> using one signal that is even, and one signal that is odd. The odd signal is made up only of sine waves (and we can figure out their coefficients, \(b_n\)), and the even signal only of cosines (whose coefficients are \(a_n\). But there's one more subtlety we have to cover before we can represent <i>any</i> periodic signal, and that's dealing with offsets.
</p>
<?php
addLessonNavigationE("lesson2_6.php", "lesson2_8.php", "syllabus.php", "Fourier Series", "Next", "Syllabus");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
