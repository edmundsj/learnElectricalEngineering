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
<h1>Lesson 13: Angular-Dependent Reflection</h1>
<?php
addLessonNavigation("lesson12.php", "lesson14.php", "Dispersive Materials", "Next");
?>
<h2></h2>
<p>
Everything up to this point has been at <i>normal incidence</i>, where the plane wave is hitting the interface head-on. But often we are interested in what happens at an angle - when we tilt the plane wave. FDTD simulators <a href="https://support.lumerical.com/hc/en-us/articles/360034382894-Understanding-injection-angles-in-broadband-simulations">in general</a> use what are called "Bloch-Periodic boundary conditoins". I don't assume you know what those are and won't be diving into them here, but suffice to say it's the easiest way to tilt planewaves :). It also lets us do very cool things with periodic structures (which we might get into later). 
</p>
<h2>Great, but what does this mean?</h2>
<p>
In practice, this means a couple of things. First, we specify the angle of a plane wave not in the Source() object as you might expect, but by passing our desired wave vector \(\overrightarrow{k}\) directly in to the simulation. In case you've forgotten, \(\overrightarrow{k}\) is just the direction in which the wave is propagating multiplied by \(|\overrightarrow{k}|=\frac{2\pi}{\lambda}\), (the spatial frequency). At normal incidence, with the wave propagating along the z-direction in free space, \(\overrightarrow{k}\) is just \(\hat{z}*\frac{2\pi}{\lambda_0}\), where \(\hat{z}\) is the unit vector in the z-direction.
</p>
<p>
Second, it means the fields will be stored in memory in phasor notation - they will become <i>complex</i>. This doesn't matter except when we want to visualize the fields - as EE's we know what to do here - just take the real part. Internally, MEEP will make sure to deal with the complex numbers appropriately so that it correctly calculates things like power.
</p>
<h2>Enough jabber, let's get started</h2>
<p>
We are going to use the code from the <a href="lesson12.php">previous lesson</a>, but changing the material back from Si to have a refractive index of 2 (and the code will be below as usual). Let's also change the number of frequencies so that we only grab <i>one</i> frequency from our Fourier-Transformed fields. This is both so we can sanity-check our simulation, and also because it turns out doing multi-frequency multi-wavelength simulations has some unexpected subtleties in FDTD, which we will deal with once we make sure everything is working at a single frequency.
</p>
<pre class="prettyprint">
numberFrequencies = 1
</pre>
<p>
Let's also going to drop the resolution back down to 32 so that our calculations are faster initially, because we don't need the high resolution from the previous lesson any more.
</p>
<pre class="prettyprint">
resolution = 32
</pre>
<p>
Since we have to deal with angles now, we need to be more careful about our coordinates, and actually pay attention to things like polarization. So far, we have been working at normal incidence, and our electric field is has been polarized in the "x" direction:
</p>
<?php addMobileImageFull('computational_em/coordinates_normal_incidence_planewave.svg'); ?>
<p>
(note: don't take the length on the drawing of the E and k vectors literally, they have different units than length, it's just meant to signify direction). If we want our planewave to come in at an angle, call it \(\theta\), things will now look something like this:
</p>
<?php addMobileImageFull('computational_em/coordinates_oblique_incidence_planewave.svg'); ?>
<p>
If we zoom in on our k-vector, we see that it has two components: \(k_x\) and \(k_z\). We can see visually that \(k_z\) is just equal to \(|\overrightarrow{k}|cos\theta\) and \(k_x\) is equal to \(|\overrightarrow{k}|sin\theta\). This makes sense because \(\overrightarrow{k}\) is completely along z when \(\theta=0\). 
</p>
<?php addMobileImageFull('computational_em/kVector_illustration.svg'); ?>
<p>
Similarly, the electric field will now have x and z components, instead of just an x-component. We should make sure to verify this in the simulation! Now, all we have to do is figure out how to enter our desired value of \(\overrightarrow{k}\) into MEEP. Remember from <a href="lesson2.php">a previous lesson</a> that MEEP uses normalized units, where a length we enter into MEEP \(x_{MEEP}\) is equal to a real length \(x\) divided by our chosen characteristic length \(a\). 
</p>
<p>
\(x_{MEEP} = \frac{x}{a} \)
</p>
<p>
To figure out what to plug in to MEEP, we can start with the definition of (phase) velocity of an EM wave in free space, which we know is equal to the speed of light \(c\):
</p>
<p>
\(c = \frac{\omega}{|\overrightarrow{k}|} = \frac{2 \pi f}{|\overrightarrow{k}|}\)
</p>
<p>
If we plug in MEEP's normalized frequency \(f_{MEEP} \) for \(f\) we can rearrange the equation in terms of \(|\overrightarrow{k}|\):
</p>
<p>
\(|\overrightarrow{k}|=\frac{2\pi}{a}*f_{MEEP}\)
</p>
<p>Now, since \(\overrightarrow{k}\) has units of inverse length, and MEEP normalizes everything to make it unitless, the all we need to do to get rid of the units of \(\overrightarrow{k}\) is multiply by our characteristic length \(a\), and we are left with what MEEP stores internally as the wavevector's length:
</p>
<p>
\(|\overrightarrow{k}_{MEEP}|=2\pi*f_{MEEP}\)
</p>
<p>
Now it turns out the designers of MEEP decided to handle the factor of \(2 \pi\) themselves, so we actually only need to enter \(f_{MEEP}\) for the spatial frequency \(|\overrightarrow{k}_{MEEP}|\). That's nice! We already have that in our code. How considerate of them. Let's do an example to make sure we understand what's going on:

