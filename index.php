<!DOCTYPE HTML>
<!--
	Phantom by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<?php

echo'<html>';
include $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/head.php";
beginPage();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/header_menu.php";
?>
				<!-- Main -->
<div id="main">
<div class="inner">
<header>
<h1>Welcome to Electrical Engineering</h1><br/>
<p>Here, you will find a resource for your study of electrical engineering,
from an overview of the discipline to online lecture videos, reference material, and practice problems so you can test your knowledge. This site is currently in its early stages and I am working on expanding the content - my hope is for it to expand to cover all commonly-taught courses in Electrical Engineering departments. 
</header>

<section class="tiles">

<article class="style1">
<span class="image">
<img src="images/pic01.jpg" alt="" />
</span>
<a href="explore.php">
<h2>Explore</h2>
<div class="content">
<p>Explore courses, figure out prerequisites, and find out where you stand and what you are missing.</p>
</div>
</a>
</article>

<article class="style3">
<span class="image">
<img src="images/pic03.jpg" alt="" />
</span>
<a href="/computational_em/computational_em.php">
<h2>Computational Electromagnetics</h2>
<div class="content">
<p>Computational Electromagnetics with an open source FDTD simulator. Build on what you know about the theory of electromagnetics by learning to use the Finite Difference Time Domain, one of the most powerful tools for electromagnetics.</p>
</div>
</a>
</article>

<article class="style2">
<span class="image">
<img src="images/pic02.jpg" alt="" />
</span>
<a href="/signals_systems.php">
<h2>Signals and Systems</h2>
<div class="content">
<p>Linear Time Invariant Signals and Systems, Fourier Analysis - become a world-class sinewave manipulator. Learn how the world actually works.</p>
</div>
</a>
</section>

<article class="style4">
<span class="image">
<img src="images/pic04.jpg" alt="" />
</span>
<a href="/analog_circuits/analog_syllabus.html">
<h2>Analog Circuits</h2>
<div class="content">
<p>Ever wondered how computers can switch so fast? Transistors are why. Learn about them here.</p>
</div>
</a>
</section>


<br><br>
<h1>Support this Site</h1>
<p>
The content on this site takes a surprising amount of time to make! (It's typically 2-3 hours per page). While I'm currently doing it in my free time, if I can generate a livable income I might do it full-time for a while, and massively expand the content. The best way to support this work is on Patreon, for which you have my gratitude, acess to my Discord server, and some other neat stuff!
<a href="https://www.patreon.com/bePatron?u=14713334" data-patreon-widget-type="become-patron-button">Become a Patron!</a><script async src="https://c6.patreon.com/becomePatronButton.bundle.js"></script>
</p>

<h1>About This Site</h1>
As an undergraduate in electrical engineering, I loved the curated videos of khan academy. I relied on
them heavily to get me through basic biology, organic chemistry, calculus, and some differential equations and
basic circuits. From there on out, however, there was essentially no content to help me in my electrical
engineering coursework. This frustrated me so much that in my final year of undergrad, I started making those
videos. These are on <a href="https://www.youtube.com/channel/UCEmBUvaW0UhAbPz4IiscKgw">my YouTube channel</a>,
and sprinkled throughout this site. While videos are useful, and probably my favorite medium for learning,
they are not sufficient by themselves. Once you watch a video and generally understand a topic, 
re-watching it all over again when you forget a single concept or equation is frustrating at best. This
is what reference material does exceptionally well, and where the written word beats video hands-down.
Practice, and <i>immediate feedback</i> is probably the most critical for learning and remembering a topic
once you have the basic outline from videos and reference material on hand, but this is not something videos
can give either. This website was created as a one-stop-shop for learning electrical engineering - 
containing lecture videos, reference material, and practice problems with immediate feedback. It is my hope that
this can make the next generation of engineer's educations less painful, more rewarding, and more fun. 

<br><br>

<h1>Get Involved</h1>
<p>
Are you a web developer? Animator? Fellow educator and content creator? Do you have feedback about the content on this site? Find something confusing, think something could be explained more clearly or in less math? Have your own projects you think I could help with? Shoot me an email in the contact form below! 
</p>

<h1>Licensing</h1>
<p>
The whole point of this site is to help people learn, and the broader the material is disseminated, the better, regardless of who does it. For this reason, everything on this site is licensed under the <a href="https://creativecommons.org/licenses/by/4.0/">CC-BY</a> license. This applies to all the written content, graphics, animations, and anything else you might find on this site. Most of the graphics on this site are my own, generated using python or Mathematica. 
</p>

<h1>About Me</h1>
<img src='/images/self_thumbnail.jpg', style="max-size: 100%; width: 20%; height: 20%; float: left; margin-right: 20px; margin-top: 0px;"/>
I am currently a Ph.D. student in the <a href="https://maharbizgroup.wordpress.com/members/">Maharbiz Group</a>
in the <a href="https://eecs.berkeley.edu/">Electrical Engineering and Computer Science</a> department at UC
Berkeley. My Ph.D. focuses on using photonic devices to measure brain activity. When I'm not at work, you'll
find me at the gym, walking around Tilden Park in Berkeley, or making Indian food with my girlfriend. I make some killer naan and Baingan Bharta.
</p>

</div>
</div>

<?php
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
