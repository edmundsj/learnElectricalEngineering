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
<h1>Lesson 5: The Fourier Coefficients and Series</h1>
<?php
addLessonNavigationE("lesson2_4.php", "lesson2_6.php", "syllabus.php", "Inner Product", "Next", "Syllabus");
?>
<h2>Hacking away at the squarewave</h2>
<p>
In the <a href="lesson2_3.php">previous lesson</a> we saw that there is a sinewave, <i>literally speaking</i>, contained within a square wave. Quantitatively, we can reduce the <i>energy</i> of a signal by subtracting off an appropriately-scaled sinewave (with the same period). But how far can we go with this? Are there other sinewaves of different frequencies hiding in our square wave? Let's find out. Let's take our left-over signal, and use the equation we figured out in the previous lesson to answer this question. Remember that the signal we are working with has a period of \(2\pi\), so I'm going to set \(P\) equal to \(2\pi\). Then, if we want to find out whether the left-over signal has any higher-frequency sinewaves in it, we just need to use the formula we figured out last time:
</p>
\begin{equation}
\frac{1}{\pi}\langle (sq(x)-sin(x),sin(2x) \rangle
\end{equation}
<p>
But since integration is <i>linear</i>, the inner product is also a <i>linear</i> operation, and so we can separate it out into two parts:
</p>
\begin{equation}
\frac{1}{\pi}\langle sq(x),sin(2x) \rangle - \frac{1}{\pi}\langle (sin(x), sin(2x) \rangle
\end{equation}
<p>
Fortunately, one of these terms we already know (the right-most one)- it's zero! Remember that sinewaves of integer multiple frequencies are <a href="lesson2_2.php">orthogonal</a> to each other. Whew! I thought we were actually going to have to do math. So we're just left with the following equation for how much \(sin(2x)\) there is in our left over signal. 
</p>
\begin{equation}
\frac{1}{\pi}\langle sq(x),sin(2x) \rangle
\end{equation}
<p>
Notice that this is identical to the amount of \(sin(2x)\) in our <i>original</i> signal. So if we want to slowly chip off one sinewave after another from our square wave, we can just work directly with the original signal, rather than having to subtract off one more part each time. That makes life much easier! Let's plot these two signals and see if we can guess how much there is in our square wave:
<?php addMobileImageFull('signals_systems/sin2x_squarewave.svg'); ?>
</p>
<p>
Look at this closely - does this remind you of anything? Maybe something back in our lesson on <a href="lesson2_2.php">orthogonal functions</a>? It looks like if you were to multiply these two signals, for every positive region there is an equal and opposite negative region, and so they cancel each other out when you do the integration. You can check this for yourself mathematically, just to make sure the integral is actually zero. You should find that it is.
</p>
<h2>On to the next one!</h2>
<p>
What about \(sin(3x)\)? \(sin(4x)\)? We can do this all day. But how about we save ourselves some time, and let's find how much of the n-th sinewave \(sin(n x)\) is contained in our square wave.
</p>
\begin{equation}
\frac{1}{\pi}\langle sq(x),sin(nx) \rangle = \frac{1}{\pi}\int_{0}^{2\pi} sq(x)*sin(nx)dx
\end{equation}
<p>
If you actually do this integral, and simplify it a bit since n is an integer, you'll get 
</p>
\begin{equation}
b_n = \frac{2}{n \pi}\left(1 - cos(n\pi) \right)
\end{equation}
<p>
Let's just check real quick to make sure this makes sense with what we have already tried - for \(n=1\), which we went over in the <a href="lesson2_3.php">previous lesson</a>, we know the answer <i>should</i> be \(4/\pi\), and indeed, that is what this spits out. If you try \(n=2\) you will find that this gives you \(0\), also as expected from just above. These are called <i>Fourier Coefficients</i>, and denoted with the symbol \(b_n\). Why \(b\)? Well, because there's also an \(a\) and a \(c\), which we will get to later :). 
</p>
<?php
$counter = 0;
$counter = appendToQuiz($counter, 'What are the Fourier coefficients \(b_5\) and \(b_6\)?',
	array('\(b_5 = 0, b_6 = \frac{1}{\pi}\)', '\(b_5 = \frac{2}{\pi}, b_6 = \frac{4}{\pi}\)', '\(b_5 = \frac{4}{5\pi}, b_6 = 0\)'), 2);
?>
<p>
Now for the really crazy part. Imagine you keep subtracting higher and higher frequency sinewaves. Eventually, in the limit as you subtract an <i>infinite</i> number of sinewaves, the remaining signal energy is <i>exactly</i> zero. Not close to zero. Actually zero. This means that our square wave (which, let me remind you in case you forgot is a SQUARE), is actually made up of an <i>infinite</i> number of sinewaves. This means not only can we subtract the sinewaves from the original signal to make it zero energy, but we can <i>add</i> a bunch of sinewaves up to <i>create</i> a square wave. Don't believe me? Watch this. First, let's just plot our square wave and compare it to the first sinewave we found, with \(b_1 = \frac{4}{\pi}\):
</p>
<?php addMobileImageFull('signals_systems/sinewave_squarewave_approximation_1.svg'); ?>
<p> Now let's add in \(b_3 * sin(3x)\):
<?php addMobileImageFull('signals_systems/sinewave_squarewave_approximation_3.svg'); ?>
<p> And \(b_5 * sin(5x)\):
<?php addMobileImageFull('signals_systems/sinewave_squarewave_approximation_5.svg'); ?>
<p>Notice it's starting to look more and more like a square wave! Let's go bigger, adding in the sinewaves for \(b_7\) through \(b_{25}\):
<?php addMobileImageFull('signals_systems/sinewave_squarewave_approximation_25.svg'); ?>
<p>Now let's go really big, let's add up to \(b_{200}\):
<?php addMobileImageFull('signals_systems/sinewave_squarewave_approximation_200.svg'); ?>
<p>
That's pretty darn close - I can't even see the underlying orange curve any more. Notice there is a bit of ringing at the edges. That never goes away, it's called the <a href="https://en.wikipedia.org/wiki/Gibbs_phenomenon">Gibbs Phenomenon</a>. Fortunately, the <i>energy</i> of that ringing approaches zero as you add more and more sinewaves, so we usually don't have to worry about it.
</p>
<p>
If you've never seen this before, it's absolutely bizarre. It's so counterintuitive that the man who discovered it <a href="https://en.wikipedia.org/wiki/Joseph_Fourier">Joseph Fourier</a> had to fight his fellow mathematicians tooth and nail to convince them. You might now be asking yourself if <i>any</i> periodic signal can be represented as a sum of sinewaves. Or you might be so much in shock you can't think (I was in this latter camp). The answer turns out to be yes, we can, but first we need to cover one more subtlety, the difference between <a href="lesson2_6.php">even and odd signals</a>.
</p>
<?php
addLessonNavigationE("lesson2_4.php", "lesson2_6.php", "syllabus.php", "Inner Product", "Next", "Syllabus");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
