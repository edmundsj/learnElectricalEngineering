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
<h1>Lesson 16: Thin-film interference </h1>
<?php
addLessonNavigation("lesson15.php", "lesson17.php", "Multi-Angle Multi-Frequency Reflection", "Next");
?>
<h2>Now on to the fun stuff!</h2>
<p>
Not that reflection off an interface isn't <i>fun</i>, but now we get to actually use what we've learned in the previous lessons to see cool effects, like <a href="https://en.wikipedia.org/wiki/Thin-film_interference">thin-film interference</a>, the subject of this lesson. This <i>also</i> is an excellent starting point for the study of mirrors, anti-reflection coatings, and resonant devices, which are the subject of the next several lessons, and will wrap up our one-dimensional adventures in MEEP (then onto 2 dimensions!). The basic idea we want to simulate in this lesson is a thin film on a surface - I'm going to choose oil on water, because it's as good a starting point as any. Let's take a look at what we want our simulation to look like:
<?php addMobileImageFull('computational_em/thin_film_interference_simulation.svg'); ?>
</p>
<p>
Let's do this at normal incidence to simplify things - if you wanted to perform the simulation over multiple angles and frequencies you now know how to do that :). Oil also doesn't really have a refractive index of 2, it's closer to 1.5, but it makes the math easier. For now, let's pretend that these materials index of refraction doesn't depend on wavelength (a bad assumption, but a good starting point). The setup of the simulation is pretty much identical to all our previous simulations, but now we have an extra Block() object in our geometry variable, and the position/index of our second material are different, because we need to accomodate the film.
</p>

<pre class="prettyprint">
geometry = [mp.Block(
    mp.Vector3(mp.inf, mp.inf, filmThickness),
    center=mp.Vector3(0, 0, filmThickness/2),
    material=mp.Medium(index=2)),
    mp.Block(
    mp.Vector3(mp.inf, mp.inf, materialThickness + pmlThickness),
    center=mp.Vector3(0, 0, filmThickness + materialThickness/2 + pmlThickness/2),
    material=mp.Medium(index=1.3))]
</pre>

<p>
The only thing we need is the thickness of the film. What should we make it? Ideally we would like to see some easily-recognizable feature of the spectrum, like a maxima or a minima, somewhere in our tested frequency range (which I will keep at 1.5 to 2.5 for now). <i>Constructive interference</i>, or when we have a maxima in our reflectance spectrum, occurs when the thickness is equal to \(\left(m - \frac{1}{2}\right)\frac{\lambda_0}{2 n}\), where \(m\) is an integer (at least one) and \(n\) is the refractive index of the film (in our case, 2). Destructive interference on the other hand, when the reflectance is at a minimum, occurs when the thickness is equal to \(m*\frac{\lambda_0}{2 n}\). If we put everything in <a href="lesson2.php">MEEP coordinates</a>, we get that:
</p>
<p>
\(t_{MEEP} = \left(m-\frac{1}{2}\right)*\frac{1}{2 n f_{MEEP}}\) (constructive)<br><br>
\(t_{MEEP} = m*\frac{1}{2 n f_{MEEP}}\) (destructive)
</p>
<p>
Since \(n=2\), and our center frequency is also 2, if we make our thickness 0.125, we should see destructive interference right at our center frequency. Is that what we see? Let's plot the reflection spectra of this oil-water system when we send a plane wave in from the air region. If you don't remember how to do that, don't worry, it's in <a href="lesson12.php">a previous lesson</a> :). Since our maximum frequency is 2.5 and our maximum index is 2, let's use a resolution of 40 to get at least 8 points per wavelength at all frequencies. If you don't remember how to choose the resolution, you can find that in <a href="lesson3.php">this lesson</a>.
</p>
<p>
Plotting the reflection spectra, it looks like this:
<?php addMobileImageFull('computational_em/thin_film_interference_1.png');?>
</p>
<p>
<i>Does this make sense?</i> Almost. It looks like the minimum is slightly shifted compared to what it should be (1.96 instead of 2). Let's see if doubling the resolution makes this better. If you double the resolution, you will find that, indeed, the new center frequency is about 1.98. Doubling it again will get it even closer, to ~1.995. Great! Our simulation is converging. Let's drop our resolution back down to 40. Now, what about other values of m? We should get destructive interference not just at \(m = 1\), but also \(m = 2, 3\), and so on. Let's increase our frequency to encompass frequencies from 1.5 to 7.5 so that we can see the first three minima. 
</p>

<?php
$counter = 0;
$counter = appendToQuiz($counter, 'What should the center frequency and the width be changed to so that we span frequencies from 1.5 to 7.5?',
	array('\(f_{cen}=1.5, f_{width}=6\)','\(f_{cen}=4, f_{width}= 7\)', '\(f_{cen}=2, f_{width}=1\)'), 1);
