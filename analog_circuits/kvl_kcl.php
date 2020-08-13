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
          <h1>Lesson 7: KVL and KCL</h1>
          <h2>KVL - Kirchoff's Voltage Law</h2>
          <h3>Derivation</h3>
			 <p>You can derive this from electromagnetism, too. KVL follows directly from assuming </p>
           <p> \( \nabla \times \textbf{E} = -\frac{\partial B}{\partial t} = 0 \) </p>
          <p> from Faraday's Law.
            Then we can use the definition of voltage, </p>
          <p> \( V = \int \mathbf{E} \cdot d\mathbf{l} \), </p>
          <p> apply the condition from Faraday's Law, and take a sum over multiple elements in a closed loop.
            You end up with </p>
          <p> \( \sum_{k} V_k = 0 \). </p>
          <p> This says that the sum of the voltage drops around any closed loop must equal zero. </p>
          <p>Usually, you're looking for either a voltage or a current in a closed loop. If it's in a closed
            loop, you apply KVL. Full stop. The only time you wouldn't want to do this is if the loop is
            connected to some other loop through one of its elements.</p>
          <img src="images/part1/kvl.png" alt="(Picture of a typical KVL analysis. A loop with a voltage source V_in, and 3 resistors, R_1, R_2, and R_3. Applying KVL and Ohm's Law, we get an equation that can solve for the input current I_in. That current can be used to solve for an output voltage at any connection point in the circuit.)">
          <h3>Naming</h3>
          <p> We use "KVL", "loop analysis", and "mesh analysis" interchangeably. These terms all mean the same
            thing. They <i>might</i> not mean the same thing for 3D circuits, but who the heck builds 3D
            circuits?</p>
          
          <h2>KCL - Kirchoff's Current Law</h2>
          <p> I'll skip the derivation here, because the math is more complicated than in the derivation for
            KVL. Suffice it to say that a similar line of reasoning about nodes (connection points between
            circuit elements) results in </p>
          <p> \( \sum_{k} I_k = 0 \). </p>
          <img src="images/part1/kcl.png" alt="(A typical KCL analysis. A voltage source and 3 resistors are connected in parallel to one node, and, of course, the ground node. Applying KCL and Ohm's Law, we get an equation to solve for the input voltage V_in. That voltage can be used to solve for any output current through any resistor in the circuit.)">
          <h3>Naming</h3>
          <p>"Nodal analysis" and "modified nodal analysis" both refer to using KCL with Ohm's Law. They're all
            fundamentally KCL anyway, so it's safe to say we can use these three terms interchangeably.</p>

          <h2>When do you use one over the other?</h2>
          <p>This choice depends on experience and personal preference. As a starting point, you can count the
            number of nodes in the circuit, put that number off to the side, and count the number of loops in
            the circuit. Compare them. The smaller number tells you which method might be easier than the 
            other. If the loops have the smaller number, KVL might be a good choice. If the nodes have a smaller
            number, KCL might be a good choice. This is a contrived method, but it gives you a bit of insight
            into what we're looking for.</p>
          <p>In short: Fewer equations \( \rightarrow \) better, and more equations \( \rightarrow \) worse.</p>
          
          <p><b>Bottom line.</b> \( \sum_{k} V_k = 0 \) around a closed loop. \( \sum_{k} I_k = 0 \) into/out
            of any node. Use the one that gives you fewer equations.</p>

		  </div>
		</div>

		<!-- Footer -->
<?php
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
