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
<h1>Lesson 5: Visualizing Fields with MEEP</h1>
<?php
addLessonNavigationE("lesson1_4.php", "lesson1_6.php", "syllabus.php", "Hello World", "PMLs", "Outline");
?>
<h2>Give me the data</h2>
<p>
In the <a href="lesson4.php">last lesson</a>, we set up our first simulation with MEEP (<a href="hello_world.py">code here</a>), we ran it, and got some output. But... we didn't see any fields, and that's what we are going to discuss now. Internally, MEEP does keep track of all the electric and magnetic fields at all points in space within the simulation domain - but it only keeps the most recent timestep's fields in memory. Otherwise the memory requirement could get very huge very fast. This means if we want to visualize the fields, we can't just run the simulation once, but we have to run it for a little while, then grab the fields, then run it some more, then grab the fields.
</p>
<p>
Fortunately, python has some great ways of generating animations, built into the plotting library <a href="https://matplotlib.org/">matplotlib</a>. Because this is a small and short simulation, we can safely save the fields everywhere at each timestep. Usually, this won't be the case, and you will have to choose a particular area you are interested in or a particular time to record the fields. Now on to the code. 
</p>
<p>
This time, instead of just importing meep, we also will want to import packages that let us create a movie of the fields over time and collect the data.
</p>
<pre class="prettyprint">
import meep as mp
import numpy as np
import matplotlib.pyplot as plt
from matplotlib import animation
</pre>
<p>
In addition, since we want to save the fields at <i>all</i> timesteps, we will want to know the amount of time to run each simulation - or the time between timesteps. The code below calculates it (just like we did above).
</p>
<pre class="prettyprint">
resolution = 16
frequency = 2.0
length = 5.0
endTime = 5.0
courantFactor = 0.5
timestepDuration = courantFactor / resolution
numberTimesteps = int(endTime / timestepDuration)
</pre>
<p>
Now, as in the <a href="lesson4">previous lesson</a>, we want to add the simulation domain size, the sources, and the simulation (and I'm just going to dump it all below because it's exactly the same as last time).
</p>
<pre class="prettyprint">
cellSize = mp.Vector3(0, 0, length)

sources = [mp.Source(
    mp.ContinuousSource(frequency=frequency),
    component=mp.Ex,
    center=mp.Vector3(0, 0, 0))]

simulation = mp.Simulation(
    cell_size=cellSize,
    sources=sources,
	resolution=resolution)
</pre>
<p>
Now, everything is set up and ready to go. We defined our simulation domain, added our sources, and passed everything into our simulation object. Now, let's run a single-timestep simulation, and store the resultant data in a variable I'm going to call 'fieldEx', for the x-component of the E-field. Then, we're going to store this in a numpy array that will be accumulating <i>all</i> of the fields for the entire simulation, which I have called fieldData. The command to grab quantities from the simulation (fields or permittivity or permeability or anything is get_array. We just need to tell it from what region to get the data (using size and center) and what data we want (component).
</p>
<pre class="prettyprint">
simulation.run(until=timestepDuration)
fieldEx = simulation.get_array(center=mp.Vector3(), size=cellSize, component=mp.Ex)
fieldData = np.array(fieldEx)
</pre>
<p>
That code runs the simulation once, and stored the x-component of the electric field everywhere. All that is left is to run a bunch more simulations and store the data. I'm just going to plop our previous set of commands inside a for loop:
</p>
<pre class="prettyprint">
for i in range(numberTimesteps-1):
    simulation.run(until=timestepDuration)
    fieldEx = simulation.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex)
    fieldData = np.vstack((fieldData, fieldEx))
</pre>
<p>
If we run this file, we should get all 160 timesteps worth of data stored in the fieldData variable, which should now be a matrix. If you are intimately familiar with numpy / matplotlib, at this point you have everything you need to go nuts. If not, here's some animation code: it generates an animation of the fields propagating and then displays it. It will also save an .mp4 file to the directory you are working in.
</p>
<pre class="prettyprint">
fig = plt.figure()
ax = plt.axes(xlim=(-length/2,length/2),ylim=(-1,1))
line, = ax.plot([], [], lw=2)
xData = np.linspace(-length/2, length/2, fieldData.shape[1])

def init():
    line.set_data([],[])
    return line,

def animate(i):
    line.set_data(xData, fieldData[i])
    return line,

fieldAnimation = animation.FuncAnimation(fig, animate, init_func=init,
        frames=numberTimesteps, interval=20, blit=True)

