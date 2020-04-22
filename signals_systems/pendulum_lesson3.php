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
<h1>Lesson 3: The Pendulum System</h1>
<?php
addLessonNavigation("shifting_scaling_lesson2", "linearity_lesson4.php", "Shifting and Scaling", "Linearity");
?>
<p>
In this lesson we are going to meet our first "system" - the simple pendulum.
<h2>The simple Pendulum System</h2>
<p>
In what sense is the pendulum a "system"? What does it even mean to be a system?
</p>
<?php addMobileImage('system_input_output.svg', 'right'); ?>
<p>
A system is anything with an input and an output. An 'input' is usually something we feed in to the system or apply to the system. We typically call this input \(x(t)\). An output we typically think of as the response of the system, and is usually denoted by \(y(t)\). Usually, we know the input, we know what the system is, and we want to find the output. In the case of a pendulum, what are the inputs and outputs? Well, there's a number of way you could define the inputs and outputs, depending on what you are able to control. For us measly mortals, the thing we can control is the force we apply to the pendulum. I can physically walk up to the thing and push it with whatever pattern I please. This will be our input: force. Since it's an input, I'm going to call it \(x(t)\). What should the output be? Let's use position, as this is an output that's relatively easy to understand. Specifically, we will use the angle of the pendulum with respect to the vertical. Since it's our "output", I'm going to call it \(y(t)\), even though that's somewhat odd of a choice for an angle.
</p>
<?php addMobileImage('pendulum_swinging.svg'); ?>
<p>
This isn't a physics class, so we won't worry about the details of how we get the differential equation (but if it's bothering you, give it a try, use the small-angle approximation and divide the force by \(m*g\) to get \(x(t)\)).I've also cleaned this up so x and y don't have units, and left things in terms of the natural frequency \(\omega_0\). It's not important for us except to take care of the units.
</p>
<p style="text-align: center;">\(\frac{1}{\omega_0^2}\frac{d^2y}{dt^2} + y(t) = x(t)\)</p>

<p>
If you haven't seen a differential equaiton in a while, this might look a little awkward, especially since I've been talking about \(y(t)\) as an output, but it doesn't look like we have it explicitly in terms of the "input". Right now, \(x(t)\) can be anything - it could look something like the graph to the right:
</p>
<?php addMobileImage('random_input.svg', 'right'); ?>
<p>
If it did, well, it would be extremely painful to try and solve what the output is by a frontal assault on the differential equation. But after the first part of this course, not only will you be able to solve for the output, but you will often be able to sketch what it looks like, at least roughly, without ever writing down an equation. As if that weren't sweet enough, you will be able, in just <i>one line of code</i>, to find the output. The rest of this course is about understanding that one line of code.
</p>
<p>
So how do we get there? We start simple. Feeding in a random-looking \(x(t)\) into our system didn't get us anywhere, but what if we feed in a sinewave? What will the output look like then? Let's give it a try. Just replace \(x(t)\) by \(sin(\omega t)\) and see if that gets us anywhere.
</p>

<p style="text-align: center;">\(\frac{1}{\omega_0^2}\frac{d^2y}{dt^2} + y(t) = sin(\omega t)\)</p>
<p>
Both the left and the rgiht-hand sides of these equations must be equal, so what's on the left must be equal \(sin(\omega t)\), which involves the output and its second derivative. But remember that taking the derivative of \(sin()\) gives us \(cos()\), and taking the second derivative gives us back \(sin()\) (with a minus sign). So if we want to get the left-hand side equal to the right, the output is probably going to involve a \(sin()\). For now, let's just guess that \(y(t)=sin(\omega t)\). Plugging it in and taking the second derivative (don't forget to multiply by \(\omega\) when differentiating), and grouping terms, we get
</p>
<p style="text-align: center;">\(\left(1-\frac{\omega^2}{\omega_0^2}\right)*sin(\omega t) = sin(\omega t)\)</p>
<p>
So close! We have the right form, we just need to divide the output by \(1-\frac{\omega^2}{\omega_0^2}\) and this equation would be true. This means that our guess was almost correct, the actual output \(y(t)\) would have to be \(1/\left(1-\frac{\omega^2}{\omega_0^2}\right)*sin(\omega t)\). This is actually kind of amazing. Not only is the equation solvable (which you learn to stop taking for granted once you get to graduate school or the real world), but the output is just a <i>scaled</i> version of the input. They are both sinewaves of exactly the same frequency. This turns out to be a property not just of the pendulum, but a huge class of systems which are the subject of this course, called <i>Linear Time-Invariant Systems</i>. This has the cute acronym LTI, which is used all over the place. In general, the sinewave could also be shifted in time, although the math is a little more complex ;). We will see this in a coming example. The other amazing thing is that this works for sinewaves of <i>any frequency</i>. So we didn't just solve one problem, we solved the problem for <i>all possible</i> input sinewaves. If you think about it, you have just solved an infinite number of problems... sounds worthy of an engineering degree to me.
</p>
<p>
For example, if the input frequency was \( \pi \hspace{2pt} rad/s\), and the natural frequency \(\omega_0\) is \(2\pi\hspace{2pt} rad/s\) then the output is roughly \(1.33*sin(\pi t)\). If the input frequency was instead \(4\pi \hspace{2pt} rad/s\) then the output would be roughly \(-0.33*sin(4 \pi t)\). (Just make sure to plug in t in seconds, because I've omitted the units inside the \(sin()\) for clarity). Note there is a minus sign in the second case - that's totally fine. We scale signals by minus signs all the time. This is actually equivalent to delaying the second sinewave by \(\pi\) radians or \(0.25s\).
</p>
<p> In the next section, we are going to delve a little deeper into the property of linearity, and what consequences it has. Before you move on, here's some practice problems to help you nail the material:
</p>
<?php
$counter = 0;
$counter = appendToQuiz($counter, 
	'For the pendulum system, suppose \(x(t)\) is \(0.2 * sin(\omega t)\), with \(\omega = 1/3 \omega_0\). What is the output?',
	array('\(0.33 * sin(\omega_0 t)\)', '\(sin(\omega_0 t)\)', '\(0.225 * sin(1/3\omega_0 t)\)', '\(4*sin(1/3 \omega_0 t)\)'), 2);
$counter = appendToQuiz($counter, 'For the pendulum system, suppose you see that the output \(y(t)\) is \(sin(\omega t)\), with \(\omega=2\omega_0\). What is the input \(x(t)\)?', 
	array('\(3 * sin(2 \omega_0 t)\)', '\(-3 * sin(2 \omega_0 t)\)', '\(4* sin(2 \omega_0 t)\)'), 1);
?>
<?php
addLessonNavigation("shifting_scaling_lesson2", "linearity_lesson4.php", "Shifting and Scaling", "Linearity");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
