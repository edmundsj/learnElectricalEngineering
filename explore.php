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
and where do you get started? What if you want to specialize, and get really good at a particular area. Nanoelectronics? Optoelectronics? RF? Circuit design? Signal processing? Computer architecture? How should you direct your tsudy, what courses should you be focusing your energy on? What other coursework and experiences would benefit you? I answer all these questions for common specializations me and my colleagues work in below.
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
as a student. It's also true that even if you want to specialize in a particular area, the fundamentals are still required (there's no getting away from caluclus or differential equations). Without further ado, the fundamentals, in the order they should be learned:
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
	<li><a href="coming_soon.php">Basic Mechanics</a></li>
	<li><a href="coming_soon.php">Electricity and Magnetism</a></li>
	<li><a href="coming_soon.php">Waves and Optics</li>
	<li><a href="coming_soon.php">Basic Quantum Mechanics</a></li>
	</ul>
<li>Basic Circuits</li>
	<ul style="margin-bottom: 0px;">
	<li><a href="coming_soon.php">Analog</a></li>
	<li><a href="coming_soon.php">Digital</a></li>
	</ul>
<li>Core Electrical Engineering Courses</li>
	<ul style="margin-bottom: 0px;">
	<li><a href="signals_systems.php">Signals and Systems</a></li>
	<li><a href="coming_soon.php">Probability Theory</a></li>
	<li><a href="coming_soon.php">Electronics: Device Physics</a></li>
	<li><a href="coming_soon.php">Electronics: From Device to Circuit</a></li>
	<li><a href="coming_soon.php">Electronics: Integrated Circuits</a></li>
	<li><a href="coming_soon.php">Control Systems</a></li>
	<li><a href="coming_soon.php">Engineering Electromagnetics</a></li>
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
<a href="coming_soon.php">Mechanics</a>. Other engineering disciplines rely more heavily on mechanics,
but for electrical engineering, pretty much all you need to be able to do is write down Newton's Laws.
How to actually solve the differential equations that result you will get tons of practice with in
<a href="coming_soon.php">Analog Circuits</a>.
<br><br>

<a href="coming_soon.php">Electricity and Magnetism</a>, however, is critically 
important for electrical engineering (as you might have guessed
from the title). Pretty much whatever you end up doing outside of pure computer science / signal processing
will lean heavily on what you learn in this course. It's probably the single most important class you
will take, as everything else builds on and extends it. Pretty much everything in this class is important.
The concepts of charge, current, and fields will be central in all subsequent classes, as will resistance,
capacitance, and inductance. At some point you will also take a class on <a href="coming_soon.php">Waves and
Optics</a>, where you will learn about waves, and a specific kind of wave, the electromagnetic wave.
This course is more critical for those specializing in RF, circuits, semiconductors, and really anything
that deals with the physical world. Lastly, a short course on <a href="coming_soon.php">Quantum Mechanics</a>
(part of a course on Modern Physics) will prepare you for subsequent classes on device physics and electronics.

</p>

<h2> 3. Circuits </h2>
<p> Once you know the basics of <a href="coming_soon.php">Eletricity and Magnetism</a>, you are ready
to move on to the first set of core EE courses - circuits. Regardless of the domain you end up in,
circuits will haunt (or help) you for the rest of your career. Circuits are split into two distinct categories,
which are usually learned separately - <a href="coming_soon.php">Analog</a> (sometimes called Network Analysis
by older folk)
and <a href="coming_soon.php">Digital</a>. Analog cicruits are an extremely elegant and useful way
to model the <i>physical world</i>, and they are the go-to tool for electrical engineers trying to extract
information from the physical world or send information back into it. The three most famous analog circuit
elements you might have heard of are the resistor, capacitor, and inductor. Analog circuits 
also describe, with stunning
accuracy, how the world works. <a href="coming_soon.php">Digital circuits</a>, on the other hand,
are the fundamental building blocks of computers. They are more abstract than their analog counterparts,
and are a field of study unto themselves. There is no required ordering to these classes.