?>
<p>
Ok, what happens when we plot this? Let's take a look:
<?php addMobileImageFull('computational_em/thin_film_interference_wrong.png');?>
</p>
<p>
What on earth is this monstrosity? It's all kinds of ugly - it has the minima around 2, and one that <i>kinda</i> looks like it's near 4, along with the maxima at 1, 3, and 5 (ish?). What is going on...? 
</p>
<?php
$counter = appendToQuiz($counter, 'What is going on with the simulation?',
	array('The simulation time is too short', 'Nothing. Seems legit.', 'you forgot to increase the resolution'), 2);
?>
<p>
<p>Ah! We are working with higher frequencies now, we need to adjust the resolution. Let's also increase the number of frequencies to 200 so the plot doesn't look so choppy.
</p>
<?php
$counter = appendToQuiz($counter, 'What is the minimum resolution we should choose if our frequencies span the range of 1.5 to 7.5?',
	array('at least 120', 'at least 200', 'at least 8'), 0);
?>
<p>
Now, let's plot what this looks like: 
<?php addMobileImageFull('computational_em/thin_film_interference_less_wrong.png');?>
</p>
<p>
Ah, that's better. The minima are right where we expect them, as are the maxima. But the plot is still sloping downward... do we expect that? In this simple case, no, but often we won't know the answer to that question. How can we figure out whether this is an artifact of our simulation or not?
</p>
<?php
$counter = appendToQuiz($counter, 'How can we figure out whether this sloping graph is an artifact of our simulation?',
	array('convergence testing', 'definitely not convergence testing', 'throw up our hands in despair'), 0);
?>
<p>
Brilliant idea! Let's give it a try, doubling the resolution:
<?php addMobileImageFull('computational_em/thin_film_interference_slightly_wrong.png');?>
</p>
<p>
As you can see above, the downward sloping has been greatly reduced. If we were to increase our resolution further, we could eliminate it almost entirely.
</p>
<p>
In this practical example, we saw with our own eyes how critically important convergence testing was. If we hadn't done any convergence testing, and taken the first reflectance spectra at face value, we would have an answer that is qualitatively and quantitatively <i>completely different</i> from the correct answer. It is <i>always</i> critical, for this reason, to do convergence testing. In the <a href="lesson17.php">next lesson</a>, we will take thin-film interference to an extreme - with the dielectric mirror.
</p>
<h2>Full Code</h2>
<p>As usual, you can download the code <a href="thin_film_interference.py">here</a>, or find it below:
<pre class="prettyprint">
import meep as mp
import numpy as np
import matplotlib.pyplot as plt

resolution = 120
frequency = 4.0
frequencyWidth = 7
numberFrequencies = 200
pmlThickness = 2.0
animationTimestepDuration = 0.05
filmThickness = 0.125
materialThickness = 2.5
length = 2 * materialThickness + filmThickness +  2 * pmlThickness
powerDecayTarget = 1e-9
transmissionMonitorLocation = mp.Vector3(0, 0, materialThickness/4)
theta = np.radians(0)
kVector = mp.Vector3(np.sin(theta), 0, np.cos(theta)).scale(frequency - frequencyWidth/2)

cellSize = mp.Vector3(0, 0, length)

sources = [mp.Source(
    mp.GaussianSource(frequency=frequency,fwidth=frequencyWidth),
    component=mp.Ex,
    center=mp.Vector3(0, 0, -materialThickness/2)),
    ]

geometry = [mp.Block(
    mp.Vector3(mp.inf, mp.inf, filmThickness),
    center=mp.Vector3(0, 0, filmThickness/2),
    material=mp.Medium(index=2)),
    mp.Block(
    mp.Vector3(mp.inf, mp.inf, materialThickness + pmlThickness),
    center=mp.Vector3(0, 0, filmThickness + materialThickness/2 + pmlThickness/2),
    material=mp.Medium(index=1.3))]

pmlLayers = [mp.PML(thickness=pmlThickness, R_asymptotic=1e-35)]

simulation = mp.Simulation(
    cell_size=cellSize,
    sources=sources,
    resolution=resolution,
    boundary_layers=pmlLayers,
    k_point=kVector)

incidentRegion = mp.FluxRegion(center=mp.Vector3(0, 0, -materialThickness/4))
incidentFluxMonitor = simulation.add_flux(frequency, frequencyWidth, numberFrequencies, incidentRegion)

simulation.run(
    until_after_sources=mp.stop_when_fields_decayed(20, mp.Ex,
    transmissionMonitorLocation, powerDecayTarget))

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

simulation.run(mp.at_every(animationTimestepDuration, updateField),
        #until=endTime)
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
reflectionSpectraAxes = plt.axes(xlim=(frequency-frequencyWidth/2, frequency+frequencyWidth/2),ylim=(0, R.max()))
reflectionLine, = reflectionSpectraAxes.plot(frequencies, R, lw=2)
reflectionSpectraAxes.set_xlabel('frequency (a / \u03BB0)')
reflectionSpectraAxes.set_ylabel('R')
plt.show()
</pre>
<?php
addLessonNavigation("lesson15.php", "lesson17.php", "Multi-Angle Multi-Frequency Reflection", "Next");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
