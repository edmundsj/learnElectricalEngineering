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
<h1>Lesson 1: Getting Started</h1>
<?php
addLessonNavigation("computational_em.php", "lesson2.php", "Introduction", "Next");
?>
<h2>Installing Python, Anaconda</h2>
<p>
If you haven't done so already, you will need to install python. There's a huge number of tutorials available on the web, but since we will subsequently be using miniconda to install MEEP, I suggest downloading and installing Miniconda, <a href="https://conda.io/en/latest/miniconda.html">The Conda Website</a>. If you already have python installed (you are on a mac or linux machine), you will want to do this anyway because we will be installing MEEP through anaconda. 
</p>
<h2>Installing MEEP</h2>
<p>
Once that is done, you will need to install MEEP. The instructions for that can be found here: <a href="https://meep.readthedocs.io/en/latest/Installation/">MEEP Installation</a>. I followed the instructions under the "Conda Packages" section. Since I am on a mac, I ran into the problem that I already have a version of python installed, and so I had to make sure that I was using the python bundled with miniconda.
</p>
<h2>Troubleshooting</h2>
<p>Q: I am getting "ImportError: No module named meep" when I follow the instructions.<br>
A: I ran into this problem. This is probably because you are using a different version of python to try and import meep than the one that came with miniconda. Try running "which python" if you are on a linux / OS X machine to make sure that the python version you are running is inside a folder with the name "miniconda" in it. If not, you will need to find that version of python and use that. On windows, you should just be able to open up the miniconda program and everything should just work.
A: It's also possible you restarted your terminal, and you might need to run 'conda activate mp' again.
</p>

<h2>All Done!</h2>
<p>
That may or may not have been pretty painful, depending on your background. Fear not, we can now get started doing some simulations..
</p>

<?php
$counter = 0;
$counter = appendToQuiz($counter, 'A quiz question',
	array('A quiz option'), 0);
?>
<?php
addLessonNavigation("/signals_systems.php", "lesson2.php", "Introduction", "Hello World");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
