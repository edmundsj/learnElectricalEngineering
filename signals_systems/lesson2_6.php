<?php

echo'<html>';
include $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/head.php";
beginPage();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/header_menu.php";
beginWrapper();
?>

<h1>Signals and Systems Part 2: Fourier Series</h1>
<span class="image main"><img src="/images/pic13.jpg" alt="" /></span>
<h1>Lesson 6: Even and Odd Signals</h1>
<?php
addLessonNavigationE("lesson2_5.php", "lesson2_7.php", "syllabus.php", "Fourier Series", "Next", "Syllabus");
?>
<h2>Symmetry and Antisymmetry - Even and Odd</h2>
<p>
So far, we've been dealing mostly with sinewaves, and let's just plot one for fun from \(-\pi\) to \(\pi\):
<?php addMobileImageFull('signals_systems/sinewave_odd.svg'); ?>
</p>
<p>
This has a kind of antisymmetry to it about the origin - the positive half is the mirror image of the negative half, but flipped. We call this kind of function an 'odd' function. Odd functions don't have to be periodic, like the sinewave, they just need to be an inverted mirror image - for example, this signal is odd as well:
<?php addMobileImageFull('signals_systems/gaussian_odd.svg'); ?>
</p>
<h2>What makes a signal odd?</h2>
<p>
We can plot a function and visually look at it to see if a function is odd, and this is usually the best way of doing it. However, sometimes it won't be easy to plot things, so we can also define <i>mathematically</i> what it means for a signal to be odd. If we take any point to the right of the origin (\(+x\)), the value of the function, is, by definition, \(f(x)\). The value of the function the same distance to the left of the origin is \(f(-x)\). For an odd signal, we want these to be the negative of each other - in other words we want:
</p>
\begin{equation}
f(-x) = -f(x)
\end{equation}
<p>
Any signal which obeys the above equation is said to be odd.
</p>
<h2>Even Signals</h2>
<p>
Just as some signals are antisymmetric, others are symmetric, like the cosine (which I've plotted over one period about the origin:
<?php addMobileImageFull('signals_systems/cosine_even.svg'); ?>
</p>
<p>
'Even' just means the signal is the mirror image of itself about the origin - it is symmetric if we flip it. Again, signals don't have to be periodic to be even, we can have signals that begin and end at some point, which are also even:
</p>
<?php addMobileImageFull('signals_systems/gaussian_even.svg'); ?>
<p>
So long as they have mirror symmetry, the signals are even. Just as we can mathematically define odd signals, we can mathematically define even signals, too. In this case, we want every value of our signal at some distance to the right of the origin \(+x\) to be <i>equal</i> to the value the same distance away on the left (\(-x\)). Or, in math speak:
</p>
\begin{equation}
f(-x) = f(x)
\end{equation}
<p>
Let's do a couple of examples to drive the point home.
</p>
<?php
$counter = 0;
$counter = appendToQuiz($counter, 'Is the signal \(cos(-2x)\) even or odd?',
    array('Even', 'Odd'), 0);
$counter = appendToQuiz($counter, 'What is sin(-3x) + cos(-10x) equal to?',
    array('\(-sin(3x) + cos(10x)\)', '\(sin(3x) + cos(10x)\)', '\(sin(3x) - cos(10x)\)'), 0);
?>
<h2>Ok, great, but who cares?</h2>
<p>
We're engineers - for something to matter to us it needs to be useful. Why do we care about even and odd signals? The main reason is that some problems can be greatly simplified if signals are even or odd. In particular, if you're <i>integrating</i> an odd signal from \(-a\) to \(a\) (where a is any number, or infinity), the answer will <i>always</i> be zero. We saw this before when taking inner products, and it's going to be extremely useful. This is really nice beacuse odd signals are what I like to call "sticky" - when you multiply an odd signal by an even signal, the new signal is odd.
</p>
<h2>Even is orthogonal to odd</h2>
<p>
This fact has an interesting consequence - even signals are always <i>orthogonal</i> to odd signals. Remember the definition of orthogonality - two signals are orthogonal when the inner product is zero. Well, to get the inner product, we need to <i>multiply</i> the two functions by each other, and if one of them is odd and the other even, then the thing inside the integral is odd:
</p>
\begin{equation}
\langle even(x), odd(x) \rangle = \int_{-\infty}^{\infty} even(x)*odd(x) dx = \int_{-\infty}^{\infty} odd(x) dx = 0
\end{equation}
<p>
So even signals are, in a sense, <i>as different as possible</i> from odd ones. This has some really important consequences for the Fourier Series, which we explore in the <a href="lesson2_7.php">next lesson</a>.
</p>
<h2>Decomposing a Signal into Even and Odd Parts</h2>
<p>
It might sound weird at first, but we can actually decompose <i>any</i> signal into even and odd parts. Take this signal for example:
</p>
<?php addMobileImageFull('signals_systems/gaussian_one_sided.svg'); ?>
<p>
This is neither even nor odd. But we could imagine <i>constructing it</i> from signals that are even and odd. For example, if we <i>added</i> the following two signals together:
<?php addMobileImageFull('signals_systems/gaussian_even.svg'); ?>
<?php addMobileImageFull('signals_systems/gaussian_odd.svg'); ?>
</p>
<p>
Then the bump on the left-hand side would cancel out, and the one on the right hand side would get twice as large. So we just need to multiply by 1/2, and we get back our original signal. You can <i>always</i> do this. To make an even version of your signal, just mirror your original signal, and keep the mirrored part positive, but to create an odd version, make the mirrored part negative (as we did above). If you divide everything by two, then by adding the two signals you can get back to your original.
</p>
<p>
We can also express this in math. If we have a signal \(f(x)\) (for example the little lump above), we can create an even signal from this, by adding the signal to its mirror image:
</p>
\begin{equation}
f_{even}(x) = \frac{1}{2}\left(f(x) + f(-x)\right)
\end{equation}
<p>
Or, to create an odd signal, <i>subtract</i> the mirror image:
</p>
\begin{equation}
f_{odd}(x) = \frac{1}{2}\left(f(x) - f(-x)\right)
\end{equation}
<p>
Then, we can say that our signal is <i>literally</i> made out of an even part and an odd part.
</p>
\begin{equation}
f(x) = f_{even}(x) + f_{odd}(x)
\end{equation}
<p>
This might seem a little weird and contrived, and to some degree it is, but often it's more convenient to work with even and odd signals than it is to work with our original signal. Just a useful trick to be aware of. This useful trick, though, has some serious theoretical implications, which we explore in the <a href="lesson2_7.php">next lesson</a>, on the cosine Fourier Series. This theme of signals being 'composed of' other signals will come up again and again.
</p>

<?php
addLessonNavigationE("lesson2_5.php", "lesson2_7.php", "syllabus.php", "Fourier Series", "Next", "Syllabus");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
