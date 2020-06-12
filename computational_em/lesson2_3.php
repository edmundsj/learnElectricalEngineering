<?php

echo'<html>';
include $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/head.php";
beginPage();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/header_menu.php";
beginWrapper();
?>

<!-- Main content goes here -->
<h1>Computational Electromagnetics with MEEP Part 2: 1D MEEP</h1>
<span class="image main"><img src="/images/pic13.jpg" alt="" /></span>
<h1>Lesson 3: Convergence testing in MEEP</h1>
<?php
addLessonNavigationE("lesson2_2.php", "lesson2_4.php", "syllabus.php", "Transmitted Power", "Reflected Power", "Outline");
?>
<h2>Remember that resolution guideline?</h2>
<p>
In the last lesson, we actually got a numerical value for the fraction of transmitted power through an interface, \(T\). That was awesome, but it was also wrong - 0.907 when we were expecting ~0.889. Well, remember how we said back in <a href="lesson3">a previous lesson</a> that the designers of MEEP recommended 8 points per wavelength? While it's a good <i>starting point</i>, it's a recommended starting point because it gives reasonable accuracy with fast simulation time. But not fantastic accuracy. So let's see what happens when we double the resolution from 32 to 64. When I make that change and run the simulation again, I get a value for \(T\) of \(0.893\), much closer to the expected value of \(0.889\). I also spent an annoying amount of time waiting at my computer watching the timesteps scroll by. As we start increasing the resolution more and more, going a single timestep at a time and recording the fields like we have been doing is going to slow things down quite a bit.    
</p>
<p>
Fortunately, MEEP has a way of making waht we were doing more elegant - using what the designers call "step functions". This is just a way of saying functions that execute every step, or every time a particular condition happens (for example, after every 0.05 time units, regardless of the timestep). This means we can swap out our for loop at each timestep with something much faster, by replacing this code: 
</p>
<pre class="prettyprint">
simulation.run(until=timestepDuration)
field_Ex = simulation.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex)
fieldData = np.array(field_Ex)

for i in range(numberTimesteps-1):
    simulation.run(until=timestepDuration)
    fieldEx = simulation.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex)
    fieldData = np.vstack((fieldData, fieldEx))

</pre>
<p>
With this code:
</p>
<pre class="prettyprint">
def updateField(sim):
    global fieldData
    fieldEx = sim.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex)
    fieldData = np.vstack((fieldData, fieldEx))

simulation.run(mp.at_every(animationTimestepDuration, updateField), until=endTime)
</pre>
<p>
This will only update the fieldData at every animationTimestepDuration, which I have defined to be 0.05 (but you could make it whatever you find pleasing to view). I put the variable animationTimestepDuration near the top of the code. Why didn't we do this from the beginning? Partly because it was a good learning exercise, and partly because <i>now</i> we care about speed, where we really didn't before.
</p>
<pre class="prettyprint">
animationTimestepDuration = 0.05
</pre>
<p>
Lastly, we need to do some some housekeeping (and you can skip the next few lines if you want to just grab the full code at the bottom), since we deleted the code that fedined fieldData, we need to put it back in, right after the <i>first</i> simulation (the incident simulation). This is just so we know what shape to make the fieldData array. I put the following line right after the first simulation run:
</p>
<pre class="prettyprint">
fieldEx = simulation.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex)
fieldData = np.zeros(len(fieldEx))
</pre>
<p>
Finally, we need to replace this code:
</p>
<pre class="prettyprint">
fieldAnimation = animation.FuncAnimation(fig, animate, init_func=init,
        frames=numberTimesteps, interval=20, blit=True)
</pre>
<p>
With this (because we are changing how we compute the number of steps in the animation):
</p>
<pre class="prettyprint">
numberAnimationTimesteps = fieldData.shape[0]
fieldAnimation = animation.FuncAnimation(fig, animate, init_func=init,
        frames=numberAnimationTimesteps, interval=20, blit=True)
</pre>
<p>
Done! Now we can run the simulation and we have greatly speeded things up (it goes from taking about 20 seconds on my computer to taking about 1, if you exclude saving the .mp4 file). What does it look like after 20 seconds of simulation time?
</p>

