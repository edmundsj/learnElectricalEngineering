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
<h1>Lesson 10: The Complex Fourier Series</h1>
<?php
addLessonNavigationE("lesson2_9.php", "lesson2_11.php", "syllabus.php", "Fourier Series", "Next", "Syllabus");
?>
<h2>Down with sines and cosines!</h2>
<p>
Sines and cosines are great, but as we have seen they are a little awkward to work with. Having to keep track of two sets of coefficients \(a_n\) and \(b_n\) is pretty, not to mention dealing separately with the offset, and as we've seen before, sines and cosines, while they <i>work</i>, they aren't the most elegant way to solve the problems we face in engineering when we deal with linear systems. There is a signal more powerful, which is not only easier to deal with mathematically, but makes all of our physical problems much easier too. This signal is the complex exponential, \(e^{j x}\).
</p>
<h2>How much complex exponential is in my signal?</h2>
<p>
So far, we have asked and answered the questions:
<ul>
<li><a href="lesson2_5.php">How much \(sin(x)\) is in my signal</a></li>
<li><a href="lesson2_7.php">How much \(cos(x)\) is in my signal?</a></li>
<li><a href="lesson2_8.php">How much \(cos(0x)\), or offset, is in my signal?</a></li>
<li><a href="lesson2_6.php">How much odd signal is in my signal?</a></li>
<li><a href="lesson2_6.php">How much even signal is in my signal?</a></li>
</ul>
Now, we are ready to answer a question that might seem bizarre and nonsensical at first - <i>how much \(e^{jx}\) is in my signal?</i> Hold up. How can a signal (let's take the square wave we are so fond of) contain a <i>complex exponential?</i> The square wave is real! Well, it doesn't <i>just</i> contain <i>one</i> complex exponential - it contains a bunch. Remember how we could make an (odd) square wave by adding up a bunch of sine waves? Well, we can also make a sinewave by adding a couple of complex exponentials:
</p>
\begin{equation}
sin(x) = \frac{1}{2j}\left(e^{jx} - e^{-jx}\right)
\end{equation}
<p>
So, just as an odd square wave contains a bunch of sinewaves, it also contains a bunch of complex exponentials. But since our square wave is <i>real</i> those complex exponentials come in pairs - if our square wave (or any real signal) contains an \(e^{jx}\) it must also contain an \(e^{-jx}\).
</p>
<h2>The inner product, revisited</h2>
<p>
There's one more subtle point regarding the inner product that we need to revisit. Up until this point we have been dealing only with <i>real</i> signals. When we have <i>complex</i> signals, there's a little extra step we have to do when we take the inner product - we need to complex conjugate the second term inside the integral. So if we want the inner product between two complex periodic signals, \(f(x)\) and \(g(x)\), with a period \(P\), the inner product looks like this:
</p>
\begin{equation}
\langle f(x), g(x) \rangle = \int_{0}^{P}f(x) g^*(x) dx
\end{equation}
<p>
Where the (*) denotes complex conjugation. Why do we have to do this? Well, imagine we want to ask a simple question - how much \(e^{jx}\) is in \(e^{jx}\)? If we <i>didn't</i> complex conjugate, our integral would look like this:
</p>
\begin{equation}
\langle e^{jx}, e^{jx} \rangle = \int_{0}^{2\pi}e^{jx} e^{jx} dx = \int_{0}^{2\pi}e^{2jx} dx = 0
\end{equation}
<p>
The inner product is zero! That's clearly nonsense, because we expect there to be exactly \(1\) \(e^jx\) in our signal \(e^{jx}\). To remedy this, we complex conjugate the second term. Then, our integral will look like this:
</p>
\begin{equation}
\langle e^{jx}, e^{jx} \rangle = \int_{0}^{2\pi}e^{jx} e^{-jx} dx = \int_{0}^{2\pi}1 dx = 2\pi
\end{equation}
<p>
Ah, a nonzero value, phew!
</p>
<h2>The Complex Fourier Series</h2>
<p>
To answer the question "<i>how much \(e^{jx}\) is in my signal?</i>" all we need to do is divide the inner product by \(2\pi\), or one full period. This will ensure there is exactly 1 \(e^{jx}\) in \(e^{jx}\), and all is right with the world. For \(2\pi\) periodic signals, we can find how much \(e^{jx}\) is in them by taking the inner product and dividing by the period of \(2\pi\). Let's do an example just to hammer this one home:
</p>
<?php
$counter = 0;
$counter = appendToQuiz($counter, 'How much \(e^{jx}\) is in an odd square wave with a period of \(2\pi\)?',
    array('\(-\frac{2j}{\pi}\)', '\(\frac{4}{\pi}\)', '\(\frac{2}{\pi}\)'), 0);
$counter = appendToQuiz($counter, 'How much \(e^{-jx}\) is in an odd square wave with a period of \(2\pi\)?',
    array('\(\frac{2j}{\pi}\)', '\(-\frac{4}{\pi}\)', '\(\frac{2}{\pi}\)'), 0);
?>
<p>
Notice that this is <i>half</i> the value we would expect for a sinewave, but the values are imaginary because a sinewave is \(\frac{1}{2j}\left(e^{jx} - e^{-jx}\right)\). This is so important let's do another example, this time with an even square wave:
</p>
<?php
$counter = appendToQuiz($counter, 'How much \(e^{jx}\) is in an even square wave with a period of \(2\pi\)?',
    array('\(-\frac{2j}{\pi}\)', '\(\frac{4}{\pi}\)', '\(\frac{2}{\pi}\)'), 2);
$counter = appendToQuiz($counter, 'How much \(e^{-jx}\) is in an even square wave with a period of \(2\pi\)?',
    array('\(\frac{2j}{\pi}\)', '\(-\frac{4}{\pi}\)', '\(\frac{2}{\pi}\)'), 2);
?>
<p>
For an <i>even</i> square wave, there is half as much \(e^{jx}\) and \(e^{-jx}\) as there is \(cos(x)\), (which remember, had a coefficient of \(4/\pi\)), but each of these are positive and real because \(cos(x) = \frac{1}{2}\left(e^{jx} + e^{-jx}\right) \). Also notice that for <i>both even and odd</i> square waves, there is a nonzero amount of \(e^{jx}\). This is in contrast to the Sine and Cosine series, which could only represent even and odd signals.
</p>
<h2>The n-th Fourier Coefficient</h2>
<p>
And, finally, we can ask the question not just for \(e^{jx}\), and \(e^{-jx}\), but <i>any</i> integer multiple of our signal's frequency. We can ask <i>how much \(e^{jnx}\) is in my signal?</i>. The answer is the nth complex Fourier Coefficient \(c_n\) (or just Fourier Coefficient, no one actually uses the Sine/Cosine Fourier series) ;)
</p>
\begin{equation}
c_n=\frac{1}{P}\langle f(x), e^{jnx} \rangle =\frac{1}{P}\int_{0}^{P}f(x) e^{-jnx} dx 
\end{equation}
<p>
And now we've finally met the \(c_n\) coefficients that I spoke of earlier in the course :). One big happy family of Fourier Coefficients, \(a_n\), \(b_n\), and \(c_n\). Fortunately, engineers are pretty much settled on only using the complex Fourier series.
</p>
<h2>Reason 1 - We only need one set of Coefficients</h2>
<p>
We saw above that there are complex exponentials in <i>both even and odd square waves</i> (and indeed all even and odd signals), because the complex exponential is neither even nor odd - its real part is even, but its imaginary part is odd. This lets us represent either even or odd signals, or signals which are neither even nor odd. The coefficients will just change from being real (when representing an even signal) to being imaginary (when representing an odd signal), or complex (when representing a signal neither even nor odd). This is a whole lot more convenient than lugging around two sets of coefficients!
</p>
<h2>Reason 2 - No more special offset</h2>
<p>
Remember how we had to divide the offset by 2 when dealing with the cosine series? With complex exponentials, this is no longer the case! \(e^{j0x}\), which is just equal to \(1\), has exactly the same amount of energy has \(e^{jx}\) over a \(2\pi\) interval (check the inner product!), and so the coefficient \(c_0\) <i>directly</i> represents the offset of a signal. This means we need only a <i>single</i> series to represent <i>any</i> periodic signal (although we have to include both positive and negative values of \(n\).
</p>
<h2>Let's do an example</h2>
<p>
Let's do an example to give you a feel for what is going on. Let's say we have an even square wave with an offset of 1:
</p>
<?php addMobileImageFull('signals_systems/square_wave_even_offset.svg'); ?>
<?php
$counter = appendToQuiz($counter, 'What is the nth Fourier Coefficient \(c_n\) of this signal?',
    array('\(\frac{2}{n\pi}sin(\frac{n\pi}{2})\)', '\(\frac{2}{n\pi}\)', '\(\frac{4}{\pi}\)'), 0);
$counter = appendToQuiz($counter, 'Given the answer above, what is the \(c_0\) coefficient? (hint: take a limit, or approximate \(sin(x)\) as x since x is approaching zero)',
    array('\(2\)', '\(\frac{2}{\pi}\)', '\(1\)'), 2);
?>
<h2>But whatever happened to time?</h2>
<p>
For all of our work on the Fourier series, we have been working with the variable \(x\), but typically, in engineering, we care much more about \(t\), or time. We want to be able to use what we learn on <i>physical</i> problems and signals which exist in the <i>real world</i>, and so we need to be able to deal with functions of time.
</p>
<?php
addLessonNavigationE("lesson2_9.php", "lesson2_11.php", "syllabus.php", "Fourier Series", "Next", "Syllabus");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
