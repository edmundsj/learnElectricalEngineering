<?php

 echo'<html>';
include $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/head.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/header_menu.php";
beginPage();
beginWrapper();
?>
<!-- Main -->
<div id="main">
  <div class="inner">
    <h1>Analog Circuits</h1>
    <span class="image main"><img src="images/pic13.jpg" alt="" /></span>
    <h1>Lesson 1.12: Phasors and Intro Power</h1>
    <p>Remember Thévenin's Theorem from the last lesson? We'll use that here to figure out how to get the maximum energy output from your circuit. Then we'll talk about phasors (vectors in the complex plane) and concepts related to both phasors and power. Most of power theory relies on phasors.</p>
    <h2>Real Power</h2>
    <p>Power is the amount of energy put into something per unit time. In a resistor, energy would be lost as heat. That's called power dissipation. In circuits, to get units of energy per unit time, the power equation must be
      \[ P = V I, \]
      where \( P \) is the power, and \( V \) and \( I \) are still voltage and current, respectively. This is valid pretty much only for dc circuits, and ac circuits that happen to have no phase shifting. This is a problem, because most power systems run on three-phase power.</p>
    <h2>Phasors and Complex Power</h2>
    <p>A phasor is another name for a complex number. We use them because they make time-domain calculations easier. However, when you're talking about power, you can't have any stray \( j \)'s floating around. Otherwise, you don't know how much power you're dissipating, and how much you think we're dissipating because we're using complex numbers. So you take the real part of these complex numbers to get the real sinusoid you want. In other words, if you have a voltage function in the complex plane \( V = V_{\text{max}} e^{j \theta}, \) you take the real part of it to go back to the time domain, that is, \( V(t) = \text{Re}\{V_{\text{max}} e^{j \theta}\} = V_{\text{max}} \cos(\omega t + \theta) \).</p>
    <p>The most general formulation of power, at least in the field of power engineering, is
      \[ S = V I^*, \]
      where \( S \) is called the apparent power, and \( V \) and \( I \) retain their usual definitions.</p>            
    <p>You might be wondering where the little star (*) came from. It represents the complex conjugate. We use that to ensure that we keep our definitions consistent across real and complex power values. The complex conjugate of a number has the same magnitude, but its phase angle is opposite in sign. </p>
    <img src="images/part1/conjugate.png" alt="(The complex conjugate of Z angle phi is Z angle minus phi.)">
    <p>We use the complex conjugate to keep our definitions consistent. If we define the phase angle of voltage to always lead current, we need to use the complex conjugate. In other words, we define the phase difference \( \theta \) between voltage and current as \( \theta = \phi_v - \phi_i \), where \( \phi_v \) is the phase angle of the voltage and \( \phi_i \) is the phase angle of the current. If you don't use the complex conjugate for calculating power, you get an incorrect phase. Suppose you know the phase angle of the current, \( \phi_i, \) and you want to calculate that current's power dissipation through an impedance \( Z \). The voltage across that impedance is \( Z I e^{j \phi_i} \), so the power dissipated in it is \( Z I^2 e^{j \phi_i} e^{j \phi_i} = Z I^2 e^{j 2 \phi_i} \). A current can't randomly add phase to itself theoretically, and it doesn't happen that way in real life either. So we use the complex conjugate. In fact, if you do use the complex conjugate, the power dissipated in that impedance would be \( Z I^2 e^{j \phi_i} e^{- j \phi_i} = Z I^2. \) That matches up with what you would expect from physics. (<a href="https://www.quora.com/Why-do-we-take-a-conjugate-of-current-when-we-write-the-formula-of-complex-power-S-VI*?share=1">Source for complex conjugate explanation</a>.)</p>
    <p>So why use complex power? We use it to make sure we don't introduce unnecessary phase into power systems, because it's expensive to compensate for those phase differences.</p>
    <h2>The power triangle and power factor</h2>
    <p>The power triangle is useful for figuring out where phase differences are coming from. Do they act inductively (causing current to be slower than voltage, or lag voltage) or capacitively (causing current to be faster than voltage, or lead voltage)? What is the power factor? It's probably best to explain this through an image. The short answer to all these questions is: if you want good power transfer, force \( \theta = 0 \) by any means necessary. The rest is in the picture. </p>
    <img src="images/part1/power_triangle.png" alt="(The power triangle and power factor relationships.)">
    <h2>The maximum power transfer theorem</h2>
    <p>If you're going to power something with a circuit, you had better make sure you can supply the maximum amount of power to it that you can. This is where the concept of impedance matching shows up. Why do we call it "impedance matching"? It's because you have to <i>match</i> your load impedance to the Thévenin equivalent impedance of your circuit if you want maximum power transfer. Why is this? The derivation is below.</p>
    <img src="images/part1/max_power_transfer_part_1.png" alt="(Derivation of the maximum power transfer theorem, part 1.)">
    <img src="images/part1/max_power_transfer_part_2.png" alt="(Derivation of the maximum power transfer theorem, part 2.)">
    <p><b>Bottom line.</b> Know the power triangle relationships, why we use the complex conjugate, and the statement of the maximum power transfer theorem (\( Z_L = {Z_{Th}}^* \)).
  </div>
</div>

<!-- Footer -->
<?php
 endWrapper();
 include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
 include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
 endPage();
 ?>
