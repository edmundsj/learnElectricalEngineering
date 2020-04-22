<?php

echo'<html>';
include $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/head.php";
beginPage();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/header_menu.php";
beginWrapper();
?>

<!-- Main content goes here -->
<h1>Signals and Systems</h1>
<span class="image main"><img src="/images/pic13.jpg" alt="" /></span>
<h1>Lesson 4: Linearity</h1>
<?php
addLessonNavigation("pendulum_lesson3.php", "lesson5.php", "Pendulum System", "Next");
?>
<p>
In this lesson, we are going to delve a little deeper into the property of linearity. It will underlie pretty much all the work we do in the future, and I hope will help you see how we might break up a complicated problem into a bunch of solvable ones.
</p>
<h2>Linearity: Huh?</h2>
<p>
In the last lesson we studied the pendulum, and we saw that if we fed in a sinewave as an input to the system, we got out a scaled sinewave of exactly the same frequency at the output. We also figured out what that scaling factor was for all possible frequencies. You might then ask the question - if we can put in sinewaves of any possible frequency, can we put in <i>multiple</i> sinewaves of different frequencies at the same time? What does the output look like then? After all, we solved the problem for an infinite number of sinewaves, we might as well try to make something of that. Well, let's just try to solve the pendulum's differential equation again - what if this time \(x(t) = sin(\omega_1 t) + sin(\omega_2 t)\), where \(\omega_1\) and \(\omega_2\) are different frequencies? For example, maybe \(\omega_1\) is \(2\pi\hspace{2pt} rad/s\) and \(\omega_2\) is \(\pi\hspace{2pt} rad/s\).
</p>
<p style="text-align: center;">\(\frac{1}{\omega_0^2}\frac{d^2y}{dt^2} + y(t) = sin(\omega_1 t) + sin(\omega_2 t)\)</p>

<p>
A natural guess might be that \(y(t)\) is just the same thing as the input: \(sin(\omega_1 t) + sin(\omega_2 t)\). That strategy worked well for us last time, let's try it out. Differentiating and grouping terms, we see that the differential equation becomes:
</p>
<p style="text-align: center;">\(\left(1-\frac{\omega_1^2}{\omega_0^2}\right)*sin(\omega_1 t) + \left(1 - \frac{\omega_2^2}{\omega_0^2}\right)*sin(\omega_2 t) \stackrel{?}{=} sin(\omega_1 t) + sin(\omega_2 t)\)</p>
<p>
Doh! So close again! This time, we need to scale the first sinewave and the second sinewave by different amounts in order for this equation to be true. But you'll notice that the coefficient we need to scale by is <i>exactly the same as if we had solved the problem for the two sinewaves separately</i>. 
</p>
<p>In the case of the first sinewave \(sin(\omega_1 t)\), if we had fed it into our system all by itself, we need to scale the output by \(1/\left(1 - \frac{\omega_1^2}{\omega_0^2}\right)\). If we fed in the second sinewave, \(sin(\omega_2 t)\) by itself, we would need to scale the output by \(1/\left(1- \frac{\omega_2^2}{\omega_0^2}\right)\). If we feed in both of these sinewaves together, the output is just the sum of the outputs we would get if we fed them in separately. This property is called <i>linearity</i>. But this property doesn't just work for sinewaves - it actually works for <i>any</i> inputs to the system and their corresponding outputs. We can illustrate this with the block diagrams we used before. If we feed our linear system some signal (call it \(x_1(t)\) because we are creative like that), and we feed the same system another signal as its input (call it \(x_2(t)\) in keeping with the theme), then if we feed in a signal \(x_1(t) + x_2(t)\), we get the sum of the corresponding outputs:
</p>
<p>Feed the system \(x_1(t)\):</p>
<?php addMobileImageFull('system_x1.svg'); ?>
<p>Feed the system \(x_2(t)\):</p>
<?php addMobileImageFull('system_x2.svg'); ?>
<p>Feed the system \(x_1(t) + x_2(t)\):</p>
<?php addMobileImageFull('system_x1_plus_x2.svg'); ?>
<p>
And we need not stop there. We could add an \(x_3(t)\), \(x_4(t)\), and so on, and so on. Linearity works for as many signals as you want to shove into a system. This is called the "addivity" property if you would like to be pedantic - but no self-respecting engineer will remember that (I had to look it up!).
</p>
<p>Linear systems also have another critical property which might not be immediately obvious - if you scale the input to a linear system, the output is scaled by exactly that much. This is the "scaling" or "homogeneity" property of linear systems. This makes sense if you think of linear systems as containing a bunch of derivatives: the derivative of \(x\) is \(1\), and \(2x\) is \(2\), and so on. Multiplying by some constant just multplies the derivative by that same constant. We can sum up this property in a diagram, too: 
</p>
<?php addMobileImageFull('system_scaling.svg'); ?>
<p>
These properties allow us to be very clever in how we handle linear systems. When we use some signals as inputs (sinewaves and their cousins, the exponentials), the resulting equations are very easy to solve. If we can somehow break up the signals we are <i>really</i> interested in (like that horrible mess I showed you in the previous lesson) into a sum of sinewaves, we can solve those problems one by one for each sinewave and then sum them at the output. But I'm getting ahead of myself. First, we need just one more mathematical tool - the complex exponential. In the meantime, here's some practice problems to chew on:
</p>

<?php
$counter = 0;
$counter = appendToQuiz($counter, 'If when the input to a linear system is \(sin(\omega t)\) the output is \(0.5*sin(\omega t)\), then what is the output when the input is \( 2 * sin(\omega t)\)?',
	array('\(2*sin(\omega t)\)', '\(sin(\omega t)\)', '\(0.25*sin(\omega t)\)'), 1);
$counter = appendToQuiz($counter, 'Say we feed in the sum of two scaled sinewaves of different frequencies into our pendulum system,\(3*sin(\omega_1 t) - 0.75*sin(\omega_2 t)\), with \(\omega_1=2\omega_0\) and \(\omega_2 =0.5\omega_0\). What is the output? ',
	array('\(0.5*sin(\omega_1 t) + 0.5*sin(\omega_2 t)\)','\(-sin(\omega_1 t) + sin(\omega_2 t)\)',
	'\(2*sin(\omega_1 t) + 1.5 * sin(\omega_2 t)\)'), 1);
?>
<?php
addLessonNavigation("/signals_systems.php", "lesson2.php", "Introduction", "Next");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
