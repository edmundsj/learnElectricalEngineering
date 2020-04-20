<?php
/*
 * Mathematics and Basic Science Courses:
 * DONE Calculus Math 2A, 2B (differential/integral), 2D (multivariable), 2E (vector)
 * DONE Linear Algebra 3A
 * DONE Differential Equations 3D
 * DONE EECS 145 Complex analysis, linear algebra
 * ? EECS 55
 * DONE Physics 7C, 7D, 7E
 *
 * Engineering Topics Courses:
 * DONE EECS 31, 31L
 * DONE EECS 70A, 70B, 70LA, 70LB
 * DONE EECS 150, 50
 * DONE EECS 170A, 170LA
 * DONE EECS 170B, 170LB
 * DONE EECS 170C, 170LC
 *
 *
 */

echo'<html>';
include $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/head.php";
beginPage();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/header_menu.php";
beginWrapper();
?>

<!-- Main content goes here -->
<h1>Explore Electrical Engineering</h1>
<span class="image main"><img src="images/pic13.jpg" alt="" /></span>
<p>
Are you going to be able to understand what is taught in a particular course? Are you ready
to study device physics? RF? Electromagnetics? What is the coursework path of an electrical engineer,
and where do you get started?
</p>
<p>
This page is intended as a brief guide and reference, which will pull back the curtain on what exactly is
required to be an electrical engineer, what order classes are usually taken in, and what you should 
<i>actually</i> know before attempting some of the material on this site. I am assuming in writing this
you are enrolled in a degree program of some kind, because this is a necessary step to get taken
seriously as an engineer. Like it or not, that's the way things are.
First, you should know that engineering in general, and electrical engineering in particular, 
is an <i><b>extremely</b></i> cumulative discipline. What you learned last semester will usually be necessary
for what you learn this semester, and the more you master the core fundamentals that show up over and
over again, the more competent you will be as an engineer and the more successful you will be
as a student. Without further ado, the fundamentals, in the order they should be learned:
</p>

<h1>The Fundamental Courses</h1>
<ol>
<li>Math
	<ul style="margin-bottom: 0px;">
	<li>Calculus: Differential Calculus &#8594; Integral Calculus &#8594; Multivariable Calculus &#8594; Vector Calculus</li>
	<li>Differential Equations</li>
	<li><a href="signals_systems.php">Fourier Analysis</a></li>
	<li>Linear Algebra</li>
	</ul>
</li>
<li>Physics</li>
	<ul style="margin-bottom: 0px;">
	<li><a href="intro_mechanics.php">Basic Mechanics</a></li>
	<li><a href="intro_em.php">Electricity and Magnetism</a></li>
	<li><a href="intro_waves.php">Waves and Optics</li>
	<li><a href="intro_quantum.php">Basic Quantum Mechanics</a></li>
	</ul>
<li>Basic Circuits</li>
	<ul style="margin-bottom: 0px;">
	<li><a href="intro_analog.php">Analog</a></li>
	<li><a href="intro_digital.php">Digital</a></li>
	</ul>
<li>Core Electrical Engineering Courses</li>
	<ul style="margin-bottom: 0px;">
	<li><a href="electronics_device_physics.php">Electronics: Device Physics</a></li>
	<li><a href="electronics_transistors.php">Electronics: From Device to Circuit</a></li>
	<li><a href="electronics_integrated_circuits.php">Electronics: Integrated Circuits</a></li>
	<li><a href="control_systems.php">Control Systems</a></li>
	<li><a href="electromagnetics.php">Engineering Electromagnetics</a></li>
	</ul>
</ol>


<p>
That's it. Those are the fundamental courses you must 
take to become an electrical engineer. If I counted correctly, there should be 18.
Most universities, on top of these fundamental
courses, will require several electives, which I discuss later.
</p>

<h2>1. Math</h2>
<p>
Personally, I was never a huge fan of math. I was never very good at it in my primary school education,
and it wasn't until the third year of university that I got around to learning basic trigonometry
(yes, I am serious). But math is the language that engineers speak. It's how you communicate with
other engineers, and after awhile, it becomes how you think. If you stay at it long enough, you
will gain enough mastery to find it beautiful. Fortunately, there isn't a huge amount of math to
master. It all basically comes down to a few different techniques - taking derivatives and their
generalizations in multiple dimensions (gradient, curl, divergence), taking integrals, doing Taylor Series
expansions, taking Fourier Transforms, manipulating complex numbers, multiplying matrices and finding
their eigenvalues and eigenvecors,
and doing lots and lots of algebra.
<br><br>

The sequence in which things are taught 
is typically differential calculus &#8594; integral calculus &#8594; multivariable calculus &#8594; 
vector calculus. These must be taken in sequence as they rely on material from the previous courses.
Differential equations can be taken any time after integral
calculus, as can Fourier Analysis. Linear Algebra (depending on how it is taught) can be taken while
taking calculus.
Of these six, Fourier analysis typically isn't taught as its own course, but typically
as part of a course in <a href="signals_systems.php">Signals and Systems</a> 
(also known as Linear Systems, Systems Theory, or LTI Systems Theory).<br/><br/>

