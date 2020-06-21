<?php

echo'<html>';
include $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/head.php";
beginPage();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/header_menu.php";
beginWrapper();
?>

<!-- Main content goes here -->
<h1>Computational Electromagnetics with MEEP: 2D MEEP</h1>
<span class="image main"><img src="/images/pic13.jpg" alt="" /></span>
<h1>Lesson 2: Gaussian Beam Propagation</h1>
<?php
addLessonNavigationE("lesson3_1.php", "lesson3_3.php", "syllabus.php", "2D MEEP", "Next", "Outline");
?>
<h2>But I thought we already used Gaussian beams!</h2>
<p>
No, not <a href="https://en.wikipedia.org/wiki/Pulse_(signal_processing)#Gaussian_pulse">that</a> kind of Gaussian pulse, but <a href="https://en.wikipedia.org/wiki/Gaussian_beam">this</a> kind of Gaussian beam. We have been dealing with pulses that turn on and off like Gaussians, and this has been <i>really</i> useful, because these pulses are very localized both in time and space (so our simulations can end quickly <i>and</i> we only represent a narrow band of frequencies). Now we are dealing with when the beam is <i>physically</i> shaped like a Gaussian. Why? Because Gaussian beams are easy to create in the lab. They are great starting points for coupling light into and out of finite devices, and for doing experiments. But most importantly for this lesson, there are exact closed-form equations that describe how these beams evolve.
</p>
<h2>The (Focused) Gaussian Beam</h2>
<p>
First, we want to see how a perfectly focused Gaussian beam propagates. In other words, we are starting with a "perfectly flat" Gaussian beam (the phase is zero across the entire beam). This is exactly what we have at the focus of a Gaussian beam. The beam can be polarized in the x/y plane (if we are propagating on the z-direction, so we'll just take it to be y-polarized. Then, the x-component can be written as a Gaussian:
</p>
\begin{equation}
E(r) = E_0 * e^{-\frac{r^2}{w_0^2}}
\end{equation}
<p>
Where \(E_0\) is the field amplitude at the center, \(w_0\) is called the "beam waist", which is the radius after which the field falls to \(1/e\) its initial value, and \(r\) is the distance from the center of the beam. If we plotted the field at \(t=0\), it should look like this:
</p>
<?php addMobileImageFull('computational_em/gaussian_beam_shape.svg'); ?>

<?php
$counter = 0;
$counter = appendToQuiz($counter, 'What is the field amplitude at \(r=3w_0\)?',
	array('\(1/e^2*E_0\)', '0.1', '\(1/e*E_0\)'), 0);
?>
<p>
So all we need to do in MEEP to create this Gaussian beam is use a source, as we have before, but add an amplitude function to give it the right shape. Let's do that now. Let's use a ContinuousSource so that we can see how the beam behaves at a single frequency and run the simulation just to see what happens (full code <a href="/code/computational_em/gaussian_propagation_2D.py">here</a>).
</p>
<pre class="prettyprint">
w0 = 1
def gaussianProfile(vec):
    return np.exp(-np.square((vec.x-sourceLocation.x)/w0))

sources = [mp.Source(mp.ContinuousSource(frequency=frequency, is_integrated=True),
        component = mp.Ey,
        center=sourceLocation,
        size=sourceSize,
        amp_func=tiltFunction
        amp_func=gaussianProfile
        )]
</pre>
<p>
Now, how do we figure out whether the simulation will make sense? Well, for a Gaussian beam, some clever physicists already solved exactly what the fields <i>should</i> be (the equation is a little complicated, see <a href="https://en.wikipedia.org/wiki/Gaussian_beam">Wikipedia</a> if you are interested.
</p>
<?php addMobileVideoFull('computational_em/gaussian_beam_animation.mp4'); ?>
<p>
On the right is a snapshot of what we expect to see (ignoring the PMLs). While our simulation result looks qualitatively similar, it doesn't appear to be decaying as quickly as we would expect. Why is this?
</p>
<h2>2D vs. 3D</h2>
<p>
Well, this is a <i>two-dimensional</i> simulation. What does that <i>actually</i> mean? It means that everything is assumed to be infinite along the third dimension. So our gaussian source isn't <i>really</i> gaussian, it's Gaussian along one dimension and infinite along the other. If we were to plot its cross section (imagine looking head-on at the beam from the direction it is propagating) it would look something like this:
<?php addMobileImageFull('computational_em/gaussian_beam_head_on.png'); ?>
</p>
<p>
An <i>actual</i> Gaussian beam should look like this:
<?php addMobileImageFull('computational_em/gaussian_beam_3D_head_on.png'); ?>
</p>
<p>

</p>
<?php
addLessonNavigationE("lesson3_1.php", "lesson3_3.php", "syllabus.php", "2D MEEP", "Next", "Outline");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