fieldAnimation.save('basic_animation.mp4', fps=30, extra_args=['-vcodec', 'libx264'])
plt.show()
</pre>
<p>
Here's a video of the fields propagating with the code below:
<?php addMobileVideoFull('one_dimensional_planewave.mp4'); ?>
</p>
<h2>Does this make sense?</h2>
<p>
Now we have to ask ourselves the question - does everything we just saw make sense? Well, if you look at the output of MEEP itself, it looks like the computational cell is correct, and there are 160 runs, each of 1 timestep. That all looks good. 
</p>

<p>
But in the simulaiton, we were expecting that the wave would start and just propagate in one direction, and would barely reach the end of the creen! The problem is twofold. First, MEEP uses <i>currents</i> to create planewaves, and these radiate not just in one direction, but in all directions. OK, that part makes sense. The other problem is that we put the source in the <i>center</i> of the simulation domain, and there are only 2.5 MEEP lengths on each side of the source. If you scroll the video to exactly halfway through, you can see the wave is <i>barely touching</i> the edges of the simulation domain. That's exactly what we would expect! It takes half the simulation time to go half the expected distance, and the wave is indeed moving at the speed of light.
</p>
<p>
The sinewaves also aren't perfect, they seem kind of choppy, and aren't always the same height. This was also to be expected (after all, we only have 8 sample points per wavelength!). 
</p>
<p>
There's also something very weird that happens when the planewave hits the edge of the simulation - it starts to get bigger from the edges moving inward, and starts to form what looks like a standing wave. For some reason, the wave is being <i>reflected</i> off the edge of our simulation domain's walls! This turns out to be due to a quirk of FDTD - since the space is finite, what should the electric field be <i>just outside</i> the simulation domain? Because we need the fields from each adjacent pixel to update our fields, <i>we need to know a field that doesn't exist in our simulation</i>. What MEEP does by default, and most simulators do this, is it just says the field everywhere outside our simulation domain is zero. This means the walls act like perfect metals (which must have zero electric field inside them), and they cause waves to reflect.
</p>
<h2>Getting rid of reflections</h2>
<p>
While that might be interesting if you actually wanted your simulation domain to be enclosed by a metal box, we wanted to have free space everywhere. How do we do this if the fields must be zero outside the simulation domain? The answer, which we will add in the <a href="lesson6.php">next lesson</a>, is the Perfectly Matched Layer (PML). 
</p>
<hr>
<h2>Full Code and Download</h2>
<p>
You can download the code for this lesson here <a href="animate_fields.py">here</a>. It is also posted below:
</p>
<pre class="prettify">
import meep as mp
import numpy as np
import matplotlib.pyplot as plt
from matplotlib import animation

resolution = 16
frequency = 2.0
length = 5.0
endTime = 5.0
courantFactor = 0.5
timestepDuration = courantFactor / resolution
numberTimesteps = int(endTime / timestepDuration)

cellSize = mp.Vector3(0, 0, length)

sources = [mp.Source(
    mp.ContinuousSource(frequency=frequency),
    component=mp.Ex,
    center=mp.Vector3(0, 0, 0))]

simulation = mp.Simulation(
    cell_size=cellSize,
    sources=sources,
    resolution=resolution)

simulation.run(until=timestepDuration)
field_Ex = simulation.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex)
fieldData = np.array(field_Ex)

for i in range(numberTimesteps-1):
    simulation.run(until=timestepDuration)
    fieldEx = simulation.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex)
    fieldData = np.vstack((fieldData, fieldEx))

fig = plt.figure()
ax = plt.axes(xlim=(-length/2,length/2),ylim=(-1,1))
line, = ax.plot([], [], lw=2)
xData = np.linspace(-length/2, length/2, fieldData.shape[1])

def init():
    line.set_data([],[])
    return line,

def animate(i):
    line.set_data(xData, fieldData[i])
    return line,

fieldAnimation = animation.FuncAnimation(fig, animate, init_func=init,
        frames=numberTimesteps, interval=20, blit=True)

fieldAnimation.save('basic_animation.mp4', fps=30, extra_args=['-vcodec', 'libx264'])
plt.show()
</pre>

<?php
$counter = 0;
// $counter = appendToQuiz($counter, 'Why do the ',
	//array('A quiz option'), 0);
?>
<?php
addLessonNavigationE("lesson1_4.php", "lesson1_6.php", "syllabus.php", "Hello World", "PMLs", "Outline");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