<h2> 4. Core Electrical Engineering Courses </h2>
<p>
After you have mastered the math, physics, and basic circuits, you are ready to move on to the core
electrical engineering courses. These correspond to what are referred to as "upper-division" courses
at most universities. The first upper-division course you will likely take is 
<a href="coming_soon.php">Electronics: Device Physics</a>. This builds off your mastery of
<a href="coming_soon.php">Electricity and Magnetism</a> and <a href="coming_soon.php">Analog Circuits</a>
coursework, and the whole point of the class is to learn how transistors work, starting from the atom.
It's a behemoth of a course and the most challenging one I took in undergrad. Once you know how the 
transistor works, you can start using it in circuits (for building computers or amplifiers or a dizzying
array of other things). This is the subject of <a href="coming_soon.php">Electronics: From Device 
to Circuit</a>. This is where you build a bridge between how computers and integrated circuits work, and
the underlying physics at work. Finally, you build off this knowledge further in 
<a href="coming_soon.php">Electronics: Integrated Circuits</a>, where you learn how
to build basic integrated circuits from transistors.
<br><br>

The other three courses, <a href="signals_systems.php">Signals and Systems</a>, <a href="coming_soon.php">Control Systems</a>, and
<a href="coming_soon.php">Engineering Electromagnetics</a> can be taken whenever you please, although Signals and Systems should be taken before controls. In Control Systems you will learn how to use <a href="coming_soon.php">Analog</a> and <a href="coming_soon.php">Digital</a> circuits to control physical systems, from motors to airplanes, and how these systems respond to disturbances (a sophisticated way of saying being hit by a hammer). In Electromagnetics, you will learn how the basic concepts you learned in electricity and magnetism can be extended to larger and more complex systems, and how to model and interact with these systems.

</p>

<h1> Specializations </h1>
<p>
As an electrical engineer, you will have to actually <i>do something specific</i> for a living. That 'something specific', if you work as an electrical engineer, is usually in one of the specializations listed below: 
</p>
<h3> <a href="https://en.wikipedia.org/wiki/Optoelectronics">Optoelectronics</a> / <a href="https://en.wikipedia.org/wiki/Photonics">Photonics</a> </h3>
<p>
This is the discipline I am most directly involved in for my Ph.D. work - but what courses do you need to specialize in this area? What skills do you need? Well, a lot. The most commonly-used physics by far is electromagnetism. So you should get really really good at that, and take as many courses as your university offers. 
</p>
<h3><a href="https://en.wikipedia.org/wiki/Power_engineering">Power Engineering</a></h3>
<p>
The creation, distribution, and transformation of power, in our grid, inside individual machines and devices, at pretty much any scale you can imagine. There are power engineers who work on airplanes, cars, the grid, power generation stations, and spacecraft.
</p>
<h3><a href="https://en.wikipedia.org/wiki/Control_engineering">Control Engineering</a></h3>
<p>
The control and automation of robotic systems, mechanical systems, electrical systems, thermal systems. Really anything can be shoved under the domain of controls. This is a heavily mathematical discipline, and (other than communications) probably the most abstract. It also happens to be one of the most interesting and pervasive.
</p>
<h3><a href="https://en.wikipedia.org/wiki/Telecommunication">Communications</a> / Signal Processing</a></h3>
<p>
Along with Controls, probably the most abstract and mathematical of the specializations. Thi
</p>
<h3>RF Engineering</h3>
<p>
</p>
<h3>Circuit Design</h3>
<p>
Usually this refers to <i>integrating circuit design</i>, in contrast to PCB-level circuit design. Integrated Circuit designers work on the individual silicon chips inside phones, computers, toys, and all electronics. Studying circuit design will typically involve an extra few classes in advanced circuits, covering nonlinearity, noise, and most importantly, how to actually build the things.
</p>
<h3>Embedded Systems</h3>
<p>
While not typically thought of as a branch within EE, lots of electrical engineers do work on embedded systems, so I thought to include it here. This encompasses printed-circuit-board level electronics, and refers in general to making electronic systems that interact with the physical world to actuate and control things. You can check out <a href="https://en.wikipedia.org/wiki/Embedded_system">Wikipedia's Article</a> here.
</p>

