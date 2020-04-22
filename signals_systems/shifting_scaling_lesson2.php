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
<h1>Lesson 2: Shifting and Scaling Signals</h1>
<?php
addLessonNavigation("sinewaves_lesson1.php", "pendulum_lesson3.php", "Sinewaves", "Pendulum System");
?>
<h2>Scaling signals (a.k.a. multiplying)</h2>
<p>
For some reason, the powers that be have decided that we need extra terminology for manipulating signals (functions), on top of what mathematicians have already given us. So when I say 'scaling' a function, all I mean is multiplying by some constant. For example, scaling \(f(x)\) by \(0.4\) just gives the expression \(0.4*f(x)\). It's just multiplication.
</p>
<h2>Adding (DC) offsets to signals</h2>
<p>
Similarly, we also have terminology for adding a constant to signals - we call this adding an "offset" or a "DC offset" (the 'DC' comes from electrical engineering terminology, it's how we refer to constants). So "adding a DC offset of \(2\) to \(sin(\omega t)\)" just means we add \(2\) to \(sin(\omega t)\). In other words, our new expression after the offset was added is \(2 + sin(\omega t)\). The reason we call this an "offset", is because typically, the signals we are interested in vary with time. If we add a constant to it, it's as if we are grabbing the function and raising it up a little bit, or adding an "offset" that wasn't there before. See what this looks like below for a sinewave with a period of 1 second, being given an offset of +2:
</p>
<?php addMobileImageFull('sinewave_offset_comparison.svg'); ?><br>
<h2>Shifting: Delaying and Advancing Signals</h2>
<p>
Adding offsets and scaling signals is fairly straightforward, but shifting them is a little more subtle, especially when time gets involved. Suppose we want to <i>'delay'</i> a sinewave with a frequency of \(1Hz\) by \(0.2s\). First of all, what does this mean? If you are delayed in getting to your friends house, it means you get to your friend's house at a <i>later time</i> than your friend expected (and will likely have to apologize for the offense). So it is with signals. If we delay a sinewave by \(0.2s\) we expect that everything will happen a little later (in particular, one that is easy to check is that it intersects the zero axis \(0.2s\) later than we expect).
</p>
<p>
<?php addMobileImage('sinewave_with_delay.svg'); ?>
In the figure plotted on the left, the orange sinewave is delayed by \(0.2s\) compared to the blue one. We are 'pushing' everything to a later time. But how do we write this mathematically? You might think that whatever \(t\) is, we just replace that with \(t + 0.2s\). Not so! We actually replace it with \(t - 0.2s\). The reason for this is that we know we want the sinewave to intersect the origin at \(t=0.2s\). You can check on the figure to the right that delaying the sinewave by this amount of time causes it now to intersect the origin at a later time. In order for this to happen, we need the thing inside the \(sin()\) function to be zero, because \(sin(0) = 0\). The only way we can do this is by subtracting \(0.2s\) from whatever the current time is. This way, when \(t=0.2s\), \(sin(\omega (t - 0.2s))=sin(\omega(0.2s - 0.2s)) = sin(0) = 0\), just as we wanted.
</p>
<p>
In contrast, <i>'advancing'</i> a signal is just the opposite of a delay - everything now happens at an earlier time than it would without the <i>'advance'</i>. You can see what this looks like in a plot to the right, where the orange signal is advanced by \(0.2s\) compared to the blue one.
<?php addMobileImage('sinewave_with_advance.svg', 'right') ?>
</p>
<p>
Now, we have exactly the opposite case - and you might guess how we treat it mathematically. Everything that used to be a \(t\) we just replace by \(t + 0.2s\). The trick I use for remembering 'advancing' versus 'delaying', and how to write them with math, is that delaying is usually a <i>negative</i> thing, and so requires a minus sign. Advancing, on the other hand, is a positive thing, and so requires a plus sign. Ever been paid in advance without requesting it? Feels good!
</p>
<p>
So far we have been dealing with sinewaves that have been delayed and advanced, but <i>any</i> signal can be delayed or advanced. If we have some function of time \(f(t)\), in order to delay it, say by \(0.2s\) as we did before, we just replace every occurence of t with \(t-0.2s\). So if \(f(t) = 2*t - t^2\) (please ignore the fact that the units might want to make you scream), then we would delay it by writing \(f(t-0.2s) = 2*(t-0.2s) - (t - 0.2s)^2\). We can also delay things when they aren't functions of time, but some other variable x. If we want to delay \(sin(x)\) by \(\pi\) radians, we just write \(sin(x-\pi)\). Same with any other variable. We still call it a 'delay' even though time doesn't show up anywhere - that's just the terminology.

<?php
$counter = 0;
$counter = appendToQuiz($counter, 'If I delay a sinewave by 0.2rad, where will it intersect the origin?',
	array('0.2 rad plus any multiple of \(\pi\)', '-0.2 rad plus any multiple of \(\pi\)', '0', '0.2'), 0);
$counter = appendToQuiz($counter, 'What is the correct way of writing a sinewave that has been delayed by a phase of 0.5 rad?',
	array('\(sin(x - 0.5)\)', '\(sin(x + 0.5)\)', '\(sin(0.5 - x)\)', '\(sin(0.5 + x)\)'), 0);
$counter = appendToQuiz($counter, 'What is the correct way of writing a sinewave that has been advanced by a phase of 1 rad?',
	array('\(sin(x - 1)\)', '\(sin(x + 1)\)', '\(sin(1 - x)\)', '\(sin(x)\)'), 1);
$counter = appendToQuiz($counter, 'What is the correct expression for a sinewave scaled by 0.5, and then given an offset of +1?',
	array('\(1 + 0.5*sin(x)\)', '\(0.5*sin(x + 1)\)', '\(0.5 + sin(x + 1)\)', '\(sin(x)\)'), 0);
$counter = appendToQuiz($counter, 'What is the correct expression for a sinewave given a +1 offset, and then the whole thing is scaled by 0.5?',
	array('\(1 + 0.5*sin(x)\)', '\(0.5 + 0.5*sin(x)\)', '\(0.5 + sin(x + 1)\)', '\(sin(x)\)'), 1);
?>
<?php
addLessonNavigation("sinewaves_lesson1.php", "pendulum_lesson3.php", "Sinewaves", "Pendulum System");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
