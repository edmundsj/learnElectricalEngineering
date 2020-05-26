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
<h1>Lesson 6: Perfectly Matched Layer (PML) </h1>
<?php
addLessonNavigation("lesson5.php", "lesson7.php", "Visualizing Fields", "Next");
?>
<h2>Stopping the reflections</h2>
<p>
In the last lesson, we saw that by default our simulation domain is enclosed in a metal box - whose edges perfectly reflect electromagnetic waves. How do we get rid of these reflections? The answer is a construction called the perfectly matched layer. The basic idea is to add a layer within our simulation domain right at the edges that will absorb the fields before they reach the edges of the domain - without reflecting any from the boundary between this layer and the rest of our simulation domain. Sound tricky? It is. The one implemented in MEEP is called a Uniaxial Perfectly Matched layer, and it uses anisotropic materials that slowly 'turn on' the ability to absorb EM waves to avoid reflections. It doesn't really matter <i>how</i> they do it for our purposes, but such a thing does exist, and we are going to use it. 
</p>
<p>
Since the PML is actually <i>inside</i> our simulation domain, we have to make it a little bit larger to accomodate the PML. Here's the code from the previous lesson, but modified so that we have a new variable - pmlThickness, and we increase our length by twice the PML thickness (because we have one PML on either side of our domain - MEEP does this by default). I chose a thickness of 1 - the developers of MEEP recommend at least one wavelength be able to fit in the PML. A thickness of 1 should be able to fit two wavelenghts - plenty. If our PML isn't thick enough, we won't absorb all of the wave before it hits the edges, and some will reflect back into our simulation domain.Thicker PMLs just mean a larger simulation domain, which takes more time.
</p>
<pre class="prettyprint">
import meep as mp
import numpy as np
import matplotlib.pyplot as plt
from matplotlib import animation

resolution = 16
frequency = 2.0
pmlThickness = 1.0
length = 5.0
length = length + 2 * pmlThickness
endTime = 5.0
courantFactor = 0.5
timestepDuration = courantFactor / resolution
numberTimesteps = int(endTime / timestepDuration)

cellSize = mp.Vector3(0, 0, length)

sources = [mp.Source(
    mp.ContinuousSource(frequency=frequency),
    component=mp.Ex,
    center=mp.Vector3(0, 0, 0))]
</pre>
<p>
Now, we need to add the code for the PML, in addition to adding it to the 'simulation' object (so that it is actually included in our simulation). This uses the boundary_layers argument.
</p>
<pre class="prettyprint">
pmlLayers = [mp.PML(1.0)]

simulation = mp.Simulation(
    cell_size=cellSize,
    sources=sources,
    resolution=resolution,
    boundary_layers=pmlLayers)
</pre>
<p>
And the rest of the code for running the simulation and generating the animation is the same as in the previous elsson (the full code is as usual posted below). When you run the code, you should get an animation that looks like this:
</p>

<?php addMobileVideoFull('one_dimensional_planewave_pml.mp4'); ?>
<p>
Woah! It worked! We can see the waves attenuate as they start to enter the PML, slowly at first but then more quickly, and it looks like our reflections are completely gone! If we want, we could look at the field amplitudes near the edges at the end of the simulation. If you do this, you'll see that the fields decay to about ~\(10^{-4}\) by the time they get to the edges, which is definetely not zero, so there are <i>some</i> waves getting reflected back out of the PML, but they are pretty small.
</p>
<p>
This was just waves propagating in free space - it was definitely cool to watch, and we seem to be using the simulator correctly because everything makes sense. In the <a href="lesson7.php">next lesson</a>, we're going to extend our code further to simulate something more interesting - reflection off a boundary.
</p>
<?php
$counter = 0;
$counter = appendToQuiz($counter, 'What is the purpose of a PML?',
	array('To prevent reflections off the edge of our simulation domain', 'To make sure our waves have room to propagate', 'To increase the computation time of our simulaiton'), 0);
?>
<h2>Full Code</h2>
<p>The full code is posted below. You can also download the python file <a href="animate_fields_pml.py">here</a>.
<pre class="prettyprint">
import meep as mp
import numpy as np
import matplotlib.pyplot as plt
from matplotlib import animation

frequency = 2.0
pmlThickness = 1.0
length = 5.0
length = length + 2 * pmlThickness
endTime = 5.0
courantFactor = 0.5
timestepDuration = courantFactor / resolution
numberTimesteps = int(endTime / timestepDuration)

cellSize = mp.Vector3(0, 0, length)

sources = [mp.Source(
    mp.ContinuousSource(frequency=frequency),
    component=mp.Ex,
    center=mp.Vector3(0, 0, 0))]

pmlLayers = [mp.PML(1.0)]

simulation = mp.Simulation(
    cell_size=cellSize,
    sources=sources,
    resolution=resolution,
    boundary_layers=pmlLayers)

simulation.run(until=timestepDuration)
field_Ex = simulation.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex)
fieldData = np.array(field_Ex)

for i in range(numberTimesteps-1):
    simulation.run(until=timestepDuration)
    fieldEx = simulation.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex)
    fieldData = np.vstack((fieldData, fieldEx))

print(fieldData[-1])

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
addLessonNavigation("lesson5.php", "lesson7.php", "Visualizing Fields", "Next");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
