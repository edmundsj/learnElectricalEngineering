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
<h1>Lesson 1.13: Figuring out what you need</h1>
<p> It's easiest to <i>learn</i> how to solve circuits through examples. I learned this way, and it worked out okay for me. But what if you get to a circuit that doesn't have a defined solution? You'll need some general principles to guide you in the search for that solution. That's not taught at the undergrad level, typically, but it minimizes the amount of work you have to do to analyze/understand a circuit.</p>

<p>1. All you really need to care about is the output.</p>

<p>For "normal" input functions like sine waves, square waves, exponential functions, and constants, this is fine. It even works for elliptic functions, most of the time. It doesn't always work for noise circuits or completely random functions, though, so be careful.</p>

<p>So what does this principle mean? It means the input function doesn't matter when you're trying to figure out what a circuit does. You can always plug the input function back into your final answer if you need to. To do this, you just assume that you know what the input function is (e.g., you know it's \( V_{in}(s) \)) and solve for the output in terms of that input function. In most cases, it's easiest to work backwards from the output to the input. Then you avoid useless equations. (Useless equations are true equations about the circuit, but they don't help you find the answer you're looking for.) This leads nicely into the second principle, which is thanks to Dr. R.D. Middlebrook from Caltech: </p>

<p>2. "Don't put more in the model than you have to in order to get the answer you're looking for."</p>

<p>In other words, don't make life harder for yourself. The first question you should ask whenever you model something or write down equations for a circuit is, "Does this answer the question I want it to answer?". If it does answer that question, you're done. Don't make it more complicated than it has to be. If your model doesn't answer the question, then add a puny complication to your model. You'll have to use your own judgement to define how much "puny" is.</p>

<p>Why are we talking about this in the context of circuit analysis? Because we EEs have a bad habit of making things look and sound much, much harder than they actually are. In circuit analysis, this is mostly about how we present the traditional, step-by-step approach to circuit analysis:</p>

<ol>
  <li>Find the output. (Better get your eyes checked if you can't do this one)</li>
  <li>Use voltage dividers and current dividers wherever possible to get to output from input. (Not too hard.)</li>
  <li>Apply KCL or KVL as a last resort, if you can't get it using voltage and current dividers. (Pretty darn hard when you have ≥ 6 elements; the algebra gets ridiculous.)</li>
  <li>Say "the heck with it" and just run a circuit simulation with SPICE already.</li>
</ol>

<p>You can probably see why most people would choose #4. We engineers don't have time to monkey around with algebra when we have to get a product out <i>right now</i>. But SPICE isn't perfect. It won't tell you the answer to questions you don't know how to ask it. That's where our fast analytical techniques come in. Don't worry, there are easier ways than the traditional 4-step process! They're a little more advanced than the traditional techniques, but not by much. You don't have to do matrix algebra on paper if you really don't want to.</p>

<p><b>Bottom line.</b> Focus on the output of a circuit as a function of its input. Don't add more to any models/circuits/solutions than you need. I promise it's not as complicated and scary as it looks.</p>

<?php
 endWrapper();
 include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
 include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
 endPage();
 ?>
