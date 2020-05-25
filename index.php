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
<p>Here, you will find a comprehensive resource for your study of electrical engineering,
from online lecture videos, to reference material, to practice problems so you can test your knowledge.
My hope is for this site to expand to cover all commonly-taught courses in Electrical Engineering 
departments. If you know what you are looking for, click on one of the subjects below, or on the menu
to the right. If not, explore the discipline of electrical engineering and the course material
offered here by clicking on the link below or the menu to the right. </p>


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
<p>Computational Electromagnetics with MEEP. Build on what you know about the theory of computational electromagnetics and learn to use an open-source simulator.</p>
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


<br><br>
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

<h1>Support this Site</h1>
<p>
The content on this site takes a surprising amount of time to make! (It's typically 2-3 hours per page). While I'm currently doing it in my free time, if I can generate a livable income I might do it full-time for a while, and massively expand the content. If you support me <a href="https://www.patreon.com/edmundsj">on Patreon</a>, we could make that happen.
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
