<?php

 echo'<html>';
include $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/head.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/header_menu.php";
beginPage();
beginWrapper();
?>

<!-- Main content goes here -->
<h1>Analog Circuits</h1>
<span class="image main"><img src="/images/pic13.jpg" alt="" /></span>
<h1>Lesson 2.2: The Extra Element Theorem</h1>
<p>After doing a ton of work solving circuits, you've probably found something else out: getting a nice analytical solution is kind of hard! Normally, you would write some equations with KVL and KCL, then solve them algebraically. This becomes difficult to handle with \( > 6 \) reactive elements, just because the equations get really huge. The method we're about to talk about eliminates most of that unwieldy algebra.</p>
<p>The first question you should ask is: "Why bother getting analytical solutions, when I can just plug my circuit in the computer and get the answer I want?". Absolutely, go simulate it, if that helps you understand the circuit better. But you should know that the simulator is not a substitute for thinking. It can't tell you which elements contribute to your final answer. It does much of the numerical work for you, but it's up to you to specify the correct problem. Analytical solutions can help you check if your answer makes sense, which is especially useful when you're designing something that hasn't been made before.</p>
<p>For circuits, it's best to save simulation for doing worst-case analysis. If you use analytical solutions for the design work, you can save yourself a lot of debugging.</p>
<h2>Proof?</h2>
<p>I'm not going to do the proof here; it's not very enlightening. It basically boils down to a bunch of linear algebra. If you <i>really</i> want to see the proof, check out <a href="https://www.youtube.com/watch?v=yo4P3t_OtOc">Jordan's video on it</a>. Another good place to check is <a href="https://www.youtube.com/playlist?list=PL9iJ8nrxOYQ3FdRn2B_YQy-We8OYSagL6">Dr. Middlebrook's Technical Therapy for Analog Circuit Designers</a>, put together by the guy who came up with this theorem.</p>
<h2>Quit stalling. What's the theorem already?</h2>
<p>Let's assume that we want to figure out what the voltage gain of a circuit is. If you remember from the proof of the Thévenin equivalent circuit in <a href="thevenin.php">Lesson 1.11</a>, this looks like
  \[ V_o = A_v V_{in}, \]
  where \( V_o \) is the output voltage of the circuit, \( V_{in} \) is the input voltage, and \( A_v \) is the voltage gain. The voltage gain \( A_v \) is determined entirely by the circuit itself. That's what we want to calculate. In general, it's a function of frequency, so \( A_v = A_v (s). \) Given all this information, the Extra Element Theorem says we can calculate the gain in a modular way as
  \[ A_v(s) = A_0 \frac{1 + \frac{Z_{n}(s)}{Z(s)}}{1 + \frac{Z_{d}(s)}{Z(s)}}. \]
  Wait, so what do all these fancy new variables mean? Let's figure them out through an example.
  Say we have a reactive element that's really complicating our circuit analysis, like the capacitor \( C \) in the following circuit.
  <!--- image goes here --->
  Ideally, we want to remove \( C \), so we can write down our gain \( A_v = \frac{V_o}{V_{in}} \) by inspection. Good news is, we can! We have two choices for doing that. We can make \( C \) into either a short circuit or an open circuit.
</p>
<p>Now, if we make \( C \) an open circuit, we get a new circuit. In this new circuit, we can see immediately that \( V_o = V_{in} \). The other branch of the circuit is irrelevant, because it's not connected anymore. If we make \( C \) a short, we get a different circuit. It looks like we would have to write a set of two KVL equations for this one. That defeats the purpose of removing the capacitor, because it doesn't actually simplify the analysis. So making \( C \) an open is the easier way to go.</p>

<p>Ok, we've made \( C \) into an open circuit. Calculating the gain for this simplified circuit leaves us with
  \[ A_0 = \frac{V_{o}}{V_{in}} = 1. \]
  This is the gain of the circuit at zero frequency. In other words,
  \[ s = j \omega = j(0) = 0.\]
  This means that our simplified circuit is operating under dc conditions. Wait, but how did I know that we were operating at dc? Well, consider the definition of an open circuit. In an open circuit, \( Z = \infty \). So if we make the capacitor to be an open circuit, that means we set its impedance \( Z = \infty. \) Now how do you get that to happen? Find a frequency at which
  \[ Z = \frac{1}{sC} \rightarrow \infty. \]
  This happens if we let \( s \rightarrow 0 \) in the above equation. So now we know that the gain \( A_0 \) is the gain of the circuit at zero frequency. Next, we'll find \( Z_n \).</p>