While I don't plan on having any math courses as such on this site (with the exception of Fourier analysis),
chances are, if you have taken
the core mathematics courses and are moving on to the core engineering courses, you have forgotten most of
the math you learned in your math courses. This isn't anything to be ashamed of, math as taught
in university is pretty god-awful for the most part and difficult to contextualize and remember.
You will start remembering the math once you start using it, and that's what your physics and
engineering classes are all about.
I will have short reviews of the required mathematics in practice
problems sprinkled as-needed throughout. There are also truly exceptional videos on the subject online,
here are a few of my favorites: <a href="https://www.youtube.com/channel/UCYO_jab_esuFRV4b17AJtAw">Three
Blue One Brown</a>, does a stellar job conveying the intuition behind math with beautiful graphics
(and a lovely voice), <a href="https://www.youtube.com/watch?v=EKvHQc3QEow&list=PL19E79A0638C8D449">Khan
Academy</a>, who I relied on to learn pretty much all my calculus in undergrad.
</p>

<h2> 2. Physics </h2>
<p>
Once you have your basic calculus out of the way (differential and integral calculus), you are ready to
move on to physics. The rest of the math you will probably take while you take your first physics classes.
This will typically start with mechanics, where you will learn Newton's Laws in a course on
<a href="intro_mechanics.php">Mechanics</a>. Other engineering disciplines rely more heavily on mechanics,
but for electrical engineering, pretty much all you need to be able to do is write down Newton's Laws.
How to actually solve the differential equations that result you will get tons of practice with in
<a href="intro_circuits.php">Analog Circuits</a>.
<br><br>

<a href="intro_em.php">Electricity and Magnetism</a>, however, is critically 
important for electrical engineering (as you might have guessed
from the title). Pretty much whatever you end up doing outside of pure computer science / signal processing
will lean heavily on what you learn in this course. It's probably the single most important class you
will take, as everything else builds on and extends it. Pretty much everything in this class is important.
The concepts of charge, current, and fields will be central in all subsequent classes, as will resistance,
capacitance, and inductance. At some point you will also take a class on <a href="intro_waves.php">Waves and
Optics</a>, where you will learn about waves, and a specific kind of wave, the electromagnetic wave.
This course is more critical for those specializing in RF, circuits, semiconductors, and really anything
that deals with the physical world. Lastly, a short course on <a href="intro_quantum.php">Quantum Mechanics</a>
(part of a course on Modern Physics) will prepare you for subsequent classes on device physics and electronics.

</p>

<h2> 3. Circuits </h2>
<p> Once you know the basics of <a href="intro_em.php">Eletricity and Magnetism</a>, you are ready
to move on to the first set of core EE courses - circuits. Regardless of the domain you end up in,
circuits will haunt (or help) you for the rest of your career. Circuits are split into two distinct categories,
which are usually learned separately - <a href="intro_analog.php">Analog</a> (sometimes called Network Analysis
by older folk)
and <a href="intro_digital.php">Digital</a>. Analog cicruits are an extremely elegant and useful way
to model the <i>physical world</i>, and they are the go-to tool for electrical engineers trying to extract
information from the physical world or send information back into it. The three most famous analog circuit
elements you might have heard of are the resistor, capacitor, and inductor. Analog circuits 
also describe, with stunning
accuracy, how the world works. <a href="intro_digital.php">Digital circuits</a>, on the other hand,
are the fundamental building blocks of computers. They are more abstract than their analog counterparts,
and are a field of study unto themselves. There is no required ordering to these classes.

<h2> 4. Core Electrical Engineering Courses </h2>
<p>
After you have mastered the math, physics, and basic circuits, you are ready to move on to the core
electrical engineering courses. These correspond to what are referred to as "upper-division" courses
at most universities. The first upper-division course you will likely take is 
<a href="electronics_device_physics.php">Electronics: Device Physics</a>. This builds off your mastery of
<a href="intro_em.php">Electricity and Magnetism</a> and <a href="intro_analog.php">Analog Circuits</a>
coursework, and the whole point of the class is to learn how transistors work, starting from the atom.
It's a behemoth of a course and the most challenging one I took in undergrad. Once you know how the 
transistor works, you can start using it in circuits (for building computers or amplifiers or a dizzying
array of other things). This is the subject of <a href="electronics_circuits.php">Electronics: From Device 
to Circuit</a>. This is where you build a bridge between how computers and integrated circuits work, and
the underlying physics at work. Finally, you build off this knowledge further in 
<a href="electronics_integrated_circuits.php">Electronics: Integrated Circuits</a>, where you learn how
to build basic integrated circuits from transistors.
<br><br>

The other two courses, <a href="control_systems.php">Control Systems</a> and 
<a href="electromagnetics.php">Engineering Electromagnetics</a> can be taken whenever you please. They
build off of what you learned in <a href="signals_systems.php">Signals and Systems</a> and 
<a href="intro_em.php">Electricity and Magnetism</a>, respectively. In Control Systems you will learn
how to use <a href="intro_analog.php">Analog</a> and <a href="intro_digital.php">Digital</a> circuits
to control physical systems, from motors to airplanes, and how these systems respond to disturbances
(a sophisticated way of saying being hit by a hammer). In Electromagnetics, you will learn how the 
basic concepts you learned in electricity and magnetism can be extended to larger and more complex systems,
and how to model and interact with these systems.

</p>

<h2>Helpful Resources</h2>

<a href="https://www.youtube.com/watch?v=89NJj1F_qmQ">Map of Electrical Engineering</a> - a fun
video describing graphically what I discuss in this page.

<?php
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage()
?>
