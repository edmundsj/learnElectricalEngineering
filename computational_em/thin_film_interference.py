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
