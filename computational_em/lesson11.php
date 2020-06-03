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
<h1>Lesson 11: Efficient Multi-Frequency Simulations</h1>
<?php
addLessonNavigation("lesson10.php", "lesson12.php", "Reflected Power", "Next");
?>
<h2>Remember those high-frequency waves?</h2>
<p>
Remember in our previous simulations when we had the pulse end at some point, how we saw there were some high-frequency waves that persisted for a really long time after our pulse ended?
<?php addMobileVideoFull('continuous_pulse.mp4'); ?>
</p>
<p>
If you remember your signals and systems, any signal of <i>finite</i> duration cannot be made of just one frequency - it's made up of a bunch, which you can find by taking the Fourier Transform of the signal. This means that for <i>any</i> finite-time simulation we perform with a finite-duration source, there are a huge number of frequencies contained in that source that we weren't using before! There are a couple problems this raises, though - how high do the frequencies go? And do we need to greatly increase our resolution to resolve those really high frequencies (with at least 8 points per wavelength)?
</p>
<p>
In short yes, and yes. We were just abruptly turning on and off our source (which is sinusoidal). This means we are basically multiplying a perfectly sinewave by a rectangle function. If we fourier transform this rectangle, it looks like a Sinc() function, which takes a really long time to die out in frequency (so it contains a lot of very high frequencies, and we would need an extremely high resolution to represent them all accurately).
<?php addMobileImageFull('computational_em/sinc_function_and_step.svg') ?>
</p>
<p>
The trick to prevent <i>really</i> high frequencies from entering the simulation, to avoid needing a super high resolution, is to <i>slowly</i> turn on the source, rather than abruptly. In particular, there is one type of signal that is really good at only containing frequencies in a narrow window - that is the Gaussian. The Fourier Transform of a Gaussian is <a href="https://mathworld.wolfram.com/FourierTransformGaussian.html">itself a Gaussian</a> (just with an appropriate width), and it dies off like \(e^{-\omega^2}\) in frequency (really really fast), so we can be sure that we will only have a range of frequencies represented, and not a bunch of really high ones. We also get the benefit that gaussians die off quickly (like \(e^{-t^2}\) in <i>time</i>, which means we don't have to run the simulation as long as we would for other signals (like a continuous sinewave). Gaussians essentially let us have our cake and eat it too.
<?php addMobileImageFull('computational_em/gaussian_to_gaussian.svg') ?>
</p>
<p>
This is one of those things that's actually much easier in practice than in theory. All we have to do is swap out the line with our ContinuousSource:
</p>
<pre class="prettyprint">
mp.ContinuousSource(frequency=frequency, end_time=endTime/4),
</pre>
<p>
With a GaussianSource:
</p>
<pre class="prettyprint">
mp.GaussianSource(frequency=frequency,fwidth=frequencyWidth),
</pre>
<p>
Where I have introduced another variable called frequencyWidth which I set to 1 for now (I just put it up at the top with all the other variables).
</p>

<pre class="prettyprint">
frequencyWidth = 1
</pre>
<p>
If we re-run the simulation from the <a href="lesson10.php">previous lesson</a> (but observe the total field instead of just the reflected field, the code for this is below), we can see what a gaussian source actually looks like:
<?php addMobileVideoFull('reflected_gaussian_pulse.mp4'); ?>
</p>
<p>
Notice that despite the slow turn-on, everything actually dies out much more quickly, and we don't see the same really high-frequency nasty bumpiness of the source that we were using before. If you look at the reflected and transmitted power, you'll probably see nearly-identical values, but that seems a little strange. Our signal is totally different, why are R and T exactly the same? Well, internally, when we asked MEEP's flux monitors to give us the flux at a <i>single frequency</i>, it was actually taking the Fourier Transform of the fields that it added up, and then only grabbing the single frequency we asked for. It's still doing the same exact thing now - so as long as our signal <i>contains</i> our frequency of interest, we are good to go. It doesn't have to be <i>purely</i> made of our frequency of interest. 
</p>
<h2>So how about those extra frequencies?</h2>
<p>
So we actually have a BUNCH of information we weren't using before! How do we use it? Fortunately again, this is much easier in practice than in theory. All we need to do is change each of our flux monitors to contain the frequency range we want, and the number of frequencies we want. For example, for the incident flux monitor, we need to change this line of code:
</p>
<pre class="prettyprint">
incidentFluxMonitor = simulation.add_flux(frequency, 0, 1, incidentRegion)
</pre>
<p>
To this:
</p>
<pre class="prettyprint">
incidentFluxMonitor = simulation.add_flux(centerFrequency, frequencyWidth, numberFrequencies, incidentRegion)
</pre>
<p>
We will also need to change the reflection and transmission monitors so that everything has the same number of frequencies:
</p>
<pre class="prettyprint">
transmissionFluxMonitor = simulation.add_flux(frequency, frequencyWidth, numberFrequencies, transmissionRegion)
reflectionFluxMonitor = simulation.add_flux(frequency, frequencyWidth, numberFrequencies, reflectionRegion)
</pre>
<p>
Now we will have not just a single reflection and transmission coefficient, but <i>arrays</i> of reflection and transmission coefficients. Python doesn't like dividing by lists directly, so we just need to tweak our fluxes so they are numpy arrays:
<pre class="prettyprint">
incidentFlux = np.array(mp.get_fluxes(incidentFluxMonitor))
transmittedFlux = np.array(mp.get_fluxes(transmissionFluxMonitor))
reflectedFlux = np.array(mp.get_fluxes(reflectionFluxMonitor))
</pre>
<p>
I'm also going to delete all the code for computing the incident fields and the reflected fields (since we aren't using this anymore) to simplify things. Let's also increase the time of the simulation to 30 units - it seems like there are still some fields left in our simulation.
</p>
<pre class="prettyprint">
endTime = 30.0
</pre>
<p>
If you run the simulation, we get fields that look like this:
<?php addMobileVideoFull('gaussian_pulse_30seconds.mp4'); ?>
</p>
<p>
What about the reflection and transmission coefficients, \(R\) and \(T\)? Would we expect them to be different at different frequencies in this simulation? Since the reflection (and transmission) coefficient from an interface at normal incidence only depends on the refractive index, and that is constant over all frequencies here, no. We wouldn't expect any variation. But if we look at the values for \(T\), we see that they range from \(0.8958\) to \(0.8917\) (you might have different values if your simulation parameters were different). That's interesting, and definitely wasn't something I expected. Any deviation in \(T\) here is strictly due to simulation error, and so we can take what we learned in the <a href="lesson9.php">last lesson on convergence testing</a> and see if the spread gets reduced.
<?php addMobileImageFull('computational_em/convergence_plot_transmission_deviation.svg'); ?>
</p>
<p>
Indeed, we see that the spread in values over various frequencies goes down as we increase the resolution, and it looks like it <i>keeps</i> going down, even as we increase the resolution more and more. Here I used a log plot because the values were so close to zero I couldn't see them on a linear plot. Perhaps even <i>more</i> interestingly, if we plot the <i>absolute</i> error, or the difference between our theoretical value of \(T\) (\(8/9\)), and the actual value, we see something that looks like this:
</p>
<?php addMobileImageFull('computational_em/convergence_plot_transmission_error.svg'); ?>
</p>
<p>
WOW. That's much smaller error than we could achieve previously when we were using our continuous source that we abruptly turned on and off, and it <i>keeps</i> going down with increasing resolution (I stopped testing at 256 points per wavelength (resolution of \(1024\)), because I was getting tired of waiting on the simulator. This shows the strength of Gaussian pulses - the fact that they only have frequencies in a narrow range is what allows for this much-improved error. Now that we know how to compute a bunch of frequencies at once, in the <a href="lesson12.php">next lesson</a> we will put that skill to use, with a material that has a frequency-dependent refractive index - which is pretty much everything. 
</p>
<p>

