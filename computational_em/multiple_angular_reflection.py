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

plt.figure()
plt.pcolormesh(frequencyGrid, angleGrid, TGrid, cmap='hot', shading='gouraud', vmin=TGrid.min(), vmax=TGrid.max())
plt.xlabel("frequency (c/a)")
plt.ylabel("angle (degrees)")
plt.title("Transmittance")
cbar = plt.colorbar()
plt.show()
