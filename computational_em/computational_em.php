<?php

echo'<html>';
include $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/head.php";
beginPage();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/header_menu.php";
beginWrapper();
?>

<!-- Main content goes here -->
<h1>Computational Electromagnetics with MEEP</h1>
<span class="image main"><img src="/images/pic13.jpg" alt="" /></span>
<h1>Introduction to Computational Electromagnetics with MEEP</h1>
<?php
addLessonNavigation("computational_em.php", "lesson1.php", "Introduction", "Getting Started");
?>
<h2>Who needs computation, anyway?</h2>
<p>
While you can get far (really really far) with theoretical electromagnetics alone, often you have a simple analytic model that works great, but you want to model some added complexity that would be difficult to do analytically "So how do things change when I add this little bump right here... What if this was sitting next to this other object... ? What if this structure is finite instead of infinite?". It's these kinds of questions that computational electromagnetics allows us to answer. In this course we will be working with MEEP, a Finite Difference Time Domain electromagnetics simulator.
</p>
<h2>Why FDTD? Flexibility vs. Speed</h2>
<p>
There is a saying I'm not so fond of as a cat lover - there are many ways to skin a cat. So too with computational electromagnetics. For a given problem, there are usually many different ways to solve it. How do you know which way to solve your problem? Usually, there is a trade-off between <i>speed</i> and <i>flexibility</i>. There are lots of specialized, very fast, very accurate methods which can be used to solve specific problems. Want to know the reflection coefficient from a planar stack of materials? You should probably use the Transfer Matrix Method (also known as the Scattering Matirx Method). This is blazingly fast, but it's limited to this specific problem. Want to simulate reflection off photonic crystals, or find what happens when you shine light on a diffraction grating? Rigorous Coupled Wave Analysis can do that for you. Also extremely fast, but can only simulate stacks of periodic structures. Need to know how small spheres and infinite cylinders scatter light? Look no further than Mie theory. Want to simulate optical systems like lenses, apertures and mirrors, when the angles are small? Fourier Optics will blaze through that no problem. Want to find the mode of a 2D waveguide? The Finite Difference Frequency-domain method is your best friend. There are <i>many</i> such problem-specific theories and frameworks, all of which have their own set of problems for which they are extremely well-suited. One method, however, which can be used for pretty much any problem, and is a great method-of-last-resort, is the Finite Difference Time Domain method (FDTD). It's also a <i>fantastic</i> method for learning about electromagnetics and building intuition, because you get to see what is happening in real-time as charges move and fields propagate through space. You get to see <i>why</i> standing waves occur, what reflection actually looks like, how fields diffract, and much more.
</p>
<h2>Why MEEP?</h2>
<p>
In this course, we will be using <a href="https://meep.readthedocs.io/en/latest/">MEEP</a> (this cute name stands for MIT Electromagnetic Equation Propagation). Why? Well first of all, it's a <i>free</i>, unlike its paid-for counterparts (like <a href="https://www.lumerical.com/">Lumerical</a>). It's also pretty widely used in academia, open-source (for those of you that care), and its interface is written in <i>python</i>, one of the easiest-to-learn-and-use programming languages on the planet. It's also impressively full-featured, with fancy stuff like nonlinear optics, a frequency-domain solver, a photonic band structure solver, and lots more.
</p>
<p>
The only major stumbling I have run into is the lack of learning materials. There is pretty extensive documentation on the <a href="https://meep.readthedocs.io/en/latest/">MEEP Documentation page</a>, and while very useful and impressively complete, it seems to be written for people with graduate-level physics mastery and intermediate-level python expertise. If you know what you are doing, you can probably find what you need in the documentation, but I found the learning curve to be extremely steep - and I'm a Ph.D. student in Optoelectronics. Through my own stumbling through learning to use MEEP I created this course, which (once it is complete) is probably equivalent to a one- or two-semester lab course on computational electromagnetics. My hope is that it makes electromagnetics simulation accessible at the undergraduate level. For this reason, I have relied primarily on simple examples that students can check analytically themselves (propagation through space, reflection off an interface, thin-film interference), and then build up to more complex examples that would be impossible to do by hand.
</p>
<h2>Prerequisites</h2>
<p>
I do expect you have had an upper-division course on engineering electromagnetics, or the equivalent in the physics department. You know what a plane wave is, how plane waves reflect off interfaces, and are maybe at least a little familiar with waveguides. You also should be at least somewhat familiar with python, as that is the language we will be doing everything in. If you are not familiar, there are excellent tutorials on <a href="https://realpython.com/python-first-steps/">Real Python</a> which can get you up to speed very quickly. We won't be using anything super advanced - basic functions, and a couple of things from numpy (arrays) and matplotlib (for animation). 
</p>
<h2>What this course is not</h2>
<p>
This course is not one on how to <i>create</i> electromagnetics simulators. I might do this in the future, but in the meantime, Professor Raymond Rumpf has some great ones at <a href="https://empossible.net/">his website</a> which I have followed to create a <a href="https://github.com/edmundsj/RCWA">Rigorous Coupled-Wave Analysis Solver</a> and a <a href="https://github.com/edmundsj/TMM">Transfer Matrix Method solver</a>. 
</p>

<?php
$counter = 0;
$counter = appendToQuiz($counter, 'A quiz question',
	array('A quiz option'), 0);
?>
<?php
addLessonNavigation("/computational_em/computational_em.php", "lesson2.php", "Introduction", "Getting Started");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
