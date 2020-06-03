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
materialThickness = 2.5
length = 2 * materialThickness + 2 * pmlThickness
powerDecayTarget = 1e-9

sourceLocation = mp.Vector3(0, 0, -materialThickness/2)
transmissionMonitorLocation = mp.Vector3(0, 0, materialThickness/4)
reflectionMonitorLocation = mp.Vector3(0, 0, -materialThickness/4)

cellSize = mp.Vector3(0, 0, length)

sources = [mp.Source(
    mp.GaussianSource(frequency=frequency,fwidth=frequencyWidth),
    component=mp.Ex,
    center=sourceLocation)
    ]

geometry = [mp.Block(
    mp.Vector3(mp.inf, mp.inf, materialThickness + pmlThickness),
    center=mp.Vector3(0, 0, materialThickness/2 + pmlThickness/2),
    material=mp.Medium(index=2))]

pmlLayers = [mp.PML(thickness=pmlThickness)]

simulation = mp.Simulation(
    cell_size=cellSize,
    sources=sources,
    resolution=resolution,
    dimensions=1,
    boundary_layers=pmlLayers)

incidentRegion = mp.FluxRegion(center=reflectionMonitorLocation)
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
    dimensions=1,
    geometry=geometry)

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

(x, y, z, w) = simulation.get_array_metadata()
indexArray = np.sqrt(simulation.get_epsilon())

fig = plt.figure()
ax = plt.axes(xlim=(min(z),max(z)),ylim=(-1,1))
line, = ax.plot([], [], lw=2)

colorArray = indexArray - 1 # make sure free space shows up as white
if(colorArray.max() > 0):
    colorArray = colorArray / colorArray.max() # normalize the color array so that the max index shows up dark blue
for i in range(len(indexArray) - 1):
    ax.fill_between([z[i], z[i+1]], [-1, -1], [1, 1],
            color=(1-colorArray[i],1-colorArray[i],1), linewidth=0.0, alpha=0.2)
ax.plot(sourceLocation.z, 0, 'ro')
ax.axvline(transmissionMonitorLocation.z, ymin=-1, color='black')
ax.axvline(reflectionMonitorLocation.z, ymin=-1, color='black')

def init():
    line.set_data([],[])
    return line,

def animate(i):
    line.set_data(z, fieldData[i])
    return line,

numberAnimationTimesteps = fieldData.shape[0]
fieldAnimation = animation.FuncAnimation(fig, animate, init_func=init,
        frames=numberAnimationTimesteps, interval=20, blit=True)

#fieldAnimation.save('basic_animation.mp4', fps=30, extra_args=['-vcodec', 'libx264'])
plt.show()