<?php
$counter = 0;
$counter = appendToQuiz($counter, 'Suppose your frequency \(f_{MEEP}\) is 2. What is the magnitude of the k-vector you need to enter into MEEP?',
	array('0.5', '1', '2'), 2);
?>
<h2>Again, easier in practice</h2>
<p>
If all this talk of k-vectors has got you confused, fortunately this is another case where things are much easier in practice than in theory. We need only to add a couple lines of code, which define the k-Vector and scale it so it has the correct length:
</p>
<pre class="prettyprint">
theta = np.radians(30)
kVector = mp.Vector3(np.sin(theta), 0, np.cos(theta)).scale(frequency)
</pre>
<p>
Here I've entered a value of \(\theta\) of 30 degrees, and added a variable called 'kVector', which is just the \(\overrightarrow{k}\) we have been talking about before. We also need to add an argument in declaring our 'simulation' variable, changing this code:
</p>
<pre class="prettyprint">
simulation = mp.Simulation(
    cell_size=cellSize,
    sources=sources,
    resolution=resolution,
    boundary_layers=pmlLayers)
</pre>
<p>
To this:
</p>
<pre class="prettyprint">
simulation = mp.Simulation(
    cell_size=cellSize,
    sources=sources,
    resolution=resolution,
    boundary_layers=pmlLayers,
    k_point=kVector)
</pre>
<p>
Make sure to also add it to the second simulation (because remember we are running two simulations), by changing this code:
</p>
<pre class="prettyprint">
simulation = mp.Simulation(
    cell_size=cellSize,
    sources=sources,
    resolution=resolution,
    boundary_layers=pmlLayers,
    geometry=geometry)
</pre>
<p>
To this:
</p>
<pre class="prettyprint">
simulation = mp.Simulation(
    cell_size=cellSize,
    sources=sources,
    resolution=resolution,
    boundary_layers=pmlLayers,
    geometry=geometry,
    k_point=kVector)
</pre>
<p>
I would also take the real part of the fieldEx variable before you pass it into fieldData - the code should work as-written but python might complain. Now, let's run it, and see what happens:
</p>
<?php addMobileVideoFull('gaussian_pulse_tilted.mp4'); ?>
<p>
You might notice a couple interesting things - first, the pulses are actually <i>smaller</i> than they were at normal incidence. Their amplitude is not as large. <i>Does this make sense?</i>. Well, yes, because our source has the same amplitude, but now the field it generates is split - part along the x direction (which is what we are seeing) and part along the z direction. You might also notice that the crests of the pulse appear to be moving <i>faster than the pulse itself</i>. This has to do with the difference between <i>phase velocity</i>, or how fast the 'peaks' of the pulse move, and <i>group</i> velocity, how fast the pulse itself moves. If you don't look along the direction the pulses are propagating, but along a different direction (as we did, since we are taking a slice along the z-axis, and our pulse is propatating at an angle of 30 degrees). It's hard to notice at this shallow angle - I recommend you try it at steeper angles - but you will also find the pulses at an angle are moving <i>slower</i>. All these phenomena can be explained in terms of phase and group velocity along the z direction:
</p>
<p>
\(v_{phase, z} = \frac{\omega}{k_z} = c / cos\theta \) <br><br>
\(v_{group, z} = \frac{d\omega}{dk_z} = c * cos\theta \)
</p>

