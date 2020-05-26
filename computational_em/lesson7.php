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
<h1>Lesson 7: Reflection off an Interface </h1>
<?php
addLessonNavigation("lesson6.php", "lesson8.php", "Perfectly Matched Layer", "Next");
?>
<h2>But we already know the answer!</h2>
<p>
If you're inwardly groaning because you already know how waves behave when they hit an interface, don't worry - that's the whole point. The <a href="https://www.youtube.com/watch?v=fB3upo0TM6k">Fresnel Equations</a> (pronounced "freh-nehl" so you don't get made fun of) analytically describe how electromagnetic fields are reflected at a boundary. This means we can calculate exactly how much of our field should be reflected, and compare that to what MEEP tells us. Remember the mantra - <i>does this make sense?</i>. If this seems overly simplistic to you, fear not, we will soon graduate to examples that we couldn't do by hand. 
</p>
<p>
Let's forge ahead, give the simulation a try, and then try and figure out how we might measure the reflected and transmitted fields. First, we need to figure out how to change part of our simulation region so that it is a different material. Let's use air (essentially the same as free space), and some other material with refractive index of 2 (to make the math nice and simple). This is the same as a relative permittivity of 4.
<?php addMobileImageFull('computational_em/simulation_domain_reflection.svg'); ?>
</p>
<p>
We already went over how to add the PMLs in the <a href="lesson6.php">previous lesson</a>, and the rest of the matrial is, by default, free space, so all we need to do is add the second material. To make things more convenient, I'm going to add the variable "materialThickness", and we are going to have as much space in the water as we do in the air. We also want to send the planewave in from the left (from free space to the water), and having a wave propagating in both directions is just distracting, so rather than centering the planewave, let's put it close to the left-hand PML, like so:
<?php addMobileImageFull('computational_em/simulation_domain_reflection_planewave.svg'); ?>
</p>
<p>
Our length is exactly the same as before, but now we have an extra "materialThickness" variable to make it easier to place the material layer (here I've only put the lines that have changed from the previous lesson). Let's also change the simulation time to 10 units so that we can observe this for a little bit longer. Is there anything else we have to do? Remember how we want to be able to have at least 8 points per wavelength <i>in every material</i>? Well, now that we are adding a higher-index material, we need to increase the resolution. Since our index is twice that of free space, we need to double our resolution, because a wavelength in the material is going to be squeezed to half the size. Let's also increase the time to 10 units so that we can watch this for longer.
</p>
<pre class="prettyprint">
resolution = 32
endTime = 10.0
materialThickness = 2.5
length = 2 * materialThickness + 2 * pmlThickness
</pre>
<p>
We also need to change our source to put it close to the left-hand side PML (I just put it at a location of -materialThickness)
</p>
<pre class="prettyprint">
sources = [mp.Source(
    mp.ContinuousSource(frequency=frequency),
    component=mp.Ex,
    center=mp.Vector3(0, 0, -materialThickness))]
</pre>
<p>
How do we actually add the material? We do this with a 'geometry' object, specifically, something called a "block". This is basically just a rectangular prism. We need to tell MEEP where to put the rectangular prism (its center) and how big it is, as well as what it's made out of.
</p>
<pre class="prettyprint">
geometry = [mp.Block(
    mp.Vector3(mp.inf, mp.inf, materialThickness + pmlThickness),
    center=mp.Vector3(0, 0, materialThickness/2 + pmlThickness/2),
    material=mp.Medium(index=2))]
</pre>
<p>
The first argument is how big the block is. Since this is a 1D simulation, we want the block to be infinite in x and y, and we specify that with mp.inf. We also actually want the material to extend <i>into</i> the PML, because we want the material to be homogenous everywhere in the PML to avoid reflections (the <a href="https://meep.readthedocs.io/en/latest/Perfectly_Matched_Layer/">MEEP docs</a> have lots more info if you're curious as to why, I had some fun debugging this myself). To specify that this block should have a different refractive index, we specify the 'material' of the block with mp.Medium(index=2), which just gives the material a refractive index of 2.
</p>
<p>
If you run the code (full code is posted below), you will get an animation that looks like this: 
<?php addMobileVideoFull('one_dimensional_reflection.mp4') ?>
</p>
<p>
This is getting really cool! We see that when the wave enters the second medium, some of it gets transmitted, but the amplitude is smaller, the wavelength is shorter, and it moves slower. It also looks like we now have a wave which is partly moving but partly a standing wave due to the part of the wave that gets reflected. <i>Does this all make sense?</i> Well, would we expect the wave to speed up or slow down? Since it is entering a <i>higher</i> index material, we expect the wave to slow down, since the (phase) velocity of a wave is just \(c/n\). The wavelength should also get shorter since the wavelength is just \(\lambda_0/n\). How about the amplitude? For this, we turn to <a href="https://www.youtube.com/watch?v=fB3upo0TM6k">Fresnel's equations</a>. At normal incidence, the reflection and transmission coefficients for the electric field are given by:
</p>
<p>
\(r = \frac{n_1 - n_2}{n_1 + n_2} = \frac{1 - 2}{1 + 2} = -1/3 \)<br><br>
\(t = \frac{2*n_1}{n_1 + n_2} = \frac{2}{1 + 2} = 2/3\)
</p>
<p>
Just by eyeballing it, it looks like the transmitted field gets to a height of just above 0.25, and the reflected field, when it is at its biggest, gets to just under 0.75. Fresnel's equations say the transmitted amplitude should be \(0.5 * t = 0.5*2/3 = 0.33\) and the reflected amplitude should be the sum of the incoming wave and the reflected wave, or at its maximum should be \( 0.5 + |r*0.5| = 0.5 + 0.5/3 = 0.83\). This is almost exactly what we see in the simulation! From this we can calculate the reflected and transmitted power.
</p>
<p>
But now let's get quantitative. Say we want to know <i>exactly</i> what the reflected and transmitted power is at this frequency (or at least what the simulator thinks it is). This will be the subject of the <a href="lesson8.php">next lesson</a>.
</p>
<?php
$counter = 0;
$counter = appendToQuiz($counter, 'How much should the wave be slowed down once it enters the second medium?',
	array('A factor of 2', 'A factor of 4', 'It should not slow down'), 0);
?>
<h2>Full Code</h2>
<p>You can download the code <a href="interface_reflection.py">here</a>. If you want it to go much faster, you can comment out the line that saves the animation to .mp4, that is what takes the most time.
<pre class="prettyprint">
import meep as mp
import numpy as np
import matplotlib.pyplot as plt
from matplotlib import animation

resolution = 32
frequency = 2.0
pmlThickness = 1.0
endTime = 10.0
courantFactor = 0.5
timestepDuration = courantFactor / resolution
numberTimesteps = int(endTime / timestepDuration)
materialThickness = 2.5
length = 2 * materialThickness + 2 * pmlThickness

cellSize = mp.Vector3(0, 0, length)

sources = [mp.Source(
    mp.ContinuousSource(frequency=frequency),
    component=mp.Ex,
    center=mp.Vector3(0, 0, -materialThickness))]

geometry = [mp.Block(
    mp.Vector3(mp.inf, mp.inf, materialThickness + pmlThickness),
    center=mp.Vector3(0, 0, materialThickness/2 + pmlThickness/2),
    material=mp.Medium(index=2))]

pmlLayers = [mp.PML(1.0)]

simulation = mp.Simulation(
    cell_size=cellSize,
    sources=sources,
    resolution=resolution,
    boundary_layers=pmlLayers,
    geometry=geometry)

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
addLessonNavigation("lesson6.php", "lesson8.php", "Perfectly Matched Layer", "Next");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
