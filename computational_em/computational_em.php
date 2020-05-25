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
<p>
While you can get far (really really far) with theoretical electromagnetics alone, there's nothing quite like being able to watch electromagnetic fields move through space with your own eyes. It's also often the case that you build a simple analytic model that works great, but you want to model some added complexity that would be difficult to do analytically "So how do things change when I add this little bump right here... What if this was sitting next to this other object... ?". It's these kinds of questions that computational electromagnetics allows us to answer. 
</p>
<h2>Flexibility vs. Speed</h2>
<p>
There is a saying I'm not so fond of as a cat lover - there are many ways to skin a cat. So too with computational electromagnetics. For a given problem, there are usually many different ways to solve it. How do you know which way to solve your problem? Usually, there is a trade-off between <i>speed</i> and <i>flexibility</i>. There are lots of specialized, very fast, very accurate methods which can be used to solve specific problems. Want to know the reflection coefficient from a planar stack of materials? You should probably use the Transfer Matrix Method (also known as the Scattering Matirx Method). This is blazingly fast, but it's limited to this specific problem. Want to simulate reflection off photonic crystals, or find what happens when you shine light on a diffraction grating? Rigorous Coupled Wave Analysis can do that for you. Also extremely fast, but can only simulate stacks of periodic structures. Need to know how small spheres and infinite cylinders scatter light? Look no further than Mie theory. Want to simulate optical systems like lenses, apertures and mirrors, when the angles are small? Fourier Optics will blaze through that no problem. Want to find the mode of a 2D waveguide? The Finite Difference Frequency-domain method is your best friend. There are <i>many</i> such problem-specific theories and frameworks, all of which have their own set of problems for which they are extremely well-suited. The one method, however, which can be used for pretty much any problem, and is a great method-of-last-resort, is the Finite Difference Time Domain method (FDTD). It's also, fortunately, a pretty good starting method because it is based off the actual time-domain Maxwell's equations.
</p>
<h2>MEEP What?</h2>
<p>
Enter <a href="https://meep.readthedocs.io/en/latest/">MEEP</a> (this cute name stands for MIT Electromagnetic Equation Propagation). It's a free, open-source FDTD software package used very widely in academia, which has a pretty impressive suite of features. It's actively maintained and also written in python, one of the most beautiful software languages to ever grace this earth.
</p>
<p>
The only major stumbling is the MEEP documentation. It's all <i>there</i>, but it's written for people with graduate-level physics mastery. If you know exactly what you are looking for, you can find it in the documentation, but I found the learning curve to be extremely steep, with little in the way of pedagogical resources to lean on. I found this endlessly frustrating and myself wasting a great deal of time - and so decided to document my struggles in an engineering-friendly form. Hence this course.
</p>
<h2>Prerequisites</h2>
<p>
I do expect you have had an upper-division course on engineering electromagnetics, or the equivalent in the physics department. You know what a plane wave is, how plane waves reflect off interfaces, and are maybe at least a little familiar with waveguides. You also should be at least somewhat familiar with python, as that is the language we will be doing everything in.
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