</p>
<h2>Full Code</h2>
<p>
As usual, the code is posted below and you can download the code <a href="gaussian_reflected_power.py">here</a>.
<pre class="prettyprint">
import meep as mp
import numpy as np
import matplotlib.pyplot as plt
from matplotlib import animation

resolution = 64
frequency = 2.0
frequencyWidth = 1
numberFrequencies = 50
pmlThickness = 4.0
endTime = 30.0
animationTimestepDuration = 0.05
materialThickness = 2.5
length = 2 * materialThickness + 2 * pmlThickness

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
    boundary_layers=pmlLayers)

incidentRegion = mp.FluxRegion(center=mp.Vector3(0, 0, -materialThickness/4))
incidentFluxMonitor = simulation.add_flux(frequency, frequencyWidth, numberFrequencies, incidentRegion)

simulation.run(until=endTime, )
fieldEx = simulation.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex)
fieldData = np.zeros(len(fieldEx))

incidentFluxToSubtract = simulation.get_flux_data(incidentFluxMonitor)

simulation = mp.Simulation(
    cell_size=cellSize,
    sources=sources,
    resolution=resolution,
    boundary_layers=pmlLayers,
    geometry=geometry)

transmissionRegion = mp.FluxRegion(
        center=mp.Vector3(0, 0, materialThickness/4))
transmissionFluxMonitor = simulation.add_flux(frequency, frequencyWidth, numberFrequencies, transmissionRegion)
reflectionRegion = incidentRegion
reflectionFluxMonitor = simulation.add_flux(frequency, frequencyWidth, numberFrequencies, reflectionRegion)
simulation.load_minus_flux_data(reflectionFluxMonitor, incidentFluxToSubtract)

def updateField(sim):
    global fieldData
    fieldEx = sim.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex)
    fieldData = np.vstack((fieldData, fieldEx))

simulation.run(mp.at_every(animationTimestepDuration, updateField), until=endTime)

incidentFlux = np.array(mp.get_fluxes(incidentFluxMonitor))
transmittedFlux = np.array(mp.get_fluxes(transmissionFluxMonitor))
reflectedFlux = np.array(mp.get_fluxes(reflectionFluxMonitor))
R = -reflectedFlux / incidentFlux
T = transmittedFlux / incidentFlux
print(T)
print(R)
print(R + T)

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
addLessonNavigation("lesson10.php", "lesson12.php", "Reflected Power", "Next");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