<h2>My Favorite YouTube Channels</h2>
<ul>

<li><a href="https://www.youtube.com/channel/UCYO_jab_esuFRV4b17AJtAw">3Blue1Brown YouTube Channel</a> - Truly spectacular videos on mathematical concepts, including linear algebra, calculus, the Fourier Series, and more.</li>
<li><a href="https://www.youtube.com/channel/UCq0imsn84ShAe9PBOFnoIrg">Brian Douglas</a> - Excellent YouTube Series on control systems</a></li>
<li><a href='https://www.khanacademy.org/'>Khan Academy</a> - Great videos on calculus, differential equations, and basic physics. They also have some EE content as well.</li>
<li><a href="https://www.youtube.com/channel/UCJ0yBou72Lz9fqeMXh9mkog">Physics videos by Eugene Khutoryansky</a>Spectacular visual videos on Maxwell's equations, circuits, and concepts like the Fourier Series and vectors.</li>
<li><a href="https://www.youtube.com/channel/UC7_gcs09iThXybpVgjHZ_7g">PBS Space Time</a> - The physics nerd in me couldn't <i>not</i> put this channel on this list. Great for learning advanced concepts in physics in a reasobly accessible way.</li>
<li><a href="https://www.youtube.com/watch?v=89NJj1F_qmQ">Map of Electrical Engineering</a> - a fun video describing graphically what I discuss in this page.</li>
</ul>

<h2>My Favorite Textbooks</h2>
<ul>
<li><a href="https://www.amazon.com/Semiconductor-Physics-Devices-Basic-Principles/dp/0073529583">Neamen - Semiconductor Physics</a>. Great textbook for the more mathematically inclined. A fair number of worked examples.</li>
<li><a href="https://www.amazon.com/Semiconductor-Device-Fundamentals-Robert-Pierret/dp/0201543931">Pieret - Semiconductor Devices</a>. Good complement to Neamen, explanations tend to be different and what Neamen does poorly, I think this book does well.</li>
<li><a href="https://www.amazon.com/Signals-Systems-2nd-Alan-Oppenheim/dp/0138147574">Oppenheim - Signals and Systems</a>. Unfortunately I have to list this as my 'favorite' because I haven't found a better one. But I don't love it.
<li><a href="https://www.amazon.com/Introduction-Probability-Statistics-Random-Processes/dp/0990637204/ref=sr_1_7?dchild=1&keywords=probability+theory&qid=1591753580&s=books&sr=1-7">Pishro-Nik Probability Theory</a> - The single best textbook I have ever read. Period stop. It happens to be on probability theory</li>
<li><a href="https://www.amazon.com/Introduction-Thermal-Physics-Daniel-Schroeder/dp/0201380277">Schroeder - Thermal Physics</a>. An excellent textbook on the more hard-core statistical mechanics and thermodynamics typically not taught in EE. Great, accessible book if you want to know more about device physics.
<li><a href="https://www.amazon.com/Engineering-Electromagnetics-Nathan-Ida/dp/3319078054/ref=sr_1_4?dchild=1&keywords=engineering+electromagnetics&qid=1591754002&sr=8-4">Ida - Engineering Electromagnetics</a>. This was the textbook I <i>actually</i> learned electromagnetics from. It's dense, but has tons of worked examples and is extremely comprehensive.</li>
<li><a href="https://www.amazon.com/Diode-Lasers-Photonic-Integrated-Circuits/dp/0470484128/ref=sr_1_1?dchild=1&keywords=coldren+laser+diodes&qid=1591753844&sr=8-1">Coldren - Laser Diodes</a>. kGreat advanced text on optoelectronics and laser physics. Some chapters can get pretty heavy but the early ones have a really good explanation of the fundamentals.
</ul>
<h2>Other Useful Resources</h2>
<?php
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage()
?>
