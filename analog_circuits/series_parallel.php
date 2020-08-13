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
          <h1>Series and Parallel Impedances</h1>
			 <p>These are shortcuts for applying KVL and KCL that really simplify circuit problems.</p>
          <p>We're allowed to derive the rules for resistors alone. Recall that this generalizes to any
            arbitrary impedance if you replace R with Z (we discussed this in
            <a href="ohms_revisited.html">Lesson 5</a>).</p>
          <p>We'll use induction to derive the rules for an arbitrary number of resistors using KVL and KCL.</p>
            <h2>Series Impedances</h2>
          <p>We'll use KVL and Ohm's Law to find the input resistance of this resistive circuit. Ultimately, we want to solve for R in Ohm's Law, but we have to specialize it to the circuit we're interested in.</p>
          <img src="images/part1/series_impedances.png" alt="(Derivation of series impedance formula.)">
          <p>We call impedances with the same <i>current through</i> them <i>series</i> impedances. The input resistance formula for series impedances is 
              \[R_{in} = R_1 + R_2 + ... + R_N. \]</p>
          <h2>Parallel Impedances</h2>
          <p>Same idea as with series impedances, but we'll use KCL instead of KVL.</p>
          <img src="images/part1/parallel_impedances.png" alt="(Derivation of parallel impedance formula.)">
          <p>We call impedances with the same <i>voltage across</i> them <i>parallel</i> impedances. We also introduced a new mathematical operator: the parallel operator. It's just a convenient way of writing down two-story fractions like we see for \( R_{in} \). There is no physical meaning attached to the parallel operator. It's defined this way, for just two variables:</p>
          <p> \[ a \parallel b = \frac{1}{\frac{1}{a} + \frac{1}{b}} = \frac{a b}{a + b}. \]</p>
          The input resistance formula for series impedances is 
              \[R_{in} = R_1 \parallel R_2 \parallel ... \parallel R_N. \]</p>
          <p><b>Bottom line.</b> Impedances in series have the same <i>current through</i> them. Impedances in
            parallel have the same <i>voltage across</i> them. Know the expressions for series and parallel impedances. Know how the parallel operator is defined.</p>
		  </div>
		</div>
		<!-- Footer -->
<?php
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
