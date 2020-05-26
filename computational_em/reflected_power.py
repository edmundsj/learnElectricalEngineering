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
