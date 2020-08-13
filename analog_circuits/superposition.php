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
          <h1>Lesson 10: Superposition</h1>
			 <p>If you remember from all our previous lessons so far, there wasn't a single variable with an exponent greater than 1. That's because the circuit's we've been working with are all <i>linear</i>. Because they're linear, we can use a cheat code to solve them: superposition. Superposition says that if you have multiple inputs and just one output, you can consider what the output would look like with each input separately, then add up all the results. Mathematically, if you have inputs \( x_1 \) and \( x_2 \), and your output function is some function \( f, \) superposition says that
            \[ f(x_1 + x_2) = f(x_1) + f(x_2). \]</p>
          <p>And that's all there is to it. It's easier to understand how this idea applies to circuit analysis through an example. In all cases, we say the sources (voltage or current) are the inputs.</p>
          <img src="images/part1/superposition_example_part_1.png" alt="(Analyzing an example circuit using superposition.)">
          <img src="images/part1/superposition_example_part_2.png">
          <p><b>Bottom line.</b> For linear systems and equations, superposition says that \( f(x_1 + x_2 + ... + x_n) = f(x_1) + f(x_2) + ... + f(x_n). \) Turning off a voltage source means replacing it with a <b>short</b>  circuit so that its voltage \( V = 0 \). Turning off a current source means replacing it with an <b>open</b> circuit so that its current \( I = 0 \).</p>
		  </div>
		</div>

		<!-- Footer -->
<?php
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