<?php addMobileVideoFull('transmission_1D_simulation.mp4'); ?>
<h2>Convergence Testing</h2>
<p>
Looks good! Pretty much everything is gone after 20 seconds. Now we can increase the resolution without things taking dramatically longer. Let's bump it up to 128. What is our fractional transmitted power then? We can try this same experiment with a bunch of points, and plot what the results look like as we increase the number of points per wavelength from 8 to 16 to 32 to 64:
<?php addMobileImageFull('computational_em/convergence_plot_transmission.svg'); ?>
</p>
<p>
This is called <i>convergence testing</i>. We see that after about 32 points per wavelength, our transmitted power is pretty darn close to 8/9, which is the dotted line shown above. But it also looks like increasing the resolution further doesn't improve the accuracy. We say that the simulation appears to have <i>converged</i> with respect to the resolution. In other words, there's something else about our simulation that is the limiting factor in our accuracy. What might that be? Part of the answer turns out to be the PMLs. When we double the PML thickness to 2.0, our answer gets even closer to the correct value (0.88916 instead of 0.88991). Doubling the PML thickness again doesn't seem to help things much. But after doubling the PML thickness, it appears that increasing the resolution <i>again</i> does improve the results! 

<p>
So it wasn't necessarily that our simulation had converged in an <i>absolute</i> sense before, but we just went from the error being dominated by the resolution to being dominated by reflection from the PML.  This is all part of <i>convergence testing</i> and how accurate you want your simulation to be determines how much you do. There are additional sources of error you should consider if you need very accurate results. Generally, you should at least check that doubling the resolution and the PML thickness doesn't dramatically change your answer. I suggest you continue to tweak things - try increasing the simulation time, or the resolution, and see if you can improve the accuracy of the answer. We won't discuss convergence testing further, but if you want to learn more, <a href="https://support.lumerical.com/hc/en-us/articles/360034915833-Convergence-testing-process-for-FDTD-simulations">Lumerical's article on convergence testing</a> is an excellent resource.
</p>

<p>
Now that we found the transmitted power, in the <a href="lesson10.php">next lesson</a> we are going to find the reflected power. Fortunately, you've already done most of the hard stuff, there is just one more subtlety to master - dealing with interference with the incident field.
</p>
<h2>Full Code</h2>
<p>The code can also be downloaded directly from <a href="convergence_testing.py">here</a>.
<pre class="prettyprint">
import meep as mp
import numpy as np
import matplotlib.pyplot as plt
from matplotlib import animation

resolution = 64
frequency = 2.0
pmlThickness = 4.0
endTime = 20.0
courantFactor = 0.5
timestepDuration = courantFactor / resolution
animationTimestepDuration = 0.05
materialThickness = 2.5
length = 2 * materialThickness + 2 * pmlThickness

cellSize = mp.Vector3(0, 0, length)

sources = [mp.Source(
    mp.ContinuousSource(frequency=frequency, end_time=endTime/4),
    component=mp.Ex,
    center=mp.Vector3(0, 0, -materialThickness/2),
    )]

geometry = [mp.Block(
    mp.Vector3(mp.inf, mp.inf, materialThickness + pmlThickness),
    center=mp.Vector3(0, 0, materialThickness/2 + pmlThickness/2),
    material=mp.Medium(index=2))]

pmlLayers = [mp.PML(1.0)]

simulation = mp.Simulation(
    cell_size=cellSize,
    sources=sources,
    resolution=resolution,
    boundary_layers=pmlLayers)

incidentRegion = mp.FluxRegion(center=mp.Vector3(0, 0, -materialThickness/4))
incidentFluxMonitor = simulation.add_flux(frequency, 0, 1, incidentRegion)

simulation.run(until=endTime)
fieldEx = simulation.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex)
fieldData = np.zeros(len(fieldEx))

simulation = mp.Simulation(
    cell_size=cellSize,
    sources=sources,
    resolution=resolution,
    boundary_layers=pmlLayers,
    geometry=geometry)

transmissionRegion = mp.FluxRegion(
        center=mp.Vector3(0, 0, materialThickness/4))
transmissionFluxMonitor = simulation.add_flux(frequency, 0, 1, transmissionRegion)

def updateField(sim):
    global fieldData
    fieldEx = sim.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex)
    fieldData = np.vstack((fieldData, fieldEx))

simulation.run(mp.synchronized_magnetic(mp.at_every(animationTimestepDuration, updateField)), until=endTime)

incidentFlux = mp.get_fluxes(incidentFluxMonitor)[0]
transmittedFlux = mp.get_fluxes(transmissionFluxMonitor)[0]
print(transmittedFlux/incidentFlux)

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
numberAnimationTimesteps = fieldData.shape[0]
fieldAnimation = animation.FuncAnimation(fig, animate, init_func=init,
        frames=numberAnimationTimesteps, interval=20, blit=True)

#fieldAnimation.save('basic_animation.mp4', fps=30, extra_args=['-vcodec', 'libx264'])
plt.show()
</pre>

<?php
$counter = 0;
$counter = appendToQuiz($counter, 'A quiz question',
	array('A quiz option'), 0);
?>
<?php
addLessonNavigation("lesson8.php", "lesson10.php", "Transmitted Power", "Next");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
