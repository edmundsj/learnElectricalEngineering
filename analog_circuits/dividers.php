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
                     <h1>Lesson 7: Voltage dividers and current dividers</h1>
							<p>These build on the ideas of series and parallel to get some general expressions you can
                       use in <i>a lot</i> of circuits. Many circuits are just sequences of divider circuits
                       strung together.</p>
                     <h2>Voltage divider derivation</h2>
                     <p>Like in the last lesson, it's easier to just show the circuit and the equations than it is to explain it all. We're still just applying KVL, KCL, and Ohm's Law.</p>
                     <p>In this case, we want to find the output voltage as a function of the input voltage. We can use the result to write answers for sub-circuits down without having to go through the derivation again.</p>
                     <img src="images/part1/voltage_divider.png" alt="(Derivation of the voltage divider expression.)">
                     <p>The output voltage of a voltage divider circuit is \[ V_o = V_{in} \frac{R_2}{R_1 + R_2} = \frac{1}{1 + \frac{R_1}{R_2}}. \]</p>
                     <h2>Current divider derivation</h2>
                     <p>Same line of reasoning as for the voltage divider.</p>
                     <img src="images/part1/current_divider.png" alt="(Derivation of the current divider expression.)">
                     <p>The output voltage of a current divider circuit is \[ I_o = I_{in} \frac{R_1}{R_1 + R_2} = \frac{1}{1 + \frac{R_2}{R_1}}. \]</p>
                     <p><b>Bottom line.</b> Know the final results for the voltage and current divider circuits.</p>
						</div>
					</div>

				<!-- Footer -->
<?php
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
