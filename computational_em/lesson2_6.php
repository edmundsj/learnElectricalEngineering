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
<h1>Lesson 6: Frequency-dependent reflection from Dispersive Materials</h1>
<?php
addLessonNavigationE("lesson2_5.php", "lesson2_7.php", "syllabus.php", "Multi-Frequency Simulation", "Angular Dependence", "Outline");
?>
<h2>Why make materials so complicated?</h2>
<p>
Why do we care about frequency dependence of material properties? Why not just do our simulations at one frequency and call it a day? Well, because real materials tend to have refractive indices that are <i>very strongly</i> dependent on frequency (or equivalently, wavelength). For example, Silicon, probably the most widely-used material in all of electrical engineering (by impact, maybe not mass) has a refractive index vs. wavelength that looks like this (taken from <a href="https://refractiveindex.info/?shelf=main&book=Si&page=Aspnes">here</a>):
<?php addMobileImageFull("computational_em/si_refractive_index.svg") ?>
</p>
<p>
That's not a small change either! The refractive index varies from about 1 <i>to almost 7</i> from free-space wavelengths of \(200 nm\) to \(400nm\). That's a HUGE difference. Fortunately, adding frequency-dependent behavior for materials like silicon is extremely simple in MEEP - we literally need to change only two lines of code from our previous simulation. The first line, we put at the very top, imports the material:
</p>
<pre class="prettyprint">
from meep.materials import Si
</pre>
<p>
Next, we only have to change our 'geometry' section replacing the constant-index material with Si. So we need to replace this hunk of code:
</p>
<pre class="prettyprint">
geometry = [mp.Block(
    mp.Vector3(mp.inf, mp.inf, materialThickness + pmlThickness),
    center=mp.Vector3(0, 0, materialThickness/2 + pmlThickness/2),
    material=mp.Medium(index=2))]
</pre>
<p>
To this (we are only changing the last line):
</p>
<pre class="prettyprint">
geometry = [mp.Block(
    mp.Vector3(mp.inf, mp.inf, materialThickness + pmlThickness),
    center=mp.Vector3(0, 0, materialThickness/2 + pmlThickness/2),
    material=Si)]
</pre>
<p>
That's literally it. Pretty darn painless. Let's run the simulation with the code from the <a href="lesson11.php">previous lesson</a> (as usual you can find the full code at the bottom of the page). When you run it, this is what you get:
<?php addMobileVideoFull('silicon_dispersion.mp4'); ?>
</p>
<p>
Things look pretty much the same as before, with a couple exceptions - the pulse is going VERY slow once it enters the silicon (this is because the refractive index of Si is much higher than what we were using previously). It's moving so slow, in fact, that it doesn't leave the simulation before our end time. Having to change the simulation time every time we change a material sounds kind of annoying. I'm getting annoyed just thinking about it. Fortunately, MEEP provides an alternative way of ending simulations - rather than ending at a specific <i>time</i> we can end when a particular <i>condition</i> is met - for example, once the power flowing through the transmission monitor has decayed to a very small value (say 1e-9). To add this end condition, we need only remove the until=endTime argument inside our simulation.run() functions:
<pre class="prettyprint">
simulation.run(until=endTime)
</pre>
<p>
and replace it with this awkward-looking line of code: 
</p>
<pre class="prettyprint">
simulation.run(until_after_sources=mp.stop_when_fields_decayed(20, 
	mp.Ex, transmissionMonitorLocation, powerDecayTarget))
</pre>
<p>
And this line of code:
</p>
<pre class="prettyprint">
simulation.run(mp.at_every(animationTimestepDuration, updateField), until=endTime)
</pre>
<p>with this mess:</p>
<pre class="prettyprint">
simulation.run(mp.at_every(animationTimestepDuration, updateField), 
	until_after_sources=mp.stop_when_fields_decayed(20, mp.Ex, 
	transmissionMonitorLocation, powerDecayTarget))
