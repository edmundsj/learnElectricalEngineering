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
              <li><a href="power.php">Phasors and introductory power concepts</a></li>
            </ol>
            <p></p>
            <h2>Part 2: How to actually use this stuff</h2>
            <p></p>
            <ol>
              <li><span style=" color: #0000ee;">Figuring out what you need,
                  ...and what you don't<br>
              </span></li>
              <li><span style="   color: #0000ee;">Solving circuits to get a
                  number</span></li>
              <li><span style="    color: #0000ee;">Solving circuits in terms of
                  variables</span></li>
            </ol>
            <h2>Part 3: Dirty Circuit Analysis Tricks (the meat)</h2>
            <ol>
              <li><span style=" color: #0000ee;">Simplifying nodal analysis
                  equations by inspection<br>
              </span></li>
              <li><span style="   color: #0000ee;">Superposition with dependent
                  sources (yes, it's legal!)</span></li>
              <li><span style="    color: #0000ee;">The Extra Element Theorem: how
                  to make circuit analysis trivial</span></li>
              <li><span style="     color: #0000ee;">Input and output impedances
                  from voltage gain using the Input-Output Impedance Theorem</span></li>
            </ol>
            <h2>Part 4: Using silicon without getting stuck in the details</h2>
            <ol>
              <li><span style="     color: #0000ee;">Diodes: forcing current from
                  positive (+) to negative (-) voltages</span></li>
              <li>BJTs: current amplifiers</li>
              <li>MOSFETs: cheap current sources</li>
              <li>Zener diodes: voltage regulators and "reverse diodes"</li>
              <li>Op-amps: the ultimate voltage amplifiers</li>
            </ol>
            <h1>Guided Circuit Analysis</h1>
            <h2>Part 5: Examples & Problems</h2>
            <ol>
              <li><span style="       color: #0000ee;">Part 1 & Part 2 practice problems</span></li>
              <li><span style="       color: #0000ee;">Part 3 practice problems</span></li>
              <li><span style="     color: #0000ee;">Part 4 practice problems</span></li>
              <li><span style="      color: #0000ee;">Analyzing some real circuits (synthesizers, etc.)</span></li>
            </ol>
            <h2>Part 6: Digressions</h2>
            <ol>
              <li><span style="       color: #0000ee;">Analyzing a video amplifier
                  circuit</span></li>
              <li><span style="        color: #0000ee;">Is electron flow or
                  conventional current better? (Neither.)<br>
              </span></li>
              <li><span style="     color: #0000ee;">Solving diode circuits in
                  terms of the Lambert W function</span></li>
              <li>Solving transistor circuits
                in terms of the Lambert W function</span></li>
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
