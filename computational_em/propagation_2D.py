import numpy as np
import meep as mp
import matplotlib.pyplot as plt
from matplotlib import animation

frequency = 1
resolution = 32
pmlThickness = 1.0
cellSize = mp.Vector3(10,0,10)
sourceLocation = mp.Vector3(0,0,0)
sourceSize = mp.Vector3(10, 0, 0)
animationTimestepDuration = 0.05
endTime = 8
theta = np.radians(45)
kVector = mp.Vector3(np.sin(theta), 0, np.cos(theta)).scale(frequency)

def tiltFunction(vec):
    return np.exp(1j*2*np.pi*(kVector.x*vec.x + kVector.y*vec.y + kVector.z*vec.z))

sources = [mp.Source(mp.ContinuousSource(frequency=frequency, is_integrated=True),
        component = mp.Ey,
        center=sourceLocation,
        size=sourceSize,
        amp_func=tiltFunction
        )]

pmlLayers = [mp.PML(thickness=pmlThickness, direction=mp.Z)]

# First, run a simulation to get the shape of the field array
simulation = mp.Simulation(cell_size=cellSize,
        resolution=resolution,
        sources=sources,
        boundary_layers = pmlLayers,
        k_point=kVector)

simulation.run(until=0)
fieldEy = np.array(simulation.get_array(center=sourceLocation,size=cellSize, component=mp.Ey))
fieldData = np.array([np.zeros(fieldEy.shape)])

def updateField(sim):
    global fieldData
    fieldEy = np.array([sim.get_array(center=sourceLocation,size=cellSize,component=mp.Ey)])
    fieldData = np.vstack((fieldData, fieldEy))

simulation = mp.Simulation(cell_size=cellSize,
        resolution=resolution,
        sources=sources,
        boundary_layers=pmlLayers,
        k_point=kVector)

def animate(i):
    im.set_data(fieldData[i])
    return im,

simulation.run(mp.at_every(animationTimestepDuration, updateField), until=endTime)
fieldData = np.real(fieldData)
print(fieldData.shape)

fig, ax = plt.subplots()
im = ax.imshow(fieldData[0], cmap='RdBu', vmin=-1, vmax=1, extent=[cellSize.x/2, -cellSize.x/2, cellSize.z/2, -cellSize.z/2])
fig.colorbar(im)
numberAnimationTimesteps = len(fieldData)
fieldAnimation = animation.FuncAnimation(fig, animate, frames=numberAnimationTimesteps, interval=20, blit=True)
fieldAnimation.save('basic_animation.mp4', fps=30, extra_args=['-vcodec', 'libx264'])
plt.show()
