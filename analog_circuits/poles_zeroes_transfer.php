<?php

echo'<html>';
include $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/head.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/header_menu.php";
beginPage();
beginWrapper();
?>

<!-- Main content goes here -->
<h1>Analog Circuits</h1>
<span class="image main"><img src="/images/pic13.jpg" alt="" /></span>
<h1>Lesson 2.3: Poles, zeroes, and transfer functions</h1>
<h2>Transfer functions</h2>
<!--- relationships between current and voltage --->
<p>Transfer functions are ratios between input and output values. They describe what a circuit does to an input signal. The voltage gain we've been talking about is one example of a transfer function. It's defined as the ratio between the output voltage \( V_o \) and the input voltage \( V_{in} \):
\[ A_v(s) = \frac{V_o}{V_{in}}. \]
When you're solving a circuit, what you're doing is finding the transfer function for that circuit. If you solve a voltage divider circuit for the output, you've found the voltage gain of the circuit. (It's not really a "gain" in the traditional sense, because \( A_v(s) < 1 \) for a voltage divider, but it's a "gain function." So when I say you've found the "gain," I really mean that you've found the gain <i>function</i>.) </p>

<p>
There are other types of transfer functions, too. Here's the full list.
<ul>
<li>Voltage gain \[ A_{v}(s) = G_{v}(s) = \frac{V_{o}}{V_{in}} \]</li>
<li>Current gain \[ G_{i}(s) = \frac{I_{o}}{I_{in}} \]</li>
<li>Transimpedance \[ Z(s) = \frac{V_{o}}{I_{in}} \]</li>
<li>Transadmittance \[ Y(s) = \frac{I_{o}}{V_{in}} \]</li>
<li>Driving-point transimpedance \[ Z_{dp}(s) = \frac{V_{1}}{I_{1}} \]</li>
<li>Driving-point transadmittance \[ Y_{dp}(s) = \frac{I_{1}}{V_{1}} \]</li></p>

<p>Hmm... The driving-point transimpedance and driving-point transadmittance look awfully similar to the standard transimpedance and transadmittance. What's the difference? The difference is the driving-point transimpedance and driving-point transadmittance are measured at the same location. Suppose I inject a current source into a port, which we'll call port (1), and I measure the voltage across that same current source. That means I've measured the transimpedance at port (1). The subscripts on the voltage and current in \( Z_{dp} \) and \( Y_{dp} \) tell me which port I took the measurement at. They had better be the same if it's a driving-point impedance or admittance. </p>

<p>This is literally all there is to it. Circuit analysis boils down to solving for at least one of these six transfer functions. Talking about other things like poles and zeros can help you understand how the transfer functions behave, but you're ultimately going to derive all your answers from the transfer function itself. </p>

<p>If we're talking about some general transfer function, and we don't care which of the six it is, we call this general transfer function \( H(s) \). We write \( H(s) \) as
\[ H(s) = \frac{N(s)}{D(s)}, \]
where \( N(s) \) is whatever the numerator turns out to be, and \( D(s) \) is whatever the denominator turns out to be.</p>
<h2>Zeros</h2>
<p>For finding poles and zeros, we are asking the question, "What happens to \( H(s) \) when \( s \rightarrow 0 \)?" Sometimes \( H(s) \rightarrow \infty \) when \( s \rightarrow 0 \), and other times \( H(s) \rightarrow 0 \) when \( s \rightarrow 0 \). There are special frequencies where these things happen, so we call those frequencies <i>poles</i> and <i>zeros</i>.</p>

<p>A zero is a frequency \( \omega_z \) at which \( N(s) \rightarrow 0 \), so that \( H(s) \rightarrow 0 \). The numerator \( N(s) \) can always be written as
\[ N(s) = 1 + \frac{s}{\omega_z},\]
so when \( s = -\omega_z, N(s) = 0 \). This corresponds to the conditions we set up for the Extra Element Theorem in the last lesson: set the output to zero, and find the conditions for the circuit where this is true. Calculating the null impedance \( Z_n \) and finding these conditions algebraically are completely equivalent ways of finding those conditions.</p>
<h2>Poles</h2>
<p>A pole is a frequency \( \omega_p \) at which \( D(s) \rightarrow 0 \), so that \( H(s) \rightarrow \infty \). The denominator \( D(s) \) can be written in a similar form as we wrote \( N(s), \)
\[ D(s) = 1 + \frac{s}{\omega_{p}} \]
When \( s = -\omega_p, D(s) \rightarrow 0. \) Again, this is really similar to the conditions that we set up for the Extra Element Theorem last lesson. Since we can't calculate what happens when the output \( N(s) \rightarrow \infty, \) we set the input \( D(s) \rightarrow 0 \) instead. Again, finding the driving-point impedance \( Z_{dp} \) and calculating the conditions algebraically are exactly equivalent approaches.</p>
<p><b>Bottom line.</b>The entire goal of circuit analysis is figuring out what form the transfer function takes. When you derive the transfer function for a circuit, your job is done. Zeros are frequencies where \( H(s) \rightarrow 0\), and poles are frequencies where \( H(s) \rightarrow \infty\). Make sure to memorize the six transfer functions (voltage gain, current gain, etc.); you'll need them for every circuit analysis problem.</p>

<?php
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
