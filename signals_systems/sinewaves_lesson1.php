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
<style>
img .mobileImage {
	width: auto;
	height: auto;
	max-width: 100%;
}
</style>
<h1>Lesson 1: Playing with Sinewaves</h1>
<?php
addLessonNavigation("/signals_systems.php", "lesson2.php", "Introduction", "Next");
?>
<h2>The Humble Sinewave</h2>
<p>
Ah, the humble sinewave. You have likely already met this beast in other coursework, or in a trigonometry
course in primary school. In this class, we are going to get to know it much more intimately. The goal
of this lesson is for you to learn to dance with the sinewave - scale, shift, and squeeze it, and 
understand the basic terminology we use to describe it.
</p>
<p>
First, the most basic version, the one you are probably familiar with - \(sin(x) \), Here, \(x\) is what is called the "total phase" of the sinewave, or "phase" for short. We can plot this equation versus x, and we get your garden-variety sinewave:
</p>
<p>
<img src="/images/sinewave_two_periods.png" align="left" style="width:auto; max-width:100%; height: auto;"/>
The most interesting parts of the sinewave are that it goes from -1 to +1, it is zero at every integer value of \(\pi\), and it is <i>periodic</i>, meaning it repeats itself. In this case, the <i>period</i> of the sinewave is equal to \(2\pi\), since this sinewave repeats itself after we increase the value of \(x\) by \(2\pi\). Notice that in this case, the period is in radians, and doesn't have units of time.
</p>
<h2>Time versus pure radians</h2>
<p>
For most of this course, we will be dealing with functions not of \(x\), but of time (although it will sometimes be convenient to switch back and forth). You might think we write those sinewaves like \(sin(t)\), but then we would have to take the sin() of something with units of seconds, and I'm not sure how to do that. For this reason, sinewaves that are functions of time we write as \(sin(\omega t)\), where \(\omega\) is called the <i>"angular frequency"</i>, and has units of radians per second. That way, when we multiply \(\omega *t\), we get something in radians, and that I know how to plug into a sin() function! This is a common confusion that trips people up. 
</p>
<p>
For example, if we had an angular frequency of \(2\pi\) per second, we could plot that sinewave (to the right).
<img src="/images/sinewave_two_periods_time.png", align="right" 
	style="width:auto; max-width: 100%; height: auto;"/>

Now, instead of radians on the x-axis, we have time, in units of seconds. When the time is equal to 1 second, the total phase of the sinewave \(\omega*t\) is equal to \(2\pi\) / second * \(1\) second \(= 2 \pi\), and the sinewave will have value 0. When time is equal to 0.25 seconds, the phase will be \(\pi/2\), and the sinewave will have a value of 1.
</p>
<h2>Angular Frequency, Period, and Frequency</h2>
<p>
You might be more comfortable and familiar with the <i>period</i> of a sinewave, rather than the angular frequency. We can use either, and since we know that a sinewave repeats itself every time the phase is \(2\pi\), that means that when we plug in one period for \(t\) (let's call it \(T\)), we should get \(2\pi\).
</p>
<p style="text-align:center;">
\(\omega T = 2\pi\)<br>
or<br>
\(T = 2\pi / \omega \)
</p>
<p>
This relates the period of the sinewave and the angular frequency. You might be wondering why we are going through all the trouble of using angular frequency instead of just using the period directly - the period seems like something more physically meaningful - the time after which the signal repeats itself. The main reason has to do with derivatives and integrals. We will be taking lots of both of these, and it's very convenient writing \(sin(\omega t)\), because it's derivative is \(\omega * cos(\omega t)\), rather than \(sin(2\pi t/T)\), whose derivative is \(2\pi /T * sin(2 \pi t / T)\). You can see how after one or two derivatives things can get very messy very quickly.
<br><br>
We also sometimes care about the regular frequency (we will use the symbol \(f\), for <i><b>f</b></i>requency). This is the number of times per second the signal repeats itself, and because it is used so often, it gets its own unit, the Hertz. A sinewave that repeats itself twice in one second has a frequency of 2\(Hz\). In order to repeat itself twice in one second, the period must be 0.5s. In general, the period, in seconds, must be 1 / (# periods per second), or \(1/f\). 
</p>
<p>You might ask - what happens when we increase the frequency? What does the sinewave look like? For example, what happens when we double the frequency?
</p>
<div style="width:100%; overflow: hidden; text-align:center;">
<img src="/images/sinewave_comparison_faster.svg", align="left", style="width: auto; max-width: 100%; height: auto;"/>
</div>
<p>
As you might have guessed, if we plot the function over the same amount of time, we have twice as many periods. Or, if we felt so inclined, we could say the sinewave is changing "twice as fast" (this is actually exactly true if you compute the derivative, it will be twice as large - check!). <i>Frequency</i> (angular or regular) is thus a measure of the <i>speed</i> of the signal, how rapidly it changes in time. Higher frequency &#8594; faster signal. Lower frequency &#8594; slower signal. This theme will recur over and over again. If we wanted to also plot a sinewave at <i>half</i> the frequency, we see that there are fewer periods (only one in two seconds), and it is changing more <i>slowly</i> with time:
</p>
<div style="width:100%; overflow: hidden; text-align:center;">
<img src="/images/sinewave_comparison_slower.svg", align="left" class="mobileImage"/>
</div>

<?php
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
