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
<h1>Lesson 2.1: Superposition with Dependent Sources</h1>
       <p>>A lot of textbooks say you can't do this. You can, though, as long as you don't calculate any values before summing all the individual solutions.
You <i>can't</i> typically get a Thévenin or Norton equivalent directly with this technique. You'll have to solve the circuit first, then figure out what the Thévenin/Norton equivalents are.</p>
<p>This is Problem 5.76 from Basic Engineering Circuit Analysis, 11th edition, by Irwin and Nelms.
(If you just want the worked solution on paper without reading through this, <a href="./scans/GD_Irwin_Nelms_11th_5_76.pdf">here you go</a>.)</p>

<p>Here's an executive summary of what we're going to do.</p>
<ol>
<li> Find the individual contribution of each source to the output. So turn off all other sources except the one you're interested in. ("Turning off" means shorting voltage sources and opening current sources.) </li>
<li> Sum up the individual contributions of each source to form the full output. </li>
</ol>

<p><b>Warning:</b> <i>Do not</i> try to calculate any numbers with the solutions for each individual source. You'll get the wrong answer. At least, you'll definitely get the wrong answer for the dependent source's equation alone. But wait, why is this? It's because you don't know how the dependent source will affect the circuit until you can solve for it. And you can't solve for it until you have all the necessary equations ready to go.</p>

Let's assign symbols to all the circuit elements first, so we don't have to worry about which numbers are which.
<img src="./images/part2/Irwin_Nelms_11th_Prob_5_76.png" alt="Circuit describing the problem." length=300 width=500>
<figcaption>(Assigning symbols to all elements.)</figcaption><br>