<p>The impedance \( Z_n \) is called the null driving-point impedance. "Null" means that the circuit is adjusted such that
  \[ V_o = 0. \]
  "Driving-point" means that we connect a source across some two terminals in the circuit, and we measure some quantity across the same two terminals. For example, you apply a voltage source to the circuit and you measure the current through that voltage source. In our case "driving-point" means we calculate the impedance seen by the terminals of \( C \). Now, let's translate this understanding to math as
  \[ Z_n = Z_{port} |_{V_o = 0}. \]</p>
<p>
  <!--- image goes here --->
  Huh. That doesn't look much simpler than doing things the other way. It can be simpler, but there's a trick. The port label \( V_{in} \) is really just shorthand for a voltage source \( V_{in} \) at that node. Redrawing the circuit, we see that the voltage source \( V_{in} \) is in series with \( R_1. \)</p>
<p>We're free to rearrange elements in series without changing the way the circuit operates. The sides of the elements connected to the ground node are at the reference potential (0 volts). That means we can redraw the circuit like this, again without changing the circuit's operation. (I'll only do this once, because it's pretty messy.)</p>
<p>
  <!--- image goes here --->
  This means that we're allowed to slide resistors through ground symbols! (We'll use this technique often from here on. It's easier to calculate many driving-point impedances this way.)
</p>
<p>Next, we calculate \( Z_n \) by considering all the paths through which current could flow, if we connected a current source at port (1). In this case, there are two possible paths. The current could flow through either \( R_1 + R_2 \), or through \( R_3 + R_4 \). Therefore \( R_1 + R_2 \) and \( R_3 + R_4 \) are in parallel, and we can write
  \[ Z_n = \left( R_1 + R_2 \right) \parallel \left( R_3 + R_4 \right). \]
  We could also look at this as \( R_1 \parallel R_3 \) in series with \( R_2 \parallel R_4 \), leaving us with
  \[ Z_n = R_1 \parallel R_3 + R_2 \parallel R_4. \]
  The parallel operator is distributive. You can derive this second result for \( Z_n \) from the first one just using algebra, if you want.</p>
<p>Now we need to calculate \( Z_d. \) This is the driving-point impedance with the input off and the output on. In math,
  \[ Z_d = Z_{port} |_{V_{in} = 0}. \]
  Applying those conditions to the circuit, we get this schematic.
  <!--- image goes here --->
  We can slide the resistors through ground again, which gives us this situation.
  <!--- image goes here --->
  And we find out that
  \[ Z_d = \left( R_1 + R_2 \right) \parallel \left( R_3 + R_4 \right), \]
  strangely enough. In other words, this means that
  \[Z_d = Z_n \]
  for this specific circuit. (This equality <i>does not necessarily hold</i> for other circuits.) Anyway, plugging all the factors we found into the general Extra Element Theorem formula yields
  \begin{align}
  A_v & = A_0 \frac{1 + \frac{Z_{n}}{Z}}{1 + \frac{Z_{d}}{Z}} \\
  & = \left( 1 \right) \frac{1 + \frac{ \left( R_1 + R_2 \right) \parallel \left( R_3 + R_4 \right)}{ \frac{1}{s C}}}{1 + \frac{ \left( R_1 + R_2 \right) \parallel \left( R_3 + R_4 \right)}{ \frac{1}{s C}}} \\
  & = \left( 1 \right) \frac{1 + s C \left( R_1 + R_2 \right) \parallel \left( R_3 + R_4 \right)}{1 + s C \left( R_1 + R_2 \right) \parallel \left( R_3 + R_4 \right)} \\
  & = 1.
  \end{align}
  I realize this was pretty simple, and I could have simplified the whole thing to 1 immediately from \( Z_d = Z_n. \) But I wanted to show you the kinds of algebraic manipulations we would typically do, once we've applied the Extra Element Theorem.
</p>
<p>The next logical question is: can we use this for other transfer functions in our circuit? For sure! You can use it for any of the six standard transfer functions.</p>

<p><b>Bottom line.</b> You can use the general formula for the Extra Element Theorem to find any transfer function for any circuit, analytically. You can use these results to make design decisions, and find poles and zeroes, without having to run tons of simulations. </p>
<p>(NOTE: we're going over what transfer functions, poles, and zeroes are in the next section.)</p>


  
<?php
 endWrapper();
 include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
 include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
 endPage();
 ?>
