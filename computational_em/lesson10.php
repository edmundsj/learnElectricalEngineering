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
<h1>Lesson 10: Finding Reflected Power</h1>
<?php
addLessonNavigation("lesson9.php", "lesson11.php", "Transmitted Power", "Next");
?>
<h2>Reflected power - Two Simulations, but different</h2>
<p>
In the <a href="lesson9.php">previous lesson</a> we computed transmitted power, and we saw that in order to normalize the transmitted power to the incident power, we had to run two simulations - one with no interface, where all we have is our source propagating through free space, and the second which does have the interface.
</p>
<p>
Here we are going to do basically the same thing to start - run the first simulation to find the incident power on the interface. Now, how do we compute the reflected power? Well, we have a problem. As in the previous simulation, we don't know what the reflected power is <i>by itself</i>. At the location we are measuring reflected power, we are measuring two waves that are interfering with each other - the incident wave and the reflected wave: 
</p>
<?php addMobileImageFull('computational_em/reflection_monitors_two-waves_reflection.svg'); ?>
<p>
Power is unfortunately not a linear function of the fields (we have to take the magnitude squared), so we can't just subtract out the incident power - we have to <i>subtract out the incident field</i>. What we want is a simulation that looks like this:
</p>
<?php addMobileImageFull('computational_em/reflection_monitors_reflected_wave.svg'); ?>
<p>
Where we only have the reflected wave present, so the monitor only captures the reflected power. We don't care what is happening after the interface in the transmission region, because we aren't measuring that. If we don't care about what's happening in the transmission region, then we can just take the fields from our second simulation (which contains the incident plus reflected field) and <i>subtract</i> the fields from the first simulation. On the left-hand side of the interface, this will give us exactly what we want. Let's give it a go. We basically just need to copy/paste our previous code that records the fields. I added the following code immediately after the first simulation (the one with propagation in free space) to record the incident field data in a variable called incidentFieldData:
</p>
<pre class="prettyprint">
simulation.run(until=0)
fieldEx = simulation.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex)
incidentFieldData = np.zeros(len(fieldEx))

def updateIncidentField(sim):
    global incidentFieldData
    fieldEx = sim.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex)
    incidentFieldData = np.vstack((incidentFieldData, fieldEx))

simulation.restart_fields()
</pre>
<p>
The simulation.run(until=0) at the beginning is just to figure out what the dimensions of our field data should be, and the simulation.restart_fields() at the end moves our fields back to time 0. We also want to change this line of code (running the first simulation):
</p>
<pre class="prettyprint">
simulation.run(until=endTime)
</pre>
<p>
To this:
</p>
<pre class="prettyprint">
simulation.run(mp.at_every(animationTimestepDuration, updateIncidentField), until=endTime)
</pre>
<p>
This makes sure we actually record the incident fields during the simulation. Finally, we subtract the two fields from each other:
</p>
<pre class="prettyprint">
reflectedFieldData = fieldData - incidentFieldData
</pre>
<p>
If we wanted to animate the fields, we would also need to change the line in the animate() function to grab the reflectedFieldData instead of the fieldData. Now, what does the result look like?
<?php addMobileVideoFull('reflected_fields_animation.mp4') ?>
</p>
<p>
Cool! It's exactly what we expected. As expected, there are no fields until after a couple of seconds, at which point fields both reflect and transmit from the interface. There's clearly some weird interference going on on the transmission side, because our incident and transmitted fields have different wavelengths, so the stuff on the right half of the simulation is total nonsense. But the left half contains exactly what we want - the reflected fields.
</p>
<h2>Now back to numbers</h2>
<p>
So this is really neat - to find the reflected power, all we have to do is <i>subtract</i> the incident field from the reflected field. Now let's try and actually get some numbers by integrating the flux. Fortunately, MEEP provides a built-in way of doing this. Rather than subtracting the fields <i>everywhere</i>, MEEP is able to only subtract them at a particular monitor of your choosing. This allows us to avoid doing even more post-processing once we subtract the fields, <i>and</i> it has the added benefit that we can compute both the reflected and transmitted power from the same simulation (because as we saw things get all kinds of wonky when you subtract the fields from the transmission region). We can do this immediately after running our first simulation using MEEP's get_flux_data function, which grabs the field data at the monitor of our choosing so that we can subtract it later:
</p>
<pre class="prettyprint">
incidentFluxToSubtract = simulation.get_flux_data(incidentFluxMonitor)
</pre>
<p>
Now, before we start the second simulation, but after we run the first, we add a monitor for the reflected data, and load in the incident flux we wanted to subtract (because of how MEEP works, it happens to be more efficient to load the flux you want to subtract first, and <i>then</i> get the flux from the second simulation)</p>
</p>
<pre class="prettyprint">
reflectionRegion = incidentRegion
reflectionFluxMonitor = simulation.add_flux(frequency, 0, 1, reflectionRegion)
simulation.load_minus_flux_data(reflectionFluxMonitor, incidentFluxToSubtract)
</pre>
<p>
Finally, after the second simulation has run, we can grab the reflected flux from the monitor we set up and then print the ratio of it to the incident flux to the screen:
</p>
<pre class="prettyprint">
reflectedFlux = mp.get_fluxes(reflectionFluxMonitor)[0]
print(reflectedFlux/incidentFlux)
</pre>
<p>
Now, if you run the simulation (depending on your current resolution, PML layer thickness, and simulation time), you should get \(T \approx 0.89\) and \(R \approx -0.107\). Hold up. Why is \(R\) negative? Isn't power always a positive quantity? Well, yes, but MEEP also has to keep track of the <i>direction</i> of the flow. A negative value just means that power is flowing in the \(-z\) direction, or toward the left. Just as expected. We can add in a minus sign to find \(R\), the fraction of reflected power:
</p>
<pre class="prettyprint">
R = -reflectedFlux / incidentFlux
</pre>
<p>
Tweaking the code to compute R, T, and print them to the screen, along with their sum (to see if energy is conserved)
</p>
<pre class="prettyprint">
T = transmittedFlux / incidentFlux
print(T)
print(R)
print(R + T)
</pre>
<p>
I get a value for R + T of \(1.0000032\), pretty darn close to 1. Our simulation very nearly conserves energy. This is a <i>very good idea</i> - always check to make sure energy conservation isn't violated by your system. That is an easy way to find something wrong with your simulation.
</p>