<p>Next, we need to find the individual contribution of each source. I'll start with \( V_I \) alone.
I'll refer to the <i>positive side</i> of the voltage \( V_x \) as \( V_{xp} \). This will be used later to calculate \( V_o \).
We can ignore \( R_2 \) for now, since it doesn't really contribute to \( V_{xp} \). 
Writing the equations by inspection at the \( V_{xp} \) node.</p>
<img src="./images/part2/V_I_alone_dependent_superposition.png" alt="Assessing \( V_I \)'s contribution." length=300 width=500>
<figcaption>(Assessing \( V_I \)'s contribution.)</figcaption><br>

<p>\[ \frac{V_{xp}}{R_1 \parallel R_3 \parallel \left( R_4 + R_5 \right)} = \frac{V_I}{R_1} \]
Solving for \( V_{xp} \).
\[ V_{xp} = \frac{V_I}{R_1} \left[ {R_1 \parallel R_3 \parallel \left( R_4 + R_5 \right)} \right] \]
The dependent source actually depends on the voltage <i>across</i> \( R_4 \), that is, \( V_x = V_{xp} - V_{xn} \). So we'll also need the solution for the negative side of \( V_x \), i.e., \( V_{xn} \). It's just a voltage divider of \( V_{xp} \) in this case.
\[ V_{xn} = V_{xp} \frac{R_5}{R_4 + R_5} \]</p>

<p>On to the contribution of the dependent source \( b V_x \).
It's actually pretty similar to the contribution of \( V_I \). Now the "supplied" or "current in" side is negative, though.</p>

<img src="./images/part2/b_vx_alone_dependent_superposition.png" alt="Assessing bvx's contribution." length=300 width=500>
<figcaption>(Assessing \( b V_x \)'s contribution.)</figcaption><br>

<p>At node \( V_{xp} \), we can write
\[ \frac{V_{xp}}{R_1 \parallel R_3 \parallel \left( R_4 + R_5 \right)} = -\frac{b V_x}{R_3} \]
Solve for \( V_{xp} \) once again.
\[ V_{xp} = -\frac{b V_x}{R_3} \left[ {R_1 \parallel R_3 \parallel \left( R_4 + R_5 \right)} \right] \]
As before, \( V_{xn} \) is a voltage divider of \( V_{xp} \). The same one, in fact.
\[ V_{xn} = V_{xp} \frac{R_5}{R_4 + R_5} \]</p>

<p>Now we find the contribution of just the current source, \( I \). This one is a little more involved because the topology is different.
After removing the sources, the circuit can be rearranged to simplify things.</p>

<img src="./images/part2/i_alone_dependent_superposition.png" alt="Assessing the contribution of I." length=300 width=500>
<figcaption>(Assessing the contribution of \( I. \))</figcaption><br>

<p>Using node \( V_{xn} \) is more powerful this time.
\[ I = \frac{V_{xn}}{\left( R_1 \parallel R_3 \right) + R_4} + \frac{V_{xn}}{R_5} \]
\[ I = \frac{V_{xn}}{\left[ \left( R_1 \parallel R_3 \right) + R_4 \right] \parallel R_5} \]
Solve for \( V_{xn} \).
\[ V_{xn} = I \left[ \left( R_1 \parallel R_3 \right) + R_4 \right] \parallel R_5  \]
\( V_{xp} \) is a divided voltage of \( V_{xn} \).
\[ V_{xp} = V_{xn} \frac{ \left( R_1 \parallel R_3 \right) }{ \left( R_1 \parallel R_3 \right) + R_4 } \]</p>

<p>Using the fact that \( V_x = V_{xp} - V_{xn} \), the solutions for \( V_{xp} \) fall out.</p>

<p>\( V_1 \) alone \( \rightarrow V_{xp,1}. \)
\[ V_{xp} = \frac{V_I}{R_1} \left[ {R_1 \parallel R_3 \parallel \left( R_4 + R_5 \right)} \right] \left( 1 - \frac{ R_5 }{ R_4 + R_5 } \right) \]
\( b V_x \) alone \( \rightarrow V_{xp,2}. \)
\[ V_{xp,2} = -\frac{b V_x}{R_3} \left[ {R_1 \parallel R_3 \parallel \left( R_4 + R_5 \right)} \right] \left( 1 - \frac{ R_5 }{ R_4 + R_5 } \right) \]
\( I \) alone \( \rightarrow V_{xp,3}. \)
\[ V_{xp,3} = I \left( \left[ \left( R_1 \parallel R_3 \right) + R_4 \right] \parallel R_5 \right) \left( \frac{ \left( R_1 \parallel R_3 \right) }{ \left( R_1 \parallel R_3 \right) + R_4 } - 1 \right) \]</p>

<p>Apply superposition. Solve for \( V_{xp} \).
\[V_{xp} = V_{xp,1} + V_{xp,2} + V_{xp,3} \]
\( V_{xp,2} \) is the only term besides \( V_{xp} \) on the left side that includes a \( V_{xp} \) variable.
\[V_{xp} - V_{xp,2} = V_{xp,1} + V_{xp,3} \]
Expanding the left-hand side. Factoring \( V_{xp} \) out.
  \[V_{xp} \left( 1 + \frac{b}{R_3} \left[ {R_1 \parallel R_3 \parallel \left( R_4 + R_5 \right)} \right] \left( 1 - \frac{ R_5 }{ R_4 + R_5 } \right)  \right) = V_{xp,1} + V_{xp,3} \]</p>

<p>This equation will get really messy if we write out the whole thing. I'll define two new resistance terms to clean it up.
\[ R_a = R_1 \parallel R_3 \parallel \left( R_4 + R_5 \right)  \]
\[ R_b =  \left[ \left( R_1 \parallel R_3 \right) + R_4 \right] \parallel R_5 \]
Here's the final solution for \( V_{xp} \).
\[ V_{xp} = \frac{\frac{ V_I }{ R_1 } R_a \left( 1 - \frac{ R_5 }{ R_4 + R_5 } \right) + I R_b \left[ \frac{ \left( R_1 \parallel R_3 \right) }{ \left( R_1 \parallel R_3 \right) + R_4 } - 1 \right]}{ 1 + \frac{b}{R_3} \left[ {R_1 \parallel R_3 \parallel \left( R_4 + R_5 \right)} \right] \left( 1 - \frac{ R_5 }{ R_4 + R_5 } \right)} \]</p>

<p>We have to return to the original circuit to find the solution for \( V_o \).</p>
<img src="./images/part2/full_circuit_dependent_superposition.png" alt="Finding Vo using the solution we just got for Vxp. \)" length=300 width=500>
<figcaption>Finding \( V_o \) using the solution we just got for \( V_{xp} \).</figcaption><br>

<p>Writing a KCL equation at node \( V_o \).
\[ \frac{ V_{xp} - V_o }{ R_4 } + I = \frac{ V_o }{ R_5 } \]
\[ V_o = \left(\frac{ V_{xp} }{ R_4 } + I \right) \left(R_4 \parallel R_5 \right) \]</p>

<p>Let's start plugging in numerical values.
\[ R_a = 2 \text{k} \parallel 1 \text{k} \parallel \left( 1 \text{k} + 1 \text{k} \right) = 500.00 ~Ω  \]
\[ R_b =  \left[ \left( 2 \text{k} \parallel 1 \text{k} \right) + 1 \text{k} \right] \parallel 1 \text{k} = 625.00 ~Ω \]
\[ V_{xp} = \frac{\frac{ 12 }{ 2 \text{k} } (500) \left( 1 - \frac{ 1 \text{k} }{ 1 \text{k} + 1 \text{k} } \right) + (2 ~\text{mA}) (625) \left[ \frac{ \left( 2 \text{k} \parallel 1 \text{k} \right) }{ \left( 2 \text{k} \parallel 1 \text{k} \right) + 1 \text{k} } - 1 \right]}{ 1 + \frac{2}{1 \text{k}} (500) \left( 1 - \frac{ 1 \text{k} }{ 1 \text{k} + 1 \text{k} } \right)} = 3.00753 ~\text{V} = 3.00 ~\text{V} \]
Plug that into the expression for \( V_o \).
\[ V_o = \left( \frac{ 3.00753 ~\text{V} }{ 1 \text{k} } + 2 ~\text{mA} \right) \left( \frac{ 1 \text{k} }{ 1 \text{k} + 1 \text{k} } \right) = 2.5038 ~\text{V} = 2.50 ~\text{V} \]
These values are dangerously close to what you'd get simulating this circuit with LTSpice.</p>

<img src="./images/part2/Irwin_Nelms_10th_5_76_LTSpice.png" alt="Checking the numbers with LTSpice." length=600 width=900>
<figcaption>Checking the numbers with LTSpice.</figcaption><br>

<p>As you can see, the solution we got from this method was <i>huge</i>. That's okay, though; the final expression is modular. So if you messed up some portion of the solution, you only need to fix that portion, and no other.</p>
<p>You can read more about this technique in <a href="http://leachlegacy.ece.gatech.edu/papers/superpos.pdf">William Leach's unpublished paper on this technique.</a>. It has lots of examples, too. About half are op-amp circuits and half are passive networks.
You can also take a look at <a href="https://electronics.stackexchange.com/questions/107435/superposition-principle-dependent-sources-treated-as-independent-sources">the StackExchange post where I originally found that paper.</a></p> 

<?php
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
