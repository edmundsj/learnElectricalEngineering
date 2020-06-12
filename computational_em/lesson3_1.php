<?php

echo'<html>';
include $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/head.php";
beginPage();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/header_menu.php";
beginWrapper();
?>

<!-- Main content goes here -->
<h1>Computational Electromagnetics with MEEP Part 3: 2D MEEP</h1>
<span class="image main"><img src="/images/pic13.jpg" alt="" /></span>
<h1>Lesson 1: MEEP in Two Dimensions </h1>
<?php
addLessonNavigationE("lesson2_12.php", "lesson3_2.php", "syllabus.php", "Resonators", "Gaussian Beams", "Outline");
?>
<h2>Finally!</h2>
<p>
Ah, at long last - learning how to do electromagnetics in two dimensions. We got really far with one dimension, but it has a serious limitation - it can only simulate structures which are infinite in two dimensions (also known as 'slabs'), and can really only work with fields that are, in some way, pointing 'towards' the slab (not fields propagating along the axis of a slab). Lots of interesting stuff happens in two dimensions that we could never simulate in one dimension - things like waveguides, ring resonators, optical beams, and structures which are generally finite along more than one dimension.
</p>
<h2>Baby Steps, As usual - Simulating a Simple Source</h2>
<p>
Let's start off with the simplest thing we can think of - a continuous source at a single point, just to check that everything makes sense. As a helpful reminder, here are the things we need to add to our simulation to get everything to run (discussed in <a href="lesson4.php">lesson 4</a>):
<?php addMobileImageFull('computational_em/simulation_flowchart.svg'); ?>
</p>
<p>
We need to add our sources, our geometry (if we have any, in free space we won't), our PMLs, and the other options the simulation needs to run. These include (bare minimum) the resolution, the size of the simulation domain, and when to terminate the simulation. We also want to be able to actually <i>see</i> what is going on, and we know from <a href="lesson5.php">lesson 5</a> how to create simple animations of our fields. The only added wrinkle here is that we are working with an extra dimension, so when we store fields, we are storing a bunch of <i>matrices</i>, and we have to be mindful of that when accessing the data. Fortunately, other than this pretty much everything is the same as in working with one dimension.
</p>
<h2>Propagation</h2>
<p>
What should we check first? Well, let's just check that the plane wave sources we have been using up until this point behave as we expect. Let's make sure that they propagate at the speed of light and everything looks correct. Let's add a continous source at the origin, with a simulation domain of 10 units by 10 units (<a href="lesson2.php">MEEP units</a>, as usual). 
</p>
<?php
$counter = 0;
$counter = appendToQuiz($counter, 'How long should we run our simulation if it is 10 units by 10 units and the source is at the center for the waves to <i>barely touch</i> the edges of the simulation domain by the end?',
	array('5 MEEP units', '10 MEEP units', '0.2 MEEP units'), 0);
?>
<p>
Ok, now let's run our simulation (full code posted below as usual). What do we see, and <i>does it make sense?</i>
<?php addMobileVideoFull('computational_em/point_source_2D_propagation.mp4'); ?>
</p>
<p>
Well, if we were expecting a plane wave, we have clearly been surprised. What we actually have is a <i>point source</i> (or technically a line source, since it's a point source in two dimensions). But at least the speed of the source makes sense - the outer reddish ring <i>barely</i> starts to touch the boundary of the simulation at the end of the simulation. Point sources are all fine and good, and we will use them plenty, but I want a <i>plane wave</i>, because I know how to deal with those. To create one of these, we just need to extend the source along the y-axis, by adding a single argument to the Source() object:
</p>
<pre class="prettyprint">
sourceSize = mp.Vector3(0, 10, 0)
sources = [mp.Source(mp.ContinuousSource(frequency=frequency),
        component = mp.Ex,
        center=sourceLocation,
        size=sourceSize
        )]
</pre>
<p>
Now what does that look like?
</p>
<?php addMobileVideoFull('computational_em/planewave_2D_propagation.mp4'); ?>
<p>
Hmmm... it seems to be moving at the right speed, but it looks a little funky near the edges. This will actually cause problems. Why is this happening? Well, there's a PML now at <i>all</i> boundaries, not just the edges along the z-direction! Fortunately, there's an easy fix, we just need to set the is_integrated option for the source to True:
</p>
<pre class="prettyprint">
mp.ContinuousSource(frequency=frequency, is_integrated=True)
</pre>
<p>
Now what does it look like?
<?php addMobileVideoFull('computational_em/planewave_2D_propagation_corrected.mp4'); ?>
</p>
<p>
Ahh, much better. That's more like what I expect to see. Let's have some more fun with this plane wave, shall we? Let's try to tilt it, just like we did back in <a href="lesson13.php">lesson 13</a>, by adding the k_point argument to our simulations. Let's start with 45 degrees.
</p>
<pre class="prettyprint">
theta = np.radians(45)
kVector = mp.Vector3(np.sin(theta), 0, np.cos(theta)).scale(frequency)

simulation = mp.Simulation(cell_size=cellSize,
        resolution=resolution,
        sources=sources,
        boundary_layers = pmlLayers,
        k_point=kVector)
</pre>
<?php addMobileVideoFull('computational_em/planewave_2D_kpoint_no_amp.mp4'); ?>
<p>
??? What gives here? We specified our k-vector, but the plane wave doesn't appear to have tilted at all! It looks almost exactly the same!
</p>
<h2>Boundary Conditions vs. Phase</h2>
<p>
The problem is that we've only specified the boundary conditions - what happens when the plane wave crosses from the bottom of the simulation back to the top. But because it <i>starts off</i> as a planewave propagating at normal incidence, it never has a chance to cross the boundaries and become the tilted plane wave it was meant to be. We need to explicitly <i>add</i> the tilt to the plane wave itself, and we do this by including another argument, amp_func, in the Source definition. 
</p>
<pre class="prettyprint">
def tiltFunction(vec):
    return np.exp(1j*2*np.pi*(kVector.x*vec.x + kVector.y*vec.y + kVector.z*vec.z))

sources = [mp.Source(mp.ContinuousSource(frequency=frequency, is_integrated=True),
        component = mp.Ey,
        center=sourceLocation,
        size=sourceSize,
        amp_func=tiltFunction
        )]
</pre>
<p>
This might be a somewhat awkward way of doing things (if you aren't already aquainted with <a href="https://en.wikipedia.org/wiki/Fourier_optics">Fourier Optics</a>). We're basically just telling MEEP to multiply our line source by \(e^{j \overrightarrow{k}\cdot \overrightarrow{r}\), which is a plane wave with k-vector \(\overrightarrow{k}\) in phasor notation.
</p>
<?php addMobileVideoFull('computational_em/planewave_2D_kpoint_with_amp_wrong.mp4'); ?>
<p>
Ah, finally! It's got some tilt to it. Huh. That's weird. It looks like near the bottom of the simulation domain this looks like a planewave, but near the top it gets weaker and isn't even propagating in the right direction! Why might this be? Well, it's <i>as if</i> our source is acting like a point source, with waves near the top spreading out sort-of-in-a-circle. This is because this source is <i>finite</i>. To fix this, we need to make the source <i>infinite</i>. We do this by applying bloch-periodic boundary conditions in the x (vertical) direction. But didn't we already do that?
</p>
<h2>That pesky PML</h2>
<p>
We did, <i>but</i> we also included a PML. By default, MEEP will put the PML around <i>all</i> the simulation boundaries, not just those along z. So we need to remove the PML from the \(+x\) and \(-x\) boundaries. How do we do that? Well, we specify explicitly that we only want the PML to exist on the z boundaries:
</p>
<pre class="prettyprint">
pmlLayers = [mp.PML(thickness=pmlThickness, direction=mp.Z)]
</pre>
<p>
Let's run things again and see how they look:
<?php addMobileVideoFull('computational_em/planewave_2D_kpoint_correct.mp4'); ?>
</p>
<p>
Finally! We finally got a tilted plane wave. This plane wave is <i>infinite</i> along the x- direction, rather than being finite as it was before. However, this also means that whatever devices we simulate will also be <i>infinite</i>, or more precisely, <i>periodic</i> along the x-direction. Often this is desired, but if you want to do a 2D simulation this way of a finite device, you have to resort to more complex ways of creating a plane wave, which I might make an article on if someone harasses me :). In the <a href="lesson20.php">next lesson</a>, we're going to use our newfound friend the amplitude function to start <i>shaping</i> waves. In particular, we're going to revisit our best friend the Gaussian. 
</p>
<h2>Full Code</h2>
<p>You can find the full code <a href="propagation_2D.py">here</a>.
<pre class="prettyprint">
import numpy as np
import meep as mp
import matplotlib.pyplot as plt
from matplotlib import animation

frequency = 1
resolution = 32
pmlThickness = 1.0
cellSize = mp.Vector3(10,0,10)
sourceLocation = mp.Vector3(0,0,0)
sourceSize = mp.Vector3(10, 0, 0)
animationTimestepDuration = 0.05
endTime = 8
theta = np.radians(45)
kVector = mp.Vector3(np.sin(theta), 0, np.cos(theta)).scale(frequency)

def tiltFunction(vec):
    return np.exp(1j*2*np.pi*(kVector.x*vec.x + kVector.y*vec.y + kVector.z*vec.z))

sources = [mp.Source(mp.ContinuousSource(frequency=frequency, is_integrated=True),
        component = mp.Ey,
        center=sourceLocation,
        size=sourceSize,
        amp_func=tiltFunction
        )]

pmlLayers = [mp.PML(thickness=pmlThickness, direction=mp.Z)]

# First, run a simulation to get the shape of the field array
simulation = mp.Simulation(cell_size=cellSize,
        resolution=resolution,
        sources=sources,
        boundary_layers = pmlLayers,
        k_point=kVector)

simulation.run(until=0)
fieldEy = np.array(simulation.get_array(center=sourceLocation,size=cellSize, component=mp.Ey))
fieldData = np.array([np.zeros(fieldEy.shape)])

def updateField(sim):
    global fieldData
    fieldEy = np.array([sim.get_array(center=sourceLocation,size=cellSize,component=mp.Ey)])
    fieldData = np.vstack((fieldData, fieldEy))

simulation = mp.Simulation(cell_size=cellSize,
        resolution=resolution,
        sources=sources,
        boundary_layers=pmlLayers,
        k_point=kVector)

def animate(i):
    im.set_data(fieldData[i])
    return im,

simulation.run(mp.at_every(animationTimestepDuration, updateField), until=endTime)
fieldData = np.real(fieldData)
print(fieldData.shape)

fig, ax = plt.subplots()
im = ax.imshow(fieldData[0], cmap='RdBu', vmin=-1, vmax=1, extent=[cellSize.x/2, -cellSize.x/2, cellSize.z/2, -cellSize.z/2])
fig.colorbar(im)
numberAnimationTimesteps = len(fieldData)
fieldAnimation = animation.FuncAnimation(fig, animate, frames=numberAnimationTimesteps, interval=20, blit=True)
fieldAnimation.save('basic_animation.mp4', fps=30, extra_args=['-vcodec', 'libx264'])
plt.show()
</pre>
<?php
addLessonNavigationE("lesson2_12.php", "lesson3_2.php", "syllabus.php", "Resonators", "Gaussian Beams", "Outline");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