</pre>
<p>
Where I have introduced the two new variables to keep track of what is going on (put them at the top as usual):
</p>
<pre class="prettyprint">
powerDecayTarget = 1e-9
transmissionMonitorLocation = mp.Vector3(0, 0, materialThickness/4)
</pre>
<p>
This checks every 20 MEEP units to see whether the power passing through the transmission monitor has decayed to less than 1e-9 units - if it falls below this value, the simulation is terminated. This is GREAT, because now we don't have to worry about changing the simulation time - we can be confident that we have captured essentially all the flux moving through our transmission monitor (and if we have captured all this flux, since waves move slower in high-index regions, we have definitely captured all the reflected flux as well).
</p>
<p>
<h2>More resolution!</h2>
The pulse is also much higher frequency than before - we should check that we are sampling with enough points - since Si has a max refractive index of ~7, we need a resolution of at least \( 8 * \frac{a}{\lambda} \), where \( \lambda = \lambda_0 / n \) is within the highest-index material. If you need a quick review, check out the <a href="lesson3.php">lesson discussing resolution</a>. So we actually need a resolution of at least 112. I'm going to choose 128 because it's a factor of 2 and I like factors of 2 :). 
</p>
<h2>Is that pulse being <i>s t r e t c h e d?</i></h2>
<p>
The pulse is also getting visibly broader - and that's not a simulation artifact. That's very real. This phenomenon is called <i>dispersion</i>, so named because the pulse gets "dispersed". It has to do with the fact the refractive index is not constant with frequency, which means the velocity of each frequency wave will not be the same.
</p>
<p>
<h2>Units, Beware</h2>
<p>
This is where MEEP's cleverness starts to bite it in the butt a little. Because material properties correspond to <i>physical</i> frequencies / free space wavelengths (like 700nm), MEEP needs to know your characteristic length \(a\). If you need a refresher on what this is, check out the <a href="lesson2.php">lesson on units in MEEP</a>. By default, MEEP assumes you used a characteristic length of \(1 \mu m\). If you did not choose this characteristic length, then you need to tell that to MEEP by modifying the materials library file (where that is, I'm not sure, you can check <a href="https://meep.readthedocs.io/en/latest/Materials/#materials-library">the documentation</a>). For this reason, if you are planning on using their materials library, you should probably just stick with a characteristic length of \(1 \mu m\).
</p>
<h2>Listen to the warnings (or don't)!</h2>
<p>
You might also have noticed while the simulation was running you got some text with RuntimeWarning in the text, something about the frequency being outside of the material range. This is because MEEP's library only has material properties within certain ranges (for Si, <a href="https://meep.readthedocs.io/en/latest/Materials/#materials-library">they claim</a> it is 0.4\(mu m\) to \(1 \mu m\)). Our frequencies go from 1.5 - 2.5, and so we are butting up against the edge of that region. Whether MEEP is reasonably good at extrapolating - who knows? But you should be aware of this.
</p>
<h2>OK, now back to the reflection spectra</h2>
<p>
The original goal was to find the reflection <i>spectra</i> - the frequency-dependent reflection coefficient, due to the changing refractive index of Si. We have all the data we need - now we just need to plot it. We can do this in matplotlib - here's a snippet of code I wrote (which I put right after print(R+T), that plots the reflection spectra to the screen. You're free to write your own, of course - if you make a nicer-looking one, send it my way!
</p>
<pre class="prettyprint">
frequencies = np.array(mp.get_flux_freqs(reflectionFluxMonitor))
reflectionSpectraFigure = plt.figure()
reflectionSpectraAxes = plt.axes(xlim=(frequency-frequencyWidth/2, frequency+frequencyWidth/2),ylim=(0, 1))
reflectionLine, = reflectionSpectraAxes.plot(frequencies, R, lw=2)
reflectionSpectraAxes.set_xlabel('frequency (a / \u03BB0)')
reflectionSpectraAxes.set_ylabel('R')
plt.show()
</pre>
<p>
If we run everything, we get a plot that looks like so:
</p>
<?php addMobileImageFull('computational_em/si_reflection_spectra.svg'); ?>
<p>Neat! But how do we know it's correct?</p>
<?php
$counter = 0;
$counter = appendToQuiz($counter, 'How do we know our spectra is correct',
	array("We don't, but we can do a convergence test!"), 0);
?>
<p>
I like the way you think. If we increase the resolution to 256, then 512, the reflectance at the minimum and maximum frequencies changes (at the most extreme) from 0.467 &#8594; 0.453 &#8594; 0.450, and if I had to guess would converge somewhere just below there. If I wanted the reflectance at every wavelength to within 0.001, I might continue doing convergence testing. At this point, though, I'm pretty happy. The curve also makes sense because as the wavelength gets shorter, the refractive index of Si gets higher (in the range of frequencies we are testing). This means we expect the reflection coefficient to increase as we increase the frequency, which is exactly what we see. The curve at a resolution of 512 looks like this:
<?php addMobileImageFull('computational_em/si_reflection_spectra_512_resolution.svg'); ?>
</p>
<p>
Which, while not <i>identical</i> to the curve above, captures pretty much all the same information. I'm pretty happy with this curve.
</p>
<p>
Now that we understand how to use materials, we can do things that would otherwise be very challenging to do by hand, even for this simple example. But everything we have done up until this point has been at <i>normal incidence</i>, that is the plane wave has been facing our interface head-on. Sometimes this is the case, but often we want to know what happens at oblique incidence, where the plane wave comes in at an angle. That will be the subject of the <a href="lesson13.php">next lesson</a>.
</p>
<h2>Full Code</h2>
<p>You can download the full code <a href="dispersion_reflection.py">here</a>, or view it below</p>
<pre class="prettyprint">
import meep as mp
import numpy as np
import matplotlib.pyplot as plt
from matplotlib import animation
from meep.materials import Si

resolution = 512
frequency = 2.0
frequencyWidth = 1
numberFrequencies = 50
pmlThickness = 4.0
animationTimestepDuration = 0.05
materialThickness = 2.5
length = 2 * materialThickness + 2 * pmlThickness
powerDecayTarget = 1e-9
transmissionMonitorLocation = mp.Vector3(0, 0, materialThickness/4)

cellSize = mp.Vector3(0, 0, length)

sources = [mp.Source(
    mp.GaussianSource(frequency=frequency,fwidth=frequencyWidth),
    component=mp.Ex,
    center=mp.Vector3(0, 0, -materialThickness/2),
    )]

geometry = [mp.Block(
    mp.Vector3(mp.inf, mp.inf, materialThickness + pmlThickness),
    center=mp.Vector3(0, 0, materialThickness/2 + pmlThickness/2),
    material=Si)]

pmlLayers = [mp.PML(1.0)]

simulation = mp.Simulation(
    cell_size=cellSize,
    sources=sources,
    resolution=resolution,
    boundary_layers=pmlLayers)

incidentRegion = mp.FluxRegion(center=mp.Vector3(0, 0, -materialThickness/4))
incidentFluxMonitor = simulation.add_flux(frequency, frequencyWidth, numberFrequencies, incidentRegion)

simulation.run(until_after_sources=mp.stop_when_fields_decayed(20, mp.Ex, transmissionMonitorLocation, powerDecayTarget))
fieldEx = simulation.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex)
fieldData = np.zeros(len(fieldEx))

