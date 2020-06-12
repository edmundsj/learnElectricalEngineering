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
<h1>Lesson 9: Multi-Frequency, Multi-Angle Simulations</h1>
<?php
addLessonNavigationE("lesson2_8.php", "lesson2_9.php", "syllabus.php", "Multi-Frequency Angule", "Efficient Multi-Angle", "Outline");
?>
<h2>All the simulations!</h2>
<p>
In the <a href="lesson14.php">previous lesson</a>, we saw that if we want several frequencies at a single angle of incidence, we <i>must</i> do a bunch of simulations at <i>different</i> angles of incidence, because of we have several frequencies in one simulation we necessarily have different corresponding angles.
</p>
<p>
So how do we do that? Let's start with the code from <a href="lesson13.php">two lessons ago</a>, and modify it to suit our needs. First, we'll want to make sure to scale the k-vector to the minimum frequency instead of the center frequency, as we discussed in <a href="lesson14.php">the last lesson</a>. First, I'm going to delete all the code that has to do with recording the field data (comment it out instead or create a new file if this makes you queasy). This is just because since we want to run a bunch of simulations, recording the field each time and plotting it is going to slow us down quite a bit. And we all have better things to do with our lives than sit around and wait for our simulators to do our bidding.
</p>
<p>
We're also going to put everything to do with actually running our simulations inside a single function, so that we can run it a bunch of times. This function should take as an argument the angle, in degrees, that we want to run the simulation at, and then run the necessary simulation(s) and give us back the values of \(R\) and \(T\) at each frequency, along with the angles those correspond to. We could compute those latter ones separately, but I think this is simpler. I've called the function runSimulation() (because I'm creative like that):
</p>
<pre class="prettyprint">
def runSimulation(thetaDegrees):
    thetaRadians = np.radians(thetaDegrees)
    kVector = mp.Vector3(np.sin(thetaRadians), 0, np.cos(thetaRadians)).scale(minimumFrequency)
    simulation = mp.Simulation(
        cell_size=cellSize,
        sources=sources,
        resolution=resolution,
        boundary_layers=pmlLayers,
        k_point=kVector)

    incidentFluxMonitor = simulation.add_flux(frequency, frequencyWidth, numberFrequencies, incidentRegion)

    simulation.run(until_after_sources=mp.stop_when_fields_decayed(20, mp.Ex,
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

    simulation.run(until_after_sources=mp.stop_when_fields_decayed(20, mp.Ex,
                transmissionMonitorLocation, powerDecayTarget))

    incidentFlux = np.array(mp.get_fluxes(incidentFluxMonitor))
    transmittedFlux = np.array(mp.get_fluxes(transmissionFluxMonitor))
    reflectedFlux = np.array(mp.get_fluxes(reflectionFluxMonitor))
    R = np.array(-reflectedFlux / incidentFlux)
    T = np.array(transmittedFlux / incidentFlux)

    frequencies = np.array(mp.get_flux_freqs(reflectionFluxMonitor))
    kx = kVector.x
    angles = np.arcsin(kx/frequencies)

    return angles, frequencies, R, T

</pre>
<p>
First, we ened to choose the different angles we will be running this function at. Let's set our maximum angle to 85, with a minimum angle of 0, and increment the angle in units of 5 degrees. You can choose whatever you want, but I think this is a good starting point:
</p>
<pre class="prettyprint">
angleIncrement = 5
angleMin = 0
angleMax = 10
anglesToTest = np.arange(angleMin, angleMax + angleIncrement, angleIncrement)
</pre>
<p>
Now comes a bit of a tricky part. Since we have a several different angles <i>and</i> many different frequencies, our data is two-dimensional. But while the frequency data is evenly spaced, the angular data is some awkward contortion of arcsin of stuff multiplied by sin. So we can't just record the data \(R\) and \(T\) by itself in a 2D array, we have to also record the value of \(f\) and \(\theta\) that each of those \(R\) and \(T\) came from. So we actually want four 2D arrays. One for \(R\), one for \(T\), one for the value of \(\theta\) for each of those, and one for the value of \(f\). Fortunately, we already know the size of these 2D arrays - just the number of angles by the number of frequencies.
</p>
<pre class="prettyprint">
angleGrid = np.zeros((len(anglesToTest), numberFrequencies))
frequencyGrid = np.zeros((len(anglesToTest), numberFrequencies))
RGrid = np.zeros((len(anglesToTest), numberFrequencies))
TGrid = np.zeros((len(anglesToTest), numberFrequencies))
</pre>
<p>
Now that all our variables are set up, we can just run the simulation with a bunch of different angles, and plop the data in the appropriate variables:
</p>
<pre class="prettyprint">
i = 0;
for theta in anglesToTest:
    angles, frequencies, R, T = runSimulation(theta)
    angleGrid[i] = np.degrees(angles)
    frequencyGrid[i] = frequencies
    RGrid[i] = R
    TGrid[i] = T
    i = i + 1
</pre>
<p>
To make sure everything makes sense, let's print \(R+T\) to the screen (as long as all the values are close to 1, energy conservation holds and nothing went horribly wrong).
</p>
<pre class="prettyprint">
CGrid = RGrid + TGrid
print(CGrid) # make sure that conservation of energy holds for all frequencies tested.
</pre>

<p>And that's it! We've got all our data. All that's left is to visualize it and make sure it's not hopelessly wrong. To do this we're going to use matplotlib's "pcolormesh", which takes the angle and frequency grids we generated before and plots the value of \(R\) or \(T\) using a heatmap:
</p>
<pre class="prettyprint">
plt.figure()
plt.pcolormesh(frequencyGrid, angleGrid, TGrid, cmap='hot', shading='gouraud', vmin=TGrid.min(), vmax=TGrid.max())
plt.xlabel("frequency (c/a)")
plt.ylabel("angle (degrees)")
plt.title("Transmittance")
cbar = plt.colorbar()
plt.show()
</pre>
<?php addMobileImageFull('computational_em/transmittance_2D_32_res.png'); ?>
<p>
Do our results make sense? Let's check a couple things. First, does conservation of energy hold? It looks like for the most part, yes, although there are some data points in the 80-degree simulation (the first couple) that have \(R+T\) of ~0.95, so I wouldn't trust that data. That corresponds to the awkward-looking smear in the upper left. How else can we check if this data makes sense? Well, one distinguishing feature we can look for, since this is a p-polarized EM wave, is <a href="https://en.wikipedia.org/wiki/Brewster%27s_angle">Brewster's Angle</a>, at which the transmittance should become 1. We we expect to find it at \(tan^{-1}\left(n_2/n_1\right)\), or about 63 degrees. We do indeed see the transmittance go to 1 at what looks like an angle of 63 degrees. What about the rest of the plot? Do we expect the transmittance to depend on frequency? As in a <a href="lesson13.php">previou lesson</a>, no, we don't, because our refractive index is not a function of wavelength. It looks like this graph isn't perfectly constant over frequency at a given angle. For this and the smudge in the upper-left, I don't really love this plot. Let's try with higher resolutions.
</p>
<p>
After trying resolutions of 64 and 128, the smudge doesn't look a whole lot better, but the graph looks more frequency-independent. We could try increasing the size of the PML or increasing the distance from the source to the PML, but that corner corresponds to frequencies on the edge of our distribution, which have very low amplitudes and high error in the first place. If we want data from that corner, we should run a simulation at a different (lower) center frequency.
</p>
<p>
There's one more thing we could do to check if our data makes sense - we could actually plot the known values of the transmission coefficient using <a href="https://en.wikipedia.org/wiki/Fresnel_equations">Fresnel's equations</a>, using the angles we already generated.
</p>
<p>
\(T_p = 1 - |\frac{n_1 cos\theta_2 - n_2 cos\theta_1}{n_1 cos\theta_2 + n_2 cos\theta_1}|^2\)
</p>
<p>
We can write a function that does this, and then create a new variable that calculates the value of \(T\) everywhere we have a value from MEEP:
</p>
<pre class="prettyprint">
def Tp(theta1Degrees):
    theta1 = np.radians(theta1Degrees)
    theta2 = np.arcsin(n1/n2 *np.sin(theta1))
    return 1 - np.square(np.abs( (n1*np.cos(theta2) - n2*np.cos(theta1)) / (n1*np.cos(theta2) + n2*np.cos(theta1))))
TAnalyticGrid = Tp(angleGrid)
</pre>
<p>
Now, to change the code to plot both figures side by side, you will have to tweak the plotting function a bit (I've posted it below and took it from <a href="https://matplotlib.org/3.2.1/gallery/images_contours_and_fields/pcolormesh_levels.html#sphx-glr-gallery-images-contours-and-fields-pcolormesh-levels-py">matplotlib's documentation</a>).
</p>
<pre class="prettyprint">
fig, (simulationAxes, analyticAxes) = plt.subplots(ncols=2)

analyticPlot = analyticAxes.pcolormesh(frequencyGrid, angleGrid, TAnalyticGrid,
        cmap='hot', shading='gouraud', vmin=TGrid.min(), vmax=TGrid.max())
analyticAxes.set_title('Analytic T')
fig.colorbar(analyticPlot,  ax=analyticAxes)
analyticAxes.set_xlabel("frequency (c/a)")
analyticAxes.set_ylabel("angle (degrees)")


simulationPlot = simulationAxes.pcolormesh(frequencyGrid, angleGrid, TGrid,
        cmap='hot', shading='gouraud', vmin=TGrid.min(), vmax=TGrid.max())
simulationAxes.set_title('MEEP T')
fig.colorbar(simulationPlot, ax=simulationAxes)
simulationAxes.set_xlabel("frequency (c/a)")
simulationAxes.set_ylabel("angle (degrees)")

plt.show()
</pre>
<p>
Now, if you run the code in ets entirety, you will get two plots, side-by-side:
<?php addMobileImageFull('computational_em/transmittance_2D_both_64_res.png'); ?>
</p>
<p>
Those plots look pretty darn similar to me. Except for the smudge in the upper-left I can't tell them apart. 
</p>
<p>Awesome. We now know how to simulate and plot reflection and transmission spectra as a function of frequency <i>and</i> angle for an interface. In the <a href="lesson16.php">next lesson</a>, we will build on what we learned here and investigate a case where we <i>do</i> have wavelength dependence of our reflection and transmission spectra - thin-film interference.
</p>
<h2>Full Code</h2>
<p>Download the full code for this lesson <a href="multiple_angular_reflection.py">here</a>, or see it below:
<pre class="prettyprint">
import meep as mp
import numpy as np
import matplotlib.pyplot as plt
from matplotlib import animation

resolution = 64
frequency = 2.0
frequencyWidth = 1
minimumFrequency = frequency - frequencyWidth/2
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
    center=mp.Vector3(0, 0, -materialThickness/2)),
    ]

geometry = [mp.Block(
    mp.Vector3(mp.inf, mp.inf, materialThickness + pmlThickness),
    center=mp.Vector3(0, 0, materialThickness/2 + pmlThickness/2),
    material=mp.Medium(index=2))]

pmlLayers = [mp.PML(thickness=pmlThickness)]

incidentRegion = mp.FluxRegion(center=mp.Vector3(0, 0, -materialThickness/4))

def runSimulation(thetaDegrees):
    thetaRadians = np.radians(thetaDegrees)
    kVector = mp.Vector3(np.sin(thetaRadians), 0, np.cos(thetaRadians)).scale(minimumFrequency)
    simulation = mp.Simulation(
        cell_size=cellSize,
        sources=sources,
        resolution=resolution,
        boundary_layers=pmlLayers,
        k_point=kVector)

    incidentFluxMonitor = simulation.add_flux(frequency, frequencyWidth, numberFrequencies, incidentRegion)

    simulation.run(until_after_sources=mp.stop_when_fields_decayed(20, mp.Ex,
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

    simulation.run(until_after_sources=mp.stop_when_fields_decayed(20, mp.Ex,
                transmissionMonitorLocation, powerDecayTarget))

    incidentFlux = np.array(mp.get_fluxes(incidentFluxMonitor))
    transmittedFlux = np.array(mp.get_fluxes(transmissionFluxMonitor))
    reflectedFlux = np.array(mp.get_fluxes(reflectionFluxMonitor))
    R = np.array(-reflectedFlux / incidentFlux)
    T = np.array(transmittedFlux / incidentFlux)

    frequencies = np.array(mp.get_flux_freqs(reflectionFluxMonitor))
    kx = kVector.x
    angles = np.arcsin(kx/frequencies)

    return angles, frequencies, R, T

angleIncrement = 5
angleMin = 0
angleMax = 80
anglesToTest = np.arange(angleMin, angleMax + angleIncrement, angleIncrement)

angleGrid = np.zeros((len(anglesToTest), numberFrequencies))
frequencyGrid = np.zeros((len(anglesToTest), numberFrequencies))
RGrid = np.zeros((len(anglesToTest), numberFrequencies))
TGrid = np.zeros((len(anglesToTest), numberFrequencies))

i = 0;
for theta in anglesToTest:
    angles, frequencies, R, T = runSimulation(theta)
    angleGrid[i] = np.degrees(angles)
    frequencyGrid[i] = frequencies
    RGrid[i] = R
    TGrid[i] = T
    i = i + 1

CGrid = RGrid + TGrid
print(CGrid) # make sure that conservation of energy holds for all frequencies tested.

fig, (simulationAxes, analyticAxes) = plt.subplots(ncols=2)

analyticPlot = analyticAxes.pcolormesh(frequencyGrid, angleGrid, TAnalyticGrid,
        cmap='hot', shading='gouraud', vmin=TGrid.min(), vmax=TGrid.max())
analyticAxes.set_title('Analytic T')
fig.colorbar(analyticPlot,  ax=analyticAxes)
analyticAxes.set_xlabel("frequency (c/a)")
analyticAxes.set_ylabel("angle (degrees)")


simulationPlot = simulationAxes.pcolormesh(frequencyGrid, angleGrid, TGrid,
        cmap='hot', shading='gouraud', vmin=TGrid.min(), vmax=TGrid.max())
simulationAxes.set_title('MEEP T')
fig.colorbar(simulationPlot, ax=simulationAxes)
simulationAxes.set_xlabel("frequency (c/a)")
simulationAxes.set_ylabel("angle (degrees)")

plt.show()
</pre>
<?php
addLessonNavigationE("lesson2_8.php", "lesson2_9.php", "syllabus.php", "Multi-Frequency Angule", "Efficient Multi-Angle", "Outline");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