<p>
As the angle gets steeper, the group velocity falls and the phase velocity increases. In other words, the pulse slows down, but the crests within the pulse move faster. This is weird, and it takes some getting used to. I recommend you play around with the simulation parameters and see what happens. 
</p>
<p>
You might also notice that the tilted pulse is <i>shorter</i> than the non-tilted one, and the crests are spaced <i>further</i> apart. This is a consequence of our viewing angle - because we are 'projecting' our pulse onto the z-axis, the pulse looks smaller. And since we are tilting a plane wave, and slicing through that tilted wave, the crests are further apart. You can observe these things more dramatically in free space: I ran a couple of simulations, one at 40 degrees incidence, and one at normal incidence, and ran them both for 20 MEEP units.
</p>
<h2>Normal Incidence</h2>
<?php addMobileVideoFull('propagation_normal_incidence.mp4'); ?>
<h2>40 degrees</h2>
<?php addMobileVideoFull('propagation_40deg.mp4'); ?>
<p>
<h2>Give me the data</h2>
<p>
This is all fine and good, but what about some numbers? At an angle of incidence of 30 degrees, we can use Fresnel's equations along with Snell's Law to predict what the reflection / transmission coefficients should be (since this is polarized in the plane of incidence, it is p-polarized light):
</p>
<p>
\( R_p = |\frac{n_1 * cos\theta_2 - n_2 * cos\theta_1}{n_1 * cos\theta_2 + n_2 * cos\theta_1}|^2 \) (Fresnel's equation)<br><br>
\( n_1 sin\theta_1 = n_2 sin\theta_2 \) (Snell's Law)
</p>
What is this at 30 degrees angle of incidence (\(\theta_1\))? About 0.9199904. If we do the simulation, and some convergence testing, starting at 8 points per wavelength and increasing the resolution, we go from 0.9357 &#8594; 0.9238 &#8594; 0.9209 &#8594; 0.9202 &#8594; 0.92005 &#8594; 0.9199904. Pretty darn good, as in the previous simulation. Here is a plot of the error in the transmission coefficient vs. resolution:
</p>
<?php addMobileImageFull('computational_em/convergence_30_degrees_transmission.svg'); ?>
You might notice that it took quite a bit longer to run these simulations - that's a consequence of applying the boundary conditions we did, and unfortunately there's really no avoiding it. This was also just <i>one</i> angle, and usually we are interested in a bunch of different angles - or how the \(R\) and \(T\) coefficients vary with angle. That will be the subject of the <a href="lesson14.php">next lesson</a>.
<h2>Full Code - Angular Reflection</h2>
<p>Grab the code <a href="angular_reflection.py">here</a> as well.
<pre class="prettyprint">
import meep as mp
import numpy as np
import matplotlib.pyplot as plt
from matplotlib import animation

resolution = 64
frequency = 2.0
frequencyWidth = 1
numberFrequencies = 1
pmlThickness = 2.0
animationTimestepDuration = 0.05
materialThickness = 2.5
length = 2 * materialThickness + 2 * pmlThickness
powerDecayTarget = 1e-9
transmissionMonitorLocation = mp.Vector3(0, 0, materialThickness/4)
theta = np.radians(30)
kVector = mp.Vector3(np.sin(theta), 0, np.cos(theta)).scale(frequency)

cellSize = mp.Vector3(0, 0, length)

sources = [mp.Source(
    mp.GaussianSource(frequency=frequency,fwidth=frequencyWidth),
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
    boundary_layers=pmlLayers,
    k_point=kVector)

incidentRegion = mp.FluxRegion(center=mp.Vector3(0, 0, -materialThickness/4))
incidentFluxMonitor = simulation.add_flux(frequency, frequencyWidth, numberFrequencies, incidentRegion)

simulation.run(until_after_sources=mp.stop_when_fields_decayed(20, mp.Ex,
    transmissionMonitorLocation, powerDecayTarget))
fieldEx = np.real(simulation.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex))
fieldData = np.zeros(len(fieldEx))

incidentFluxToSubtract = simulation.get_flux_data(incidentFluxMonitor)

simulation = mp.Simulation(
    cell_size=cellSize,
    sources=sources,
    resolution=resolution,
    boundary_layers=pmlLayers,
    geometry=geometry,
    k_point=kVector)

transmissionRegion = mp.FluxRegion(center=transmissionMonitorLocation)
transmissionFluxMonitor = simulation.add_flux(frequency, frequencyWidth, numberFrequencies, transmissionRegion)
reflectionRegion = incidentRegion
reflectionFluxMonitor = simulation.add_flux(frequency, frequencyWidth, numberFrequencies, reflectionRegion)
simulation.load_minus_flux_data(reflectionFluxMonitor, incidentFluxToSubtract)

def updateField(sim):
    global fieldData
    fieldEx = np.real(sim.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex))
    fieldData = np.vstack((fieldData, fieldEx))

simulation.run(mp.at_every(animationTimestepDuration, updateField),
        until_after_sources=mp.stop_when_fields_decayed(20, mp.Ex,
            transmissionMonitorLocation, powerDecayTarget))

incidentFlux = np.array(mp.get_fluxes(incidentFluxMonitor))
transmittedFlux = np.array(mp.get_fluxes(transmissionFluxMonitor))
reflectedFlux = np.array(mp.get_fluxes(reflectionFluxMonitor))
R = -reflectedFlux / incidentFlux
T = transmittedFlux / incidentFlux
print(T)
print(R)
print(R + T)

#frequencies = np.array(mp.get_flux_freqs(reflectionFluxMonitor))
#reflectionSpectraFigure = plt.figure()
#reflectionSpectraAxes = plt.axes(xlim=(frequency-frequencyWidth/2, frequency+frequencyWidth/2),ylim=(0, 1))
#reflectionLine, = reflectionSpectraAxes.plot(frequencies, R, lw=2)
#reflectionSpectraAxes.set_xlabel('frequency (a / \u03BB0)')
#reflectionSpectraAxes.set_ylabel('R')
#plt.show()

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

<h2>Full Code - Angular Propagation</h2>
<p>Grab the code <a href="angular_propagation.py">here</a> as well.
<pre class="prettyprint">
import meep as mp
import numpy as np
import matplotlib.pyplot as plt
from matplotlib import animation

resolution = 32
frequency = 2.0
frequencyWidth = 1
numberFrequencies = 1
pmlThickness = 2.0
animationTimestepDuration = 0.05
materialThickness = 5
length = 2 * materialThickness + 2 * pmlThickness
powerDecayTarget = 1e-9
transmissionMonitorLocation = mp.Vector3(0, 0, materialThickness/4)
theta = np.radians(0)
kVector = mp.Vector3(np.sin(theta), 0, np.cos(theta)).scale(frequency)
endTime=20

cellSize = mp.Vector3(0, 0, length)

sources = [mp.Source(
    mp.GaussianSource(frequency=frequency, fwidth=frequencyWidth),
    component=mp.Ex,
    center=mp.Vector3(0, 0, -materialThickness/2),
    )]

pmlLayers = [mp.PML(1.0)]

simulation = mp.Simulation(
    cell_size=cellSize,
    sources=sources,
    resolution=resolution,
    boundary_layers=pmlLayers,
    k_point=kVector)

simulation.run(until=0)
fieldEx = np.real(simulation.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex))
fieldData = np.zeros(len(fieldEx))

def updateField(sim):
    global fieldData
    fieldEx = np.real(sim.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex))
    fieldData = np.vstack((fieldData, fieldEx))

simulation.run(mp.at_every(animationTimestepDuration, updateField),until=endTime)

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

!fieldAnimation.save('basic_animation.mp4', fps=30, extra_args=['-vcodec', 'libx264'])
plt.show()
</pre>
<?php
addLessonNavigation("lesson12.php", "lesson14.php", "Dispersive Materials", "Next");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
