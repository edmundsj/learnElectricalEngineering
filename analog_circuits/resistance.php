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
          <span class="image main"><img src="images/pic13.jpg" alt=""></span>
          <h1>Lesson 2: Resistors, Resistance, and Ohm's Law</h1>
          <p>There are two fundamental variables in circuit theory. They're all you care about when analyzing or
            designing a circuit. They are
          <ol>
            <li> voltage, and </li>
            <li> current. </li>
          </ol>
          </p>
        <p>"So,"&nbsp; you might ask, "why does this matter if
          we're supposed to be learning Ohm's Law?" Well, Ohm's Law is the relationship between voltage
          and current through a resistor:</p>
        <p> \[ V = R I. \]</p>
        <p>\( V \)is the voltage across the resistor,
          \( R \) is the resistor's value, and
          \( I \) is the current through the resistor.</p>
        <p>A resistor taken out of a circuit looks like this.</p>
        <img src="images/part1/ohms_resistor.png"
             alt="(The schematic symbol for a resistor, disconnected from a circuit. It has two circles on each 
                  end, and a label: R. An arrow extends from the word 'resistor' to the resistor's schematic 
                  symbol.)"><br><br>
        <p>In a real circuit, you'll see something closer to
          these two resistors, shown here in a voltage divider circuit.</p>
        <img src="images/part1/ohms_divider.png"
             alt="(A circuit made up of a voltage source and two resistors. Both resistors are labeled R1 and R2. 
                  The voltage source is left unlabeled. A double arrow extends from the word 'resistors' to each 
                  of the two resistors.)"><br><br>
        <p>The equation \( V = R I \) is true if the circuit is <em>linear</em>.
          A "linear" circuit means the relationship between voltage and current
          never has a power greater than 1. That means if you have something
          like \( V^2 \) showing up while solving a linear circuit, you probably made an algebra error
          somewhere.</p>
        <p>We say Ohm's Law is linear because we're assuming
          that the resistance \( R = \text{constant} \). If
          it's not constant, you'll get some random mathematical function
          relating the voltage and current. That's what we call a <em>nonlinear</em>
          resistor, and we'll get to it in one of the digressions at the
          end of the course.</p>
          <p> You don't run into nonlinear resistors unless you're working on something highly
            specialized, usually in PhD-level research.
          </p>
          <p>We measure voltage in volts (V) and current in amperes (A). Resistance is in Ohms (\( \Omega \)). It's a measure of how much current is "resisted" by
            the resistor. Think of a water pipe. The size of the pipe determines how much water can flow through
            it. The smaller the size, the more resistance the pipe has to water flowing through it.</p>
<p> <strong>Bottom line.</strong> Ohm's Law is \( V = R I \). Physicists found it experimentally; you can
  trust us when we say it's correct for <em>linear</em> circuits.
  Current flows from the <em>positive</em> terminal to the <em>negative</em>
  terminal of any element.</p>
<p>(If the current flows in the opposite direction, the
  voltage across that element flips sign. This ensures we still have
  current flow from the <em>positive</em> to the <em>negative</em>
  terminal.)</p>
</div>
<!-- Footer -->
<?php
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
