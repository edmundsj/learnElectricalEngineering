<?php

echo'<html>';
include $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/head.php";
beginPage();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/header_menu.php";
beginWrapper();
?>

<!-- Main content goes here -->
<h1>Computational Electromagnetics with MEEP Part 1: Getting Started</h1>
<span class="image main"><img src="/images/pic13.jpg" alt="" /></span>
<h1>Lesson 3: (Extreme) Basics of FDTD</h1>
<?php
addLessonNavigationE("lesson1_2.php", "lesson1_4.php", "syllabus.php", "Units in MEEP", "Hello World", "Outline");
?>
<p>
Before we actually start writing our first program, there's a couple more things you should know about how simulators work. 
</p>
<h2>Garbage in, Garbage Out</h2>
<p>
When simulating <i>anything</i>, you should <i>always</i> start with something you can verify by hand, and you should constantly be asking yourself the question - <i>does this make sense?</i> This makes sure you know how to use the simulator, and that you aren't feeding it nonsense. There's a saying in the simulation world - "Garbage in, Garbage out". If you tell the simulator to simulate something ridiculous, it will do it, but the results will be worse than worthless (garbage), and even if they seem to make sense, you have no way of knowing. Let's start with something we can definitely verify by hand - a plane wave propagating in free space.
</p>
<h2>But what about infinity?</h2>
<p>
Planewaves are defined over all space, and we would like space to be infinite. MEEP (and most other simulators), unfortunately despite the best efforts of hordes of clever engineers, only have a finite amount of memory. So we have to restrict ourselves to a finite amount of space - this is called the "Simulation domain". So we have to choose how big our simulation domain should be. This is something of an art, but as a rule of thumb it should be as small as possible for you to get the answer you are looking for. Bigger simulation domains mean more computational time and more memory, which translates into unnecessary waiting.
</p>
<?php
$counter = 0;
$counter = appendToQuiz($counter, 'Suppose you are interested in watching a plane wave of wavelength \(1\mu m\) propagate by \(5 \mu m\) in free space. How long should your simulation domain be (in real units)?',
	array('\(5 \mu m\)', '\(20 \mu m\)', '\(100 \mu m\)'), 0);
?>
<p>
Planewaves are also defined for all <i>time</i>, and so I would love to run our simulation from \(-\infty\) to \(\infty \). Unfortunately, we run into the finite memory problem we had before. Besides, we won't be alive long enough to watch the results even if we had enough memory. This means we have to choose a time when we stop our simulation. As with the simulation domain size, longer simulations take longer to run, so we would like to choose a time that is as short as possible, but long enough to capture the important effects we are looking for. Let's do another example to illustrate the point.
<?php
$counter = appendToQuiz($counter, 'Suppose you are interested in watching a plane wave of wavelength \(1\mu m\) propagate by \(5 \mu m\) in free space. How long should your simulation <i>time</i> be?',
	array('\(16.68 fs \)', '\(2 fs\)', '\(5 fs\)'), 0);
?>
<h2>Split Space into pieces</h2>
<p>
As if things weren't bad enough, with only being able to simulate a finite time and a finite space, we can only simulate a finite <i>number of points</i> within our simulation domain. As you might imagine, if you don't choose enough points, you won't have an accurate representation of what's going on. For example, say you are simulating a planewave in one dimension. We actually want it to look like a continuous sinewave:
<?php addMobileImageFull('computational_em/sinewave_continuous.svg') ?>
But, if we don't have enough points (say we choose 5 points per wavelength), that sinewave might end up looking like this:
<?php addMobileImageFull('computational_em/sinewave_undersampled.svg') ?>
Looks more like a triangle to me than a sinewave. There are other, more subtle and serious consequences if we don't choose enough simulation points per wavelength - one being that waves in free space will not actually propagate at the speed of light. To avoid this and other unpleasantness, the developers of MEEP recommend having at least 8 points per wavelength (more will sometimes be necessary). In MEEP, you set this by changing the 'resolution' (let's call it \(R\)) - the number of sample points per characteristic length \(a\). If we want the number of points per wavelength, we just need to multiply the resolution by \(\frac{\lambda}{a}\):
</p>
<p>
\( points / \lambda = R * \frac{\lambda}{a} \)
</p>
<p>
So, as a starting point, by we should have a resolution \( R \geq 8*\frac{a}{\lambda} \). Note that this is not the <i>free space</i> wavelength, but the wavelength in your <i>highest-index material</i> (where the wavelength is the smallest). You want to make sure that you have enough points everywhere in your simulation domain. Let's do an example to hammer this home.
</p>
<?php
$counter = appendToQuiz($counter, 'As before, suppose you have a planewave of wavelength \(1 \mu m\), and you chose your characteristic length \(a\) to be \(500nm\). What should your resolution be (at least)?',
	array('\(1\)', '\(16\)', '\(8\)'), 1);
