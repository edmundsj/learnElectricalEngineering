<?php

echo'<html>';
include $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/head.php";
beginPage();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/header_menu.php";
beginWrapper();
?>

<!-- Main content goes here -->
<h1>Computational Electromagnetics with MEEP Part 1: Getting Started</h1>
<span class="image main"><img src="/images/pic13.jpg" alt="" /></span>
<h1>Lesson 4: Setting up our Simulation </h1>
<?php
addLessonNavigationE("lesson1_3.php", "lesson1_5.php", "syllabus.php", "FDTD Basics", "Visualizing Fields", "Outline");
?>
<h2>Parameters to enter</h2>
<p>In the <a href="lesson3.php">previous lesson</a>, we discussed each of the parameters that we need to know prior to running a simulation, including the size of the simulation domain, the time to run the simulation, and the resolution of our simulation. We decided to simulate a plane wave of free-space wavelength \(500 nm\) propagating through free space, and found the following parameters to enter into MEEP:
</p>
<p>
\(f_{MEEP} = \frac{a}{\lambda_0} = 2\)<br><br>
\(L_{MEEP} = \frac{L}{a} = 5 \)<br><br>
\(T_{MEEP} = T * \frac{c}{a} = 5 \)<br><br>
\(R \geq 8 \frac{a}{\lambda} = 16 \)
</p>
<p>
I am assuming you have already installed python and MEEP as described in a <a href="lesson1.php">previous lesson</a>. First, let's create a python file in your favorite plain text editor (my favorite is vim, but feel free to use any program like notepad++ in windows) which will describe our simulation. I named my file hello_world.py, and the first line of the file at the top should import MEEP:
</p>
<pre class="prettyprint">
import meep as mp
</pre>
<p>
Now, lets define the four variables we figured out previously (corresponding to \(R\), \(f_{MEEP}\), \(L_{MEEP}\), and \(T_{MEEP}\)).
</p>
<pre class="prettyprint">
resolution = 16
frequency = 2.0
length = 5.0
endTime = 5.0
</pre>
<p>
Now, we have to first tell MEEP what our simulation domain is. MEEP can actually handle multiple somewhat separate simulation domains that all communicate with each other, so it calls the simulation domain a 'cell'. We only need to tell MEEP what the size of our cell is. For now, we are only going to work in one dimension. To do this, we will define our simulation domain as having zero length in x and y, and the length we previously discussed in z. MEEP expects this as a Vector3 object:
</p>
<pre class="prettyprint">
cellSize = mp.Vector3(0, 0, length)
</pre>
<p>
Right now, we have defined the size of our simulation domain, but we need to put stuff in it! Since everything inside is free space by default, we only need to put in our plane wave source. The way MEEP does this compared to other simulators is a little awkward - it uses oscillating currents to generate electromagnetic waves, rather than directly specifying an electric field. The reasons for this have more to do primarily with ease of implementation on the part of the designers, but for us this won't really matter. We are going to use a "continuous" source, meaning the source is just oscillating at some constant frequency indefinitely (this is the frequency we figured out before). We will make the source generate an electric field in the x-direction, and we will put the source at the center of our simulation domain ((0, 0, 0)). The reason this is an array is because we can have multiple sources - that's totally fine.
</p>
<pre class="prettyprint">
sources = [mp.Source(
	mp.ContinuousSource(frequency=frequency),
	component=mp.Ex,
	center=mp.Vector3(0, 0, 0))]
</pre>
<p>
Now, we have everything we need to run the simulation - we defined the simulation domain, and defined what sources we wanted in that domain, along with their frequency. Now, we create a 'Simulation' object, which is how we actually feed MEEP the simulation domain, the resolution, and the source we defined earlier and get it to run a simulation.
</p>
<pre>
simulation = mp.Simulation(
	cell_size=cellSize,
	sources=sources,
	resolution=resolution)
</pre>
<p>
Finally, we are ready to run the simulation! The only thing we need to tell MEEP is how long to run the simulation for, which we chose in the <a href="lesson3.php">previous lesson</a>.
</p>
<pre class="prettyprint">
simulation.run(until=endTime)
</pre>
<p>
Now, if you run the file using 
<pre class="prettyprint">python hello_world.py</pre> 
in your terminal / miniconda shell you should get an output that looks something like this:
</p>
<pre class="prettyprint">
(mp) C02X32GFJGH5:examples jordan.e$ python hello_world.py
-----------
Initializing structure...
time for choose_chunkdivision = 1.71661e-05 s
Working in 3D dimensions.
Computational cell is 0.0625 x 0.0625 x 5 with resolution 16
time for set_epsilon = 0.000496149 s
-----------
run 0 finished at t = 5.0 (160 timesteps)

Elapsed run time = 0.0044 s
</pre>
<p>
MEEP was kind enough to tell us the size of our computational cell, the number of dimensions, along with how long it took to do various tasks. The key line is the one that starts with "run 0" - it says it finished at t = 5.0, which is what we told it to do, after 160 timesteps. Now we need to ask the question - <i>Does this output make sense?</i> 
</p>
<p>
Well, the fact that it says working in 3 dimensions is a little weird since our length is 0 in x and y, but we'll let that be for the moment. What about the number of timesteps? Does that make sense? Well, we know from a <a href="lesson3.php">previous lesson</a> that the time between timesteps (in seconds) is \(\frac{S}{R} \frac{a}{c}\), or, in MEEP time units, just \(\frac{S}{R}\), where \(S\) is the 'Courant Factor' (0.5 by default), and \(R\) is the resolution we chose. This means the time between timesteps using our \(R=16\) should be \(0.03125\) MEEP units. Since our total simulation time was 5, the number of timesteps should be \(5 / 0.03125 = 160\), just as we observe! Neat. What about the computational cell dimensions? 0.0625 x 0.0625 x 5? Well, we told MEEP we wanted a length of 5, and lengths of 0 along the other two dimensions. 0.0625 is 1/16, or 1 over our resolution, so that kinda makes sense too, depending on how MEEP determines 'size'.
</p>
<p>
This is all fine and good, but how on earth are we supposed to actually see anything? I don't see MEEP reporting any electric or magnetic fields! That is the subject of the <a href="lesson5.php">next lesson</a>. The full code from this lesson is posted below, or you can <a href="hello_world.py">download the file here</a>.
</p>

<h2>Full Code</h2>
<p>
</p>
<pre class="prettyprint">
import meep as mp

resolution = 16
frequency = 2.0
length = 5.0
endTime = 5.0

cellSize = mp.Vector3(0, 0, length)

sources = [mp.Source(
    mp.ContinuousSource(frequency=frequency),
    component=mp.Ex,
    center=mp.Vector3())]

simulation = mp.Simulation(
    cell_size=cellSize,
    sources=sources,
    resolution=resolution)

simulation.run(until=endTime)
</pre>

<?php
$counter = 0;
$counter = appendToQuiz($counter, 'A quiz question',
	array('A quiz option'), 0);
?>
<?php
addLessonNavigationE("lesson1_3.php", "lesson1_5.php", "syllabus.php", "FDTD Basics", "Visualizing Fields", "Outline");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
