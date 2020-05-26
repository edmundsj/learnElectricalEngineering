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
<h1>Lesson 8: Transmitted Power</h1>
<?php
addLessonNavigation("lesson7.php", "lesson9.php", "Reflection", "Next");
?>
<h2>Getting quantitative</h2>
<p>
So far we have restricted ourselves to qualitative or semi-quantitative descriptions - we've been looking at animations and asking ourselves if they make sense. This is great, and there's no better way of debugging or sanity-checking simulations, but now we want to get some hard numbers. We're going to build off the 1D reflection example in the <a href="lesson7">previous lesson</a>, and compute the reflected and transmitted power. 
</p>
<p>
First, let's figure out what numbers we expect to see. We can again consult <a href="https://www.youtube.com/watch?v=fB3upo0TM6k">Fresnel's Equations</a>, which say the reflected power \(R\) as a fraction of the incident power should be:
</p>
<p>
\(R = |\frac{n1 - n2}{n1 + n2}|^2 = |\frac{1 - 2}{1 + 2}|^2 = 1/9 \approx 0.111 \)<br><br>
\(T = 1 - R = 8/9 \approx 0.889\)
</p>
<p>
Let's first try and compute the transmitted power, since this turns out to be a little more straightforward. What we want is the <i>time-averaged</i> transmitted power across the interface, not the power at any one point in time, but <i>averaged</i> over a long period of time. This means we are going to compute the power flowing through at a bunch of time points, and then average that over the time window we use. Fortunately, MEEP provides some functionality to do this for us. MEEP provides "flux monitors", which integrate the Poynting vector flux over a desired area over the duration of the simulation. We just need to add one of these monitors and it will accumulate the energy for us. The code for creating such a monitor is below (just put this right before we run the simulation):
</p>
<pre class="prettyprint">
transmissionRegion = mp.FluxRegion(
        center=mp.Vector3(0, 0, materialThickness/2))
transmissionFluxMonitor = simulation.add_flux(frequency, 0, 1, transmissionRegion)
</pre>
<p>
This accumulates the power flowing through the monitor at exactly a single frequency (the frequency of our plane wave). We <i>could</i> do this ourselves by grabbing the Poynting vector \(S_z\) at each timestep and summing, but this will get really cumbersome in the near future. To get the actual data from the monitor, we just need this line, which returns a 1-element array and prints it to the screen.
</p>
<pre class="prettyprint">
print(mp.get_fluxes(transmissionFluxMonitor))
</pre>
<p>
If you run the code in the previous lesson with the transmission flux monitor added, and print the flux after all the simulation steps, you should get a value around \(0.205\). Great, but what on earth does that mean? Well, I have absolutely no clue. What we need is a reference point - we need to know how much power our source was sending to the interface to begin with. So we actually need <i>two</i> monitors, one to grab the incident flux, and one to grab the transmitted flux.
</p>
<p>
But there's a couple problems here. The first is that for a source that stays on for the entire simulation, power starts flowing through the incident monitor <i>before</i> the transmitted monitor, so we will always under-estimate how much transmitted power we have, unless we let the simulation run for a really long time.
<?php addMobileImageFull('computational_em/reflection_monitors_incident_before_transmitted.svg'); ?>
</p>
<p>
How do we fix this? Well, we could try to figure out exactly how much extra power flowed through the first monitor, and then subtract that out based on the time of the wave's travel, but that sounds really difficult. We could also put the monitors really close so that the error is small. An alternative, which is more accurate and simpler, is that we just <i>turn off</i> the source at some point. That way, we <i>make sure</i> that every wave that passes through the incident monitor also passes through the transmitted power monitor. We can do this by giving our source an "end_time" argument like so:
</p>
<pre class="prettyprint">
sources = [mp.Source(
    mp.ContinuousSource(frequency=frequency, end_time=endTime/4),
    component=mp.Ex,
	center=mp.Vector3(0, 0, -materialThickness),
	)]
