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
<h1>Lesson 1: The Inner Product</h1>
<?php
addLessonNavigation("/signals_systems.php", "shifting_scaling_lesson2.php", "Introduction", "Next");
?>
<h2>How much of my soup is carrots?</h2>
<p>
Imagine you are sitting down to eat a nice warm bowl of soup. That soup is made up of different things - let's say you're a vegetarian and your soup is made up of some broth, peas, and carrots. Maybe your soup happens to be 1/5 carrots, 1/5 peas, and 3/5 broth. We say that your soup can be "decomposed" into its "components" - namely broth, peas, and carrots. All we need to do in order to make some soup (if we ignore the whole cooking part) is just put together the ingredients in the right ratios.
</p>
<h2>Vectors and Soup</h2>
<p>
But it's not just soup that we can decompose into its parts - we can do it with mathematical objects like vectors, too. For example, let's take the vector \(\pmatrix{2 \\ 1}\):
</p>
<?php addMobileImageFull('signals_systems/vector_decomposition.svg'); ?>
<p>
This vector has two <i>components</i> - each along a different axis. To find the component along each direction, we can use the <i>dot product</i>. To find the component along the first axis (call it the \(x\)-axis if you like), we can just take the dot product with the vector \(\pmatrix{1 \\ 0}\). Here I'm using the notation \(\langle a, b\rangle \) to denote the dot product.
</p>
<p>
\(\langle \pmatrix{2 \\ 1}, \pmatrix{1 \\ 0} \rangle = 2*1 + 1*0 = 2\)
</p>
<p>
Just as we can "decompose" our soup into "components", so can we with vectors, using the notion of the dot product. The dot product lets us answer the question "how much of each component is in my vector?"
</p>
<h2>Inner Product vs. Dot Product</h2>
The inner product is an extension of the idea of the dot product to things that aren't vectors (or at least, not at first glance). For regular real-valued vectors, it's exactly the same as the dot product. It tells us how much of something is in something else. For example, while this isn't strictly-speaking mathematically correct, you could take the inner product of soup and carrots:
</p>
<p>
\( \langle soup, carrots \rangle \)
</p>
<p>
Which we can interpret as what fraction of my soup is carrots? If you followed the recipe above, the answer would be 1/5.
</p>
<h2>Inner Product with Functions</h2>
<p>
Just like with soup and vectors, we can use the inner product with functions, to figure out how much of one function is contained in another. This is easiest to describe if we actually do think of functions as vectors. For example, let's take the sinewave over a single period:
</p>
<?php addMobileImageFull('signals_systems/sinewave_single_period.svg'); ?>
<p>
We could turn this into a vector by just taking the value at a bunch of different closely-spaced points. For example, if we took the value at points spaced by , our sinewave and vector would look like this:
<?php addTwoMobileImages('signals_systems/sampled_sinewave.svg', 'signals_systems/sinewave_vector.svg'); ?>
</p>
<p>
If we wanted our vector to be an accurate representation of the function, we would want the points to be really closely spaced together:
<?php addTwoMobileImages('signals_systems/sampled_sinewave_close.svg', 'signals_systems/sinewave_vector_long.svg'); ?>
</p>
<p>
In fact, ideally we'd want the points <i>infinitely</i> close togthere (but we'll come back to that later).
</p>
<p>
Now that we can turn functions into vectors, we can do fun things, like take their dot products. Let's take the dot product of our sinewave with a garden-variety square wave:
<?php addTwoMobileImages('signals_systems/square_wave_single_period.svg', 'signals_systems/square_wave_vector.svg'); ?>
</p>
<p>
But what does taking the dot product here mean? Well, if we make an analogy to vectors, we're asking how much of the square wave 'vector' is along the sinewave 'vector', or how much of this sinewave is contained within the square wave. If we just plot the two together, you can visually see that they are similar, there's a lot of overlap between the two, and the dot product tells us exactly how much overlap.
</p>
<?php addMobileImageFull('signals_systems/sinewave_and_square_wave.svg'); ?>
<p>
Let's take the concrete case where our sample points are spaced apart by \(\pi/5\). If we take the dot product of the two vectors, we get about 6.15. But we've got a bit of a problem. If we want the points to be more closely-spaced, the dot product actually gets bigger. For example, at \(\pi/50\), the inner product is about 63.6. To fix this, we can define the inner product to be the dot product multiplied by the distance between samples, let's call it \(\Delta x\). This means as our samples get closer together, the inner product should stay the same. Twice as many samples means \(\Delta x\) is half as small, leaving the overall inner product the same.

Now what happens as we take the points to get infinitely close together, and we get a more and more accurate representation of our functions? Well, our inner product between the square wave and the sine wave starts to get closer and closer to an integral. If we have a total of \(N\) points we are using to represent these two functions, then our inner product starts off looking like a sum:
</p>
\begin{equation*}
	\sum_{i=0}^{N} sin(\Delta x *i)*sq(\Delta x*i)\Delta x
\end{equation*}
<p>
But as the points get infinitely close together, \(\Delta x\) becomes the infinitesimal \(dx\), and the sum becomes an integral:
</p>

\begin{equation*}
	\int_{0}^{2\pi}sin(x)*sq(x)dx
\end{equation*}
<p>
If you haven't seen this before, it's some really heavy and mind-bending stuff. Let's do a couple examples of the inner product to see how this all works:
</p>
<?php
$counter = 0;
$counter = appendToQuiz($counter, 'What is the inner product between the sinewave and the square wave above, \(\langle sin(x), sq(x)\rangle \)?',
    array('\(2\pi\)','4', '\(\pi\)'), 1);
$counter = appendToQuiz($counter, 'What is the inner product between \(sin(x)\) and \(sin(2x)\), \(\langle sin(x), sq(x)\rangle \), over the period \(0\) to \(2\pi\)?',
    array('0','1', '\(\pi\)'), 0);
?>

<?php
addLessonNavigation("/signals_systems.php", "lesson2.php", "Introduction", "Next");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
