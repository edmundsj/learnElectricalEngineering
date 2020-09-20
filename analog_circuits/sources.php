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
          <h1>Lesson 1.6: Ideal voltage and current sources</h1>
			 <p>An ideal voltage source sets a constant voltage \( V = A \), where \( A \) is a constant. You have
            no idea what the current through this source is, unless you connect it to some external circuit.</p>
          <img src="images/part1/voltage_source.png" alt="(The schematic symbol for an ideal voltage source, with defining equation V = A, where A is some constant. The current through the voltage source cannot be found through this relationship.)">
          <p>An ideal current source sets a constant current \( I = B \), where \( B \) is a constant. You can't
            determine the voltage across an ideal current source from just the current source itself. You need
            to connect it to an external circuit, like with the voltage source.</p>
                    <img src="images/part1/current_source.png" alt="(The schematic symbol for an ideal current source, with defining equation I = B, where B is some constant. The voltage through the current source cannot be found through this relationship.)">
          <p>Here's a simpler way to think of it. If you look at the defining equations for each source, do you
            see any V in the current source equation, or any I in the voltage source equation? If there isn't
            one, how do you find that relationship? (Hint: you can't.) That means that the current through a
            voltage source is legally allowed to be any value you want. So, if you hook up your voltage source
            to another circuit, that other circuit sets the current value. The same idea applies for the voltage
            across a current source.</p>
          <p>picture of voltage-current graphs for ideal sources (circuitikz probably)</p>
          <p><strong>Bottom line.</strong> Ideal sources are defined by equations of the form \( V = A \) (for a voltage source) or \( I = B \) (for a current source), where \( A \) and \( B \) are both constants. Don't assume you can treat sources like any other circuit element. You can't find the voltage across a current source or the current through a voltage source without connecting the source to some external circuit.
		  </div>
		</div>

		<!-- Footer -->

<?php
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