</pre>
<p>
Here, I've just given and end time of 1/4 our total simulation time. Let's see what this looks like:
</p>
<?php addMobileVideoFull('continuous_pulse.mp4'); ?>
<p>
Well, we definitely allowed most of the wave to pass through our transmission monitor, but it looks like we will need to make the simulation a little longer. There's also a bunch of very high-frequency waves there that we didn't see before... we'll come back to that, they will turn out to be extremely helpful. Since we only have the source on for a finite amount of time, it must contain a large spread of frequencies (whose distribution you can find by taking the Fourier transform of the pulse). 
</p>
<h2>What about the reflected wave...?</h2>
<p>
But you might have noticed another problem. If we had an incident monitor prior to the interface, we don't just pick up the incident wave, we also pick up the <i>reflected</i> wave:
<?php addMobileImageFull('computational_em/reflection_monitors_two-waves.svg'); ?>
</p>
<p>
This means we won't be able to normalize to our incident power alone, but will be normalizing to some combination of incident power for a little while, and then incident plus reflected power. How can we solve this? The answer the designers of MEEP chose to go with is to perform <i>two</i> simulations - one whose only task is to figure out what the incident field is, and compute the incident flux. In this simulation, there should only be the incident medium (in our case, free space) and the PMLs, so that no reflections can occur. The second simulation will contain the interface, and then we can properly normalize the total power. Fortunately, we already know how to do this - that was the subject of <a href="lesson6">a previous lesson</a>. Let's also give our simulation more time to run so that everything dies out - let's change the endTime to 20 meep units.
</p>
<pre class="prettyprint">
endTime = 20.0
</pre>
<p>
To first run an empty simulation, we need only to run our simulation without the 'geometry' argument. Let's add another simulation before the first (I put it right after the pml code, see the full code below) to compute the incident flux:
</p>
<pre class="prettyprint">
simulation = mp.Simulation(
    cell_size=cellSize,
    sources=sources,
    resolution=resolution,
    boundary_layers=pmlLayers)

incidentRegion = mp.FluxRegion(center=mp.Vector3(0, 0, -materialThickness/4))
incidentFluxMonitor = simulation.add_flux(frequency, 0, 1, incidentRegion)

simulation.run(until=endTime)
</pre>
<p>
This runs the simulation without any geometry, and then performs the simulation, saving the incident flux. Finally, after the code to run the second simulation with the geometry, we can compute the total transmitted flux, and print the ratio of the transmitted flux and the incident flux to the screen (I put this code right after the for loop):
</p>
<pre class="prettyprint">
incidentFlux = mp.get_fluxes(incidentFluxMonitor)[0]
transmittedFlux = mp.get_fluxes(transmissionFluxMonitor)[0]
print(transmittedFlux/incidentFlux)
</pre>
<h2>Numbers, Numbers at last</h2>
<p>
Ah, at long last. But what's this? I got a fraction of transmitted power \(T\) of \(0.9072\). We were expecting 0.89! What gives?
</p>
<h2>Remember that resolution guideline?</h2>
<p>
Remember how we said back in <a href="lesson3">a previous lesson</a> that the designers of MEEP recommended 8 points per wavelength? This is where we revisit that guideline. While it's a good <i>starting point</i>, it doesn't always give great accuracy. Let's see what happens when we double our resolution from 32 to 64. When I make that change and run the simulation again, I get a value for \(T\) of \(0.893\), much closer to the expected value of \(0.889\). I also spent a reasonable amount of time waiting at my computer watching the timesteps scroll by. As we start increasing the resolution more and more, going a single timestep at a time like we have been doing is going to slow things down quite a bit.
</p>
<p>
Fortunately, MEEP has a way of doing this for us using what the designers call "step functions". This is just a way of saying functions that execute every step, or every time a particular condition happens (for example, after every 0.05 time units, regardless of the timestep). We're going to delete all of this code: 
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
And replace it with this:
</p>
<pre class="prettyprint">
def updateField(sim):
    global fieldData
    fieldEx = sim.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex)
    fieldData = np.vstack((fieldData, fieldEx))

simulation.run(mp.at_every(animationTimestepDuration, updateField), until=endTime)
</pre>
<p>
This will only update the fieldData at every animationTimestepDuration, which I have defined to be 0.05 (but you could make it whatever you find pleasing to view). I put the variable animationTimestepDuration near the top of the code.
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
This is called <i>convergence testing</i>. We see that after about 32 points per wavelength, our transmitted power is pretty darn close to 8/9, which is the dotted line shown above. But it also looks like increasing the resolution further doesn't improve the accuracy. Why might that be? Part of the answer turns out to be the PMLs. When we double the PML thickness to 2.0, our answer gets even closer to the correct value (0.88916 instead of 0.88991). Doubling the PML thickness again doesn't seem to help things much. Increasing the simulation time also doesn't seem to help much. This is all part of <i>convergence testing</i> and how accurate you want your simulation to be determines how much you do. Generally, you should at least check that doubling part of your simulation (in particular the resolution and the PML thickness) doesn't dramatically change your answer. 
</p>
<p>
Now that we found the transmitted power, we are going to find the reflected power. Fortunately, you've already done the hard stuff, there is just one more subtlety to master - dealing with interference with the incident field.
</p>
<h2>Full Code</h2>
<p>As usual, you can also download the code <a href="transmitted_power.py">here</a></p>
<pre class="prettyprint">
import meep as mp
import numpy as np
import matplotlib.pyplot as plt
from matplotlib import animation

resolution = 32
frequency = 2.0
pmlThickness = 1.0
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

simulation.run(mp.at_every(animationTimestepDuration, updateField), until=endTime)

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
<h2>Full Code</h2>
<p>Or, download the code here!</p>
<?php
addLessonNavigation("lesson7.php", "lesson9.php", "Reflection", "Next");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
