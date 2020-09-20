
<?php

echo'<html>';
include $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/head.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/header_menu.php";
beginPage();
beginWrapper();
?>

<!-- Main content goes here -->
 <h1>Theory</h1>
            <h2>Part 1:What the heck even <em>is</em> a resistor?</h2>
            <ol>
              <li><a href="current_flow.php">Current
                  flow and charge flow: what's the difference? <em>Is </em>there
                  a difference? (Yep!)</a></li>
              <li><a href="resistance.php">Resistance,
                  Resistors, and Ohm's Law</a></li>
              <li><a href="capacitors.php">Capacitors</a></li>
              <li><a href="inductors.php">Inductors</a></li>
              <li><a href="ohms_revisited.php">Ohm's
                  Law revisited: Impedances, the most powerful passive-component
                  calculators ever</a></li>
              <li><a href="sources.php">Ideal voltage and current
                  sources</a></li>
              <li><a href="kvl_kcl.php">KVL and KCL</a></li>
              <li><a href="series_parallel.php">Series and parallel
                  impedances</a></li>
              <li><a href="dividers.php">Voltage dividers and current
                  dividers</a></li>
              <li><a href="superposition.php">Superposition: adding up the
                  contributions from multiple sources<br>
              </li>
              <li><a href="thevenin.php">Thévenin/Norton equivalent
                  circuits and source transformation: pretending everything is a voltage or current divider</a></li>
<li><a href="what_you_need.php">Figuring out what you need,
                  ...and what you don't</a></li>
              <li><a href="power.php">Phasors and introductory power concepts</a></li>
            </ol>
            <h2>Part 2: Dirty Circuit Analysis Tricks (the meat)</h2>
            <ol>
              <li><a href="superposition_dependent.php">Superposition with dependent
                  sources (yes, it's legal!)</a></li>
<li><a href="extra_element.php">The Extra Element Theorem: how to make circuit
    analysis trivial</a></li>
<li><a href="poles_zeroes_transfer.php">Poles, zeroes, and the six standard transfer functions</a></li>
              <li>Input and output impedances
                  from voltage gain using the Input-Output Impedance Theorem</li>
              <li>Return ratio and Blackman's Theorem</li>
            </ol>
            <h2>Part 3: Using silicon without getting stuck in the details</h2>
            <ol>
              <li>Diodes: forcing current from
                  positive (+) to negative (-) voltages</li>
              <li>BJTs: current amplifiers</li>
              <li>MOSFETs: cheap current sources and lightning-fast switches</li>
              <li>Zener diodes: voltage regulators and "reverse diodes"</li>
              <li>Op-amps: the ultimate voltage amplifiers</li>
            </ol>
            <h1>Guided Circuit Analysis</h1>
            <h2>Part 4: Examples & Problems</h2>
            <ol>
              <li>Part 1 & Part 2 practice problems</li>
              <li>Part 3 practice problems</li>
              <li>Part 4 practice problems</li>
              <li>Analyzing some real circuits (synthesizers, etc.)</span></li>
            </ol>
            <h2>Part 6: Digressions</h2>
            <ol>
              <li>Analyzing a video amplifier
                  circuit</span></li>
              <li>Is electron flow or
                  conventional current better? (Neither.)<br>
              </li>
              <li>Solving diode and transistor circuits in
                  terms of the Lambert W function</li>
</ol>
<p></p>
</div>
</div>

<?php
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