?>
<h2>And time, too!</h2>
<p>
Time is also split into discrete chunks so that we can fit a simulation in computer memory. Each such discrete point is called a 'timestep', because your simulator <i>steps</i> through time, one point after another (so we start on timestep 0, and then timestep 1, and so on...). In FDTD simulators, the time between timesteps (let's call it \(\Delta t\)) is actually coupled the resolution by this thing called the 'Courant Factor'. This prevents numerical instability in the simulator. The actual timestep \(\Delta t\), in seconds is given by 
</p>
<p>
\( \Delta t = \frac{S}{R}*\frac{a}{c}\)
</p>
<p>
Where \(a\) is the characteristic length, \(S\) is the Courant Factor, \(c\) is the speed of light, and \(R\) is the resolution. In MEEP, the default value of S is 0.5, and this should work for you unless you are doing something really weird (with refractive indices significantly smaller than 1). So, once you choose your resolution and characteristic length, you know what the time between timesteps must be.
</p>
<?php
$counter = appendToQuiz($counter, 'Suppose your characteristic length was chosen to be 300nm, and your resolution was selected to be 10. What is the amount of time between timesteps?',
	array('\(0.05fs\)', '\(5fs\)', '\(1fs\)'), 0);
?>
<h2>Simulation Setup</h2>
<p>
OK, now with our newfound knowledge let's figure out the simulation parameters we want. I'm going to choose a plane wave of a nice color, green, which has a free-space wavelength \(\lambda_0\) of about \(500nm\). Because we don't have any devices, let's just choose a characteristic length reasonably close to our wavelength but easy to remember - 1 micron. Now, let's figure out the frequency of the planewave in MEEP units (which we will have to enter into MEEP). Since we know the frequency (in MEEP units) is just the characteristic length divided by the wavelength, we get a frequency of 2. What about the size of our simulation domain? Since the wavelength is half a micron, I would like to see the wave propagate in space, so let's say we want to give enough space to see 10 periods of the wave. This means our simulation domain should be 5 microns long. Since our characteristic length is 1 micron, this means we need to enter 5 MEEP units for the length of the simulation domain (let's call it \(L_{MEEP}\)). 
</p>
<p>
How long should we run the simulation? Well, I would personally like to watch the planewave get from one side of the simulation domain to the other, so how long should that take? Since this is free space, the planewave travels at speed c, and it has to travel 10 wavelengths (the length of the simulation domain). This means we should run the simulation for about 16.7 femtoseconds, or exactly 5 MEEP time units (in keeping with the trend, let's call this \(T_{MEEP}\)).
</p>
<p>
Finally, what should our resolution be? Well, we want at least 8 points per wavelength, and we know the characteristic wavelength and the wavelength in our highest index material (free space). So this means we want a resolution of at least 16.
</p>
<p>
\(a = 1\mu m\), \(\lambda_0 = 500 nm \), \(L=5\mu m\), \(T=16.6782fs\)<br><br>
\(f_{MEEP} = \frac{a}{\lambda_0} = 2\)<br><br>
\(L_{MEEP} = \frac{L}{a} = 5 \)<br><br>
\(T_{MEEP} = T * \frac{c}{a} = 5 \)<br><br>
\(R \geq 8 \frac{a}{\lambda} = 16 \)<br><br>
</p>
<p>
Next, we will actually use this to set up our simulation.
</p>

<?php
addLessonNavigationE("lesson1_2.php", "lesson1_4.php", "syllabus.php", "Units in MEEP", "Hello World", "Outline");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
