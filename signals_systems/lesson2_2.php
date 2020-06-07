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
<h1>Lesson 2: Orthogonal Functions</h1>
<?php
addLessonNavigationE("lesson2_1.php", "lesson2_3.php", "syllabus.php", "Inner Product", "Next", "Syllabus");
?>
<h2>Wait, functions can be orthogonal?</h2>
<p>
Yes! In the last lesson on <a href="lesson2_1.php">the inner product</a>, we saw that we can extend the idea of the <a href="https://en.wikipedia.org/wiki/Dot_product">Dot product</a> to the <a href="https://en.wikipedia.org/wiki/Inner_product_space">inner product</a>, which lets us ask questions like: how much of one <i>function</i> is contained within another? But just as vectors can be orthogonal to each other, so too can <i>functions</i>. For vectors, recall orthogonality just means they point in completely different (orthogonal) directions, like these vectors \(\overrightarrow{a}\) and \(\overrightarrow{b}\) below:
</p>
<?php addMobileImageFull('signals_systems/orthogonal_vectors.svg'); ?>
<p>
We can <i>test</i> whether two vectors are orthogonal by taking their dot product - if that dot product is zero, then the vectors are said to be orthogonal. Same for functions, but replace 'dot product' with 'inner product'. We can get some intuition for what it means for signals to be 'orthogonal' with a couple examples:
</p>

<?php addMobileImageFull('signals_systems/orthogonal_rectangles.svg'); ?>
<?php
$counter = 0;
$counter = appendToQuiz($counter, 'What is the inner product of the two functions above (one plotted in orange, the other blue)?',
	array('\(0\)', '\(\pi\)', '2'), 0);
?>
<h2>Solution</h2>
<p>
We can use the definition of the inner product, which is just the integral of the two functions multiplied together. But since the function in blue is zero when the function in orange is 1, and vice versa, multiplying the two together is zero everywhere, so the inner product must be zero.
</p>
<h2>Trading-off being Zero</h2>
<p>
From this example we can see one condition that lets functions be orthogonal - if one is zero when the other is not, and vice versa. This kinda make sesnse, because each function never 'sees' the other one. They never have any common ground, and so they are orthogonal. But there's other cases when functions can be orthogonal, too, even if they have some overlap:
<?php addMobileImageFull('signals_systems/orthogonal_squarewave_constant.svg'); ?>
</p>
<?php
$counter = appendToQuiz($counter, 'Find the inner product of the two functinos plotted above (one in orange, the other blue). What is its value?',
	array('2', '0.5', '0'), 2);
?>
<h2>Solution</h2>
<p>
If we multiply the two functions together, we just get a scaled version of the original squarewave. But the positive parts are exactly canceled out by the negative parts, so the inner product is zero. This shows us another way two functions can be orthogonal, if the positive parts of the inner product <i>cancel</i> the negative ones. One interesting inner product, which was an example in the previous lesson, is sinewaves of different frequencies, for example, \(sin(x)\) and \(sin(2x)\). It turns out that these functions are orthogonal, too. The reason for this is <i>exactly</i> the same as in the example above - when you multiply the two functions and integrate, the positive parts are exactly canceled out by the negative ones.
</p>
<p>
In fact, it turns out that the inner product of \(sin(x)\) with <i>any</i> other sinewave with an integer multiple of the save frequency (so \(sin(2x), sin(3x)\), etc.) is orthogonal to \(sin(x)\). This will turn out to be very useful, because it means you can build <i>very</i> interesting things out of sinewaves. In fact, it turns out you can build <i>anything</i>. 
</p>
<?php
addLessonNavigationE("lesson2_1.php", "lesson2_3.php", "syllabus.php", "Inner Product", "Next", "Syllabus");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