<p>
Well, this is really awesome! We have learned a lot so far. We can now use MEEP, an open-source electromagnetics simulator, to simulate electromagnetic fields propagating through space and reflecting off interfaces. We learned how to compute the reflected power and transmitted power from an interface, and how to visualize the resultant fields as the wave propagates. We learned about perfectly matched layers, convergence testing, and the subtleties involved when we have multiple fields interfering with each other. You might have noticed in these simulations a bunch of really high-frequency oscillations that persist for a while in the simulation. In the <a href="lesson11.php">next lesson</a> we're going to learn how to use those to our advantage - to turn our single-frequency simulation into a multi-frequency one without adding hardly <i>any</i> computation time.
</p>
<h2>Full Code</h2>
<p>
You can download the full code for this lesson <a href="reflected_power.py">here</a>
</p>
<pre class="prettyprint">
import meep as mp
import numpy as np
import matplotlib.pyplot as plt
from matplotlib import animation

resolution = 64
frequency = 2.0
pmlThickness = 4.0
endTime = 20.0
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

simulation.run(until=0)
fieldEx = simulation.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex)
incidentFieldData = np.zeros(len(fieldEx))

def updateIncidentField(sim):
    global incidentFieldData
    fieldEx = sim.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex)
    incidentFieldData = np.vstack((incidentFieldData, fieldEx))

simulation.restart_fields()

incidentRegion = mp.FluxRegion(center=mp.Vector3(0, 0, -materialThickness/4))
incidentFluxMonitor = simulation.add_flux(frequency, 0, 1, incidentRegion)

simulation.run(mp.at_every(animationTimestepDuration, updateIncidentField), until=endTime)
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
transmissionFluxMonitor = simulation.add_flux(frequency, 0, 1, transmissionRegion)
reflectionRegion = incidentRegion
reflectionFluxMonitor = simulation.add_flux(frequency, 0, 1, reflectionRegion)
simulation.load_minus_flux_data(reflectionFluxMonitor, incidentFluxToSubtract)

def updateField(sim):
    global fieldData
    fieldEx = sim.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex)
    fieldData = np.vstack((fieldData, fieldEx))

simulation.run(mp.at_every(animationTimestepDuration, updateField), until=endTime)

incidentFlux = mp.get_fluxes(incidentFluxMonitor)[0]
transmittedFlux = mp.get_fluxes(transmissionFluxMonitor)[0]
reflectedFlux = mp.get_fluxes(reflectionFluxMonitor)[0]
R = -reflectedFlux / incidentFlux
T = transmittedFlux / incidentFlux
print(T)
print(R)
print(R + T)

fig = plt.figure()
ax = plt.axes(xlim=(-length/2,length/2),ylim=(-1,1))
line, = ax.plot([], [], lw=2)
xData = np.linspace(-length/2, length/2, fieldData.shape[1])

reflectedFieldData = fieldData - incidentFieldData

def init():
    line.set_data([],[])
    return line,

def animate(i):
    line.set_data(xData, reflectedFieldData[i])
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
addLessonNavigation("lesson9.php", "lesson11.php", "Transmitted Power", "Next");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
