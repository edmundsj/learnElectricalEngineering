import meep as mp
import numpy as np
import matplotlib.pyplot as plt
from matplotlib import animation

resolution = 16
frequency = 2.0
pmlThickness = 1.0
length = 5.0
length = length + 2 * pmlThickness
endTime = 5.0
courantFactor = 0.5
timestepDuration = courantFactor / resolution
numberTimesteps = int(endTime / timestepDuration)

cellSize = mp.Vector3(0, 0, length)

sources = [mp.Source(
    mp.ContinuousSource(frequency=frequency),
    component=mp.Ex,
    center=mp.Vector3(0, 0, 0))]

pmlLayers = [mp.PML(1.0)]

simulation = mp.Simulation(
    cell_size=cellSize,
    sources=sources,
    resolution=resolution,
    boundary_layers=pmlLayers)

simulation.run(until=timestepDuration)
field_Ex = simulation.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex)
fieldData = np.array(field_Ex)

for i in range(numberTimesteps-1):
    simulation.run(until=timestepDuration)
    fieldEx = simulation.get_array(center=mp.Vector3(0, 0, 0), size=cellSize, component=mp.Ex)
    fieldData = np.vstack((fieldData, fieldEx))

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

fieldAnimation = animation.FuncAnimation(fig, animate, init_func=init,
        frames=numberTimesteps, interval=20, blit=True)

fieldAnimation.save('basic_animation.mp4', fps=30, extra_args=['-vcodec', 'libx264'])
plt.show()
