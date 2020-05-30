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
<h1>Lesson 14: Multi-Frequency Oblique Incidence Reflection</h1>
<?php
addLessonNavigation("lesson13.php", "lesson15.php", "Reflection at an Angle", "Next");
?>
<h2>All the frequencies!</h2>
<p>
In the last lesson, we learned how to change the angle of our incident planewave source, we found the transmission coefficinet at an angle of incidence of 30 degrees, and we did some convergence testing to see how accurate that was. But we used only a single frequency when we have a wide range of frequencies available from our source - let's fix that.
</p>
<p>
Fortunately, all we have to do, as before, is change a single line of code, setting numberFrequencies equal to something other than 1 (I picked 50, because it's enough to make a curve, but not so many that you can't read all the numbers. We could pick up to the number of timesteps, but that would be unnecessary). 
</p>
<pre class="prettyprint">
numberFrequencies = 50
</pre>
<p>
Now let's run the simulation. What do we get? Well, I'm getting a range of transmission coefficients, looks like from 0.956 to 0.935. <i>Does this make sense?</i> Well, no, not really. At a fixed angle, we don't expect there to be any frequency dependence, since our material has a constant index that is independent of frequency. We expect all of the values of \(R\) and \(T\) to be the same. But, as before, maybe it's just an artifact of the simulation - we haven't converged yet. Let's try with higher resolutions - I'll go from 64 to 128 to to 256.
</p>
<h2>Huh, weird.</h2>
<p>
Huh. That's weird. The range of transmission coefficents actually get <i>wider apart</i> as I increase the resolution. The maximum goes from 0.956 &#8594; 0.951 &#8594; 0.9497 &#8594; 0.9494, but the minimum transmission coefficient goes from 0.935 &#8594; 0.914 &#8594; 0.9096 &#8594; 0.9083. What on earth? Our simulation appears to be <i>diverging</i>, not <i>converging</i>. It turns out that this is actually a subtletly of MEEP - we <i>thought</i> we had fixed the <i>angle</i>, but really we only fixed a value of \(k_x\). 
</p>
<h2>kx vs. angle</h2>
<p>
You might expect that if you set a specific k-vector for your plane wave, and you use a gaussian pulse, that the data you get corresponds to a single angle \(\theta\) and a bunch of different frequencies. This is what I assumed! Unfortunately, this is not the case. We aren't fixing \(\theta\) directly by applying the boundary conditions (our k-vector). We are fixing \(k_x\). 
</p>
<?php addMobileImageFull('computational_em/stretching_k_vector.svg'); ?>
<p>
Look at the figure above, where the blue k-vector corresponds to a higher frequency than the red k-vector at a fixed \(k_x\). We know that in free space \(|\overrightarrow{k}|=\frac{\omega}{c}\). This means that the <i>magnitude</i> of the k-vector increases with frequency. So if we <i>fix</i> \(k_x\), and we choose a different frequency, the magnitude of \(\overrightarrow{k}\) will change. This means, as you can see in the figure above, that the angle \(\theta\) <i>must</i> change. So when we perform a simulation at a known k-vector and sample with a bunch of frequencies, each different frequency corresponds to a <i>different</i> angle. This is a subtle point, but an important one - it all comes back to the fact that FDTD uses boundary conditions to tilt a plane wave, rather than tilting it 'directly'.
</p>
<h2>Finding the angle</h2>
<p>
To find \(\theta\) as a function of the MEEP variables we actually have access to - ideally in terms of the variable kVector we've already entered into MEEP and the frequency. Remember that \(k_x\) (see figure above) is just equal to \(|\overrightarrow{k}| sin\theta\). Rearranging to solve for \(\theta\):
</p>
<p>
\( \theta = sin^{-1}\left(\frac{k_x}{|\overrightarrow{k}|}\right)\)
</p>
<p>Now, remember from the <a href="lesson13.php">previous lesson</a> that in terms of the MEEP quantity that we enter, \(k_{x,MEEP}=\frac{k_x*a}{2\pi}\). After plugging this in, using the fact that \( |\overrightarrow{k}| = \frac{\omega}{c} \) in free space, we can solve for \(\theta\) in terms of variables we have access to in MEEP:
</p>
<p>
\( \theta = sin^{-1}\left(\frac{k_{x,MEEP}}{f_{MEEP}}\right)\)
</p>
<?php
$counter = 0;
$counter = appendToQuiz($counter, 'Say you are running a simulation with a specified kx of 1 and frequencies from 1.5 to 2.5. What are the range of angles you are simulating?',
	array('0 degrees to 10 degrees', '23.6 degrees to 41.8 degrees', 'only 30 degrees'), 1);
