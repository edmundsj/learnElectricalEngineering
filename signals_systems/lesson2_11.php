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
<h1>Lesson 11: The Fourier Series with Time</h1>
<?php
addLessonNavigationE("lesson2_10.php", "lesson2_12.php", "syllabus.php", "Fourier Series", "Next", "Syllabus");
?>
<h2>What about time?</h2>
<p>
Up to this point, we have only been dealing with the variable \(x\). This makes the math a lot simpler, and this means we don't need to carry around unnecessary extra variables. But we're engineers, we care about <i>time</i>, not abstract variables. For example, let's say we have an (odd) square wave with a period of 2 seconds:
</p>
<?php addMobileImageFull('signals_systems/square_wave_period_2s.svg'); ?>
<p>
How can we use what we've learned about the Fourier Series to represent <i>this</i>? Well, in all our previous work we used sinewaves, cosines, and complex exponentials whose frequencies were <i>integer multiples</i> of the signal's frequency we were interested in. This is exactly what we do here. Instead of starting with \(sin(x), cos(x)\), or \(e^{jx}\), we start with \(sin(\omega_0 t), cos(\omega_0 t)\), or \(e^{j \omega_0 t}\), where \(\omega_0\) is the frequency of our periodic signal, called the <i>fundamental</i> frequency. In the case of the square wave above, \(\omega_0\) is \(\pi\) rad/s. 

<p>
If you prefer that in math language, all we need to do is make the variable substitution \(x=\omega_0 t\) and everything will fall into place (and I suggest you show that the following sections are true this way!).
</p>
<h2>Re-interpreting the Fourier Coefficients</h2>
<p>
Now, the first Fourier Coefficient corresponds to a signal with the <i>same</i> frequency of our signal (as before), the second Fourier coefficient twice the frequency (\(2\omega_0\)), the third coefficient \(c_3\) three times our signal's frequency \(3\omega_0\), and so on.
</p>
<h2>Inner Products</h2>
<p>
The inner product barely changes at all - instead of integrating over \(x\), we are integrating over time. This means to integrate over one period (which is how we defined the inner product for periodic signals), we need to integrate from \(t=0\) to \(t=T\) (where \(T\) is the period of the signal \(f(t)\)). We could also integrate from \(-T/2\) to \(T/2\) or \(-T/4\) to \(3T/4\). It doesn't matter as long as we capture a full period. We still need to complex conjugate the second signal (in case it is complex, as it often is).
</p>
\begin{equation}
\langle f(t), g(t) \rangle = \int_{0}^{T}f(t)g^*(t)dt
\end{equation}
<h2>Fourier Coefficients</h2>
<p>
Computing the Fourier Coefficients is pretty much what you might expect as well. Instead of dividing by the period \(P\), as we did before (which was almost always \(2\pi\) in the exmaples we used), we need to divide by the period in time \(T\):
</p>
\begin{equation}
c_n = \frac{1}{T}\langle f(t), e^{j\omega_0 n t} \rangle
\end{equation}
<p>
And that's it! Basically, replace \(x\) with \(\omega_0 t\), \(P\) with \(T\), and you're done! 
</p>
<p>
(technically, the second substitution is a consequence of the first, because \(dx\) becomes \(\omega_0 dt\), but that's being a bit pedantic).
</p>
<?php
$counter = 0;
$counter = appendToQuiz($counter, 'For the square wave above, what frequency sinewave does the \(b_3\) coefficient correspond to?',
    array('\(3 rad/s\)', '\(4 Hz\)', '\(1 rad/s\)'), 0);
$counter = appendToQuiz($counter, 'For the square wave above, what frequency complex exponential does the \(c_{-5}\) coefficient correspond to?',
    array('\(5 rad/s\)', '\(4 Hz\)', '\(- 5 rad/s\)'), 2);
?>
<p>
This last example is a little tricky - unlike sinewaves and cosines, complex exponentials <i>can have negative frequencies</i>. You can physically interpret this as counterclockwise vs. clockwise rotation in the complex plane. Real signals are made up of both positive and negative frequency complex exponentials (this is what people mean when they say 'positive frequency' and 'negative frequency'). Let's do one more example to get you a little more comfortable with signals that are functions of time.
</p>
<?php

$counter = appendToQuiz($counter, 'What are the coefficients \(c_0, c_1\), and \(c_{-1}\) for the square wave above?',
	array(
	'\(c_0 = 0, c_1 = \frac{2}{\pi}, c_{-1} = \frac{2}{\pi}\)', 
	'\(c_0 = 0, c_1 = -\frac{2i}{\pi}, c_{-1} = \frac{2i}{\pi}\)', 
	'\(c_0 = 1, c_1 = -\frac{4}{\pi}, c_{-1} = \frac{4}{\pi}\)', 
	),
	1);
$counter = appendToQuiz($counter, 'What frequencies do the \(c_0, c_1\), and \(c_{-1}\) coefficients correspond to?',
	array(
	'\(c_0: 0\, rad/s, c_1 = 3\, rad/s, c_{-1} = 3\, rad/s \)', 
	'\(c_0: 1\, rad/s, c_1 = -\pi\, rad/s, c_{-1}: \pi\, rad/s \)',
	'\(c_0: 0\, rad/s, c_1 = \pi\, rad/s, c_{-1}: -\pi\, rad/s \)'
	),
	2);
?>
<h2>Units, Energy, and Power</h2>
<p>
You might have noticed now that things are starting to have <i>units</i>. For example, if our signals themselves are unitless, then inner products now have units of <i>time</i>, because \(dt\) has units of time. That's kind of interesting. This means that energy also has units of time. Average power, which is just the energy over a period divided by the period, is unitless. The Fourier Coefficients, which have units of 1/time * time, are also unitless. This last one is fortunate, because if we want to <i>create</i> unitless signals from a weighted sum of unitless signals (like \(sin()\) and \(cos()\)), the coefficients we are multiplying by better be unitless too! What does this mean? I thought energy had units of Joules and power had units of Watts!
</p>
<p>
The short, glib answer is that <a href="https://en.wikipedia.org/wiki/Energy_(signal_processing)">energy in signal processing</a> is different from energy in physics - energy in the context of pure signals can have pretty much whatever units it wants (if the signals are unitless, then it will have units of time, but they don't have to be unitless!) Energy in the context of pure signals is best interpreted as <i>the ability of the signal to carry information</i>. More energy means you can fit more information in your signal (and be more robust to noise). If the signal <i>does</i> represent a physical process, however, then we <i>can</i> convert it to physical energy.
</p>
<p>
For example, we can have a signal that has units of volts or amps. Then, the 'signal energy' would have units of \(V^2 * s\) (volts squared seconds). All we need to do to convert from 'signal energy', to 'physical energy' is divide by the impedance the signal is being measured across (remember that voltage is always measured 'across' some element). If we are interested in the energy delivered by a source, this would be the <a href="https://en.wikipedia.org/wiki/Th%C3%A9venin%27s_theorem">Thevenin impedance</a>.
</p>
<h2>Wrapping up the Fourier Series</h2>
<p>
To wrap up this section, let's do a real-world example
</p>
<?php
addLessonNavigationE("lesson2_8.php", "lesson2_10.php", "syllabus.php", "Fourier Series", "Next", "Syllabus");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
