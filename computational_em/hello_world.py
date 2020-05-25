import meep as mp

resolution = 16
frequency = 2.0
length = 5.0
endTime = 5.0

cellSize = mp.Vector3(0, 0, length)

sources = [mp.Source(
    mp.ContinuousSource(frequency=frequency),
    component=mp.Ex,
    center=mp.Vector3())]

simulation = mp.Simulation(
    cell_size=cellSize,
    sources=sources,
    resolution=resolution)

simulation.run(until=endTime)