?>
<h2>Multiple Simulations</h2>
<p>
This means that we actually <i>cannot</i> get data for multiple frequencies at a single angle with one simulation - doing a multi-frequency simulation <i>necessarily</i> is done at a bunch of different angles. So what do we do if we just want data at a particular angle for a bunch of frequencies? Well, we have to do several simulations. 
</p>
<p>
The basic idea is just to put all the code we had previously to run our simulation in one large function (please forgive me <a href="https://www.amazon.com/Clean-Code-Handbook-Software-Craftsmanship/dp/0132350882">Robert Martin</a>), and then run a bunch of simulations at a bunch of different angles. This will give us the same angle (roughly) at several different frequencies. Then we will have a 2D dataset, and we can plot that directly or slice it however we please. But first, let's make sure the simulation we want to run will actually work at angles other than 30 degrees - if we're going to test a bunch of angles we should make sure of that.
</p>
<h2>Steep angle - let's shoot for 80</h2>
<p>
What angle should we try next? Let's go for 80. We might be interested in finding the <a href="https://en.wikipedia.org/wiki/Brewster%27s_angle">Brewster angle</a>, for example, so we will want to do pretty slanted angles to find it. So let's change the angle of the planewave, using the code in the <a href="lesson13.php">previous lesson</a>:
</p>
<pre class="prettyprint">
theta = np.radians(80)
</pre>
<p>
Tick tock, tick tock. This sure is taking a long time. Like, a REALLY long time compared to the previous simulations we were doing. Mine is at 5000 time units as I write this and going strong. It also looks like the power MEEP is monitoring to cut off the simulation is decaying <i>really</i> slowly. This is totally unlike anything we encountered before - what is going on?
</p>
<h2>What are the range of angles?</h2>
<p>
Well, what are the range of angles for this simulation? Let's start there. What is the value of \(k_x\) we are using? Well, it's just \(sin\theta\) multiplied by our center frequency (2). So about ~1.97, or pretty darn close to 2. What is the range of angles that corresponds to? Try to answer the question below before reading on. 
<?php
$counter = appendToQuiz($counter, 'Suppose kx is 2, and our frequencies span from 1.5 to 2.5. What is the range of angles this corresponds to?',
	array('Exactly 90 degrees', '53 degrees to 90 degrees', '53 degrees to... a complex angle?'), 2);
?>
<p>
You might have noticed that when you try to take the inverse sin of kx over our minimum frequency (1.5), we get a <i>complex number</i>, or if your calculator can only handle real numbers, 'not a number'. This is weird - the math seems pretty simple, what did we do wrong? We can get some intuition for what is going on by drawing things out. Let's draw in particular the \(k_x\) component of our k-vector, and the k-vector itself at the minimum frequency of 1.5 (MEEP units, as usual). We know the magnitude of the k-vector is just equal to the frequency (all in MEEP units), so the magnitude of the k-vector is 1.5, and the angle is pretty close to vertical (80 degrees).
</p>
<p>
<?php addMobileImageFull('computational_em/k_vector_complex_figure.svg'); ?>
</p>
<p>Something doesn't smell right about this figure. How can \(k_x\), a <i>component</i> of \(\overrightarrow{k}\), be larger than \(\overrightarrow{k}\) itself?! Well, in order for this to happen, the component along z <i>must</i> be imaginary. An imaginary \(k_z\) corresponds to a decaying wave along the z-direction, rather than a propagating wave. This might not seem like a problem, but here comes the rub - it turns out PMLs HATE decaying waves. Because of how this PML is formulated (standard uniaxial PML), it <i>will not</i> attenuate decaying waves inside it, only traveling waves. This means some energy may <i>never</i> leave the simulation, and it could stay around indefinitely. 
</p>
<p>
How do we fix this? You might imagine a couple different solutions, but the most direct is just to make sure we never introduce decaying waves in the first place. This means we need to make sure that \(k_x\) is <i>always</i> smaller than \(|\overrightarrow{k}|\). (I've dropped the subscript MEEP because it's cluttering things up, but this is what I'm referring to). This means we want \(k_x\) to take the <i>minimum</i> value of \(|\overrightarrow{k}|\) over the range of frequencies we are testing. For the example above, and the code we have been working with, we want \(k_x\) to be no larger than 1.5. This means rather than scaling our k-vector by the <i>center</i> frequency, we scale it by the <i>minimum</i> frequency. Then, no matter what angle we choose, \(k_x\) will always be smaller than \(|\overrightarrow{k}|\) for all frequencies in our simulation - we're safe. There's the added subtlety, though, that our center frequency will no longer correspond to the angle we specified, but that's ok, we need to run our simulation at a bunch of different angles anyway to get the results we wanted. If you change the line of code defining the k-vector to this (I added in a variable called minimumFrequency to make it clear what's going on):
</p>
<pre class="prettyprint">
minimumFrequency = frequency - frequencyWidth/2
kVector = mp.Vector3(np.sin(theta), 0, np.cos(theta)).scale(minimumFrequency)
</pre>
<p>
It does exactly what we want, and you will find that your simulation will actually run this time. In the <a href="lesson15.php">next lesson</a> we will figure out how to run our multi-frequency, multi-angle simulation and extract useful data fram it, by developing some code for running the simulations and plotting their results.
</p>

<?php
addLessonNavigation("lesson13.php", "lesson15.php", "Reflection at an Angle", "Next");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