incidentFluxToSubtract = simulation.get_flux_data(incidentFluxMonitor)

simulation = mp.Simulation(
    cell_size=cellSize,
    sources=sources,
    resolution=resolution,
    boundary_layers=pmlLayers,
    geometry=geometry)

transmissionRegion = mp.FluxRegion(center=transmissionMonitorLocation)
transmissionFluxMonitor = simulation.add_flux(frequency, frequencyWidth, numberFrequencies, transmissionRegion)
reflectionRegion = incidentRegion
reflectionFluxMonitor = simulation.add_flux(frequency, frequencyWidth, numberFrequencies, reflectionRegion)
simulation.load_minus_flux_data(reflectionFluxMonitor, incidentFluxToSubtract)

def updateField(sim):
    global fieldData
    fieldEx = sim.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex)
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

frequencies = np.array(mp.get_flux_freqs(reflectionFluxMonitor))
reflectionSpectraFigure = plt.figure()
reflectionSpectraAxes = plt.axes(xlim=(frequency-frequencyWidth/2, frequency+frequencyWidth/2),ylim=(0, 1))
reflectionLine, = reflectionSpectraAxes.plot(frequencies, R, lw=2)
reflectionSpectraAxes.set_xlabel('frequency (a / \u03BB0)')
reflectionSpectraAxes.set_ylabel('R')
plt.show()

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
addLessonNavigationE("lesson2_5.php", "lesson2_7.php", "syllabus.php", "Multi-Frequency Simulation", "Angular Dependence", "Outline");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
