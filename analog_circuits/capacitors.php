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
          <h1>Lesson 1.3: Capacitors (Caps)</h1>
          <img src="images/part1/capacitor.png"
               alt="(The schematic symbol for a capacitor, disconnected from a circuit. A common application for capacitors is in RC low-pass filters. The capacitor and resistor together set a cutoff frequency for that filter. If the input voltage frequency is greater than this cutoff, there is no voltage output. If the input voltage frequency is lower than the cutoff, the input voltage signal passes to the output.) ">
          <h2>deriving the current-voltage relationship</h2>
          <p></p>
          <p>Here's another one of those experimental laws from physics you just
            have to accept. You can prove it for yourself if you like, but
            you'll probably end up with the same conclusion. The law for
            capacitors is</p>
          <br>
        </div>
        <div class="inner">
          \( q = C V \)
        </div>
        <div class="inner"><br>
          The variables are \( q \) for the charge on the plates of the capacitor, \( C \) for
          the capacitance, and \( V \) for the voltage across the capacitor.</div> <br>
        <div class="inner">We're circuit designers, so who cares about charge?
          That's an electromagnetic/photonic engineer's problem. We're more
          interested in what the current through the capacitor looks like.
          That's because the <em>average</em> charge flow rate (the current) is
          what matters, not exactly what that charge is. This becomes more
          important when you have to deal with AC circuits. The amount of charge
          moving through the circuit varies at different times, but the overall
          current remains constant.</div>
        <div class="inner"><br>
        </div>
        <div class="inner">If you take the time derivative of both sides, you
          get</div>
        <div class="inner"><br>
          \( \frac{dq}{dt} = C \frac{dV}{dt} \).
        </div>
        <div class="inner"><br>
        </div>
        <div class="inner">(We assumed the capacitance \( C \) was a constant here.
          You can get away with this in circuits that have only constant-valued
          capacitors in them. No variable capacitors allowed!) </div>
        <div class="inner">Current is defined as the charge flow rate, \(I = \frac{dq}{dt} \), so we end up
          with</div>
        <div class="inner"><br>
          \( I = C \frac{dV}{dt} \)
        </div>
        <div class="inner"><br>
          We'll only use this formula in passing, because we're usually interested in how the circuit behaves at different frequencies. We can use complex numbers to avoid taking tons of time derivatives, so we'll derive a purely <em>algebraic</em> formula at the end of Part 1.</div>
        <div class="inner"><br>
        </div>
        <div class="inner">You can use separation of variables (a differential
          equation solution technique) to solve for
          \( V \) here:</div>
        <div class="inner"><br>
          \( V = \frac{1}{C} \int_{0}^{\infty} I(t) dt + V(0) \)</div>
        <div class="inner"><br>
        </div>
        <div class="inner">where
          \( V(0) \) is whatever initial condition you have for the
          voltage. Again, you can use complex numbers here to save yourself a
          lot of work. This solution is only valid for times <em>after</em> &nbsp;\( t = 0 \). That's why the integration limits look that
          way.</div>
        <div class="inner">When you build things like integrators (in the op-amp
          section of the course), it's good to remember that you <em>are</em>
          actually taking an integral. It's more of an intuitive aid than a math
          aid (although it<em> is</em> mathematically correct). Like with the differential equation above, we  can use some fancy algebra to avoid actually taking the integral.</div>
        <div class="inner">
          <h2><br>
          </h2>
          <h2>Only one calculation for this formula!</h2>
        </div>
        <div class="inner">You most likely won't be asked to take the time
          derivative of some voltage function. That is, unless your professor
          wants to make sure you can still do time derivatives.</div>
        <div class="inner">You might be asked to do a finite-difference
          approximation to find the current. That means you'll get two
          measurements for the voltage at two specific times. Then you subtract
          one from the other, <em>as if</em> you took a derivative. The formula
          for this is</div>
        <div class="inner"><br>
        </div>
        <div class="inner">
          \( I = C \frac{\Delta V}{\Delta t} = C \frac{V_2 - V_1}{t_2 - t_1} \). <br>
        </div>
        <div class="inner"><br>
        </div>
        <div class="inner"><strong>Bottom line.</strong> The capacitor current-voltage equations in the time domain are \( I = C \frac{dV}{dt} \) and \( V = \frac{1}{C} \int_{0}^{\infty} I(t) dt + V(0) \).
        </div>
      </div>
<?php
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
