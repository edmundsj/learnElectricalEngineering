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
          <h1>Lesson 1.1: Current flow and charge flow</h1>
          <p> I'll use this first lesson to let you know the most important
            convention for the whole course. The details matter, yes, but the
            human brain is not infinite. You're going to have to figure out
            where to cut out some information somewhere. That's why I've decided
            to put in a "bottom line" at the end of each page. The bottom line
            is what I want you to take away from each lesson. </p>
          <p>What do we mean when we say current "flows" in a circuit? Well, the
            terminology's not exactly correct. <i>Charges</i> are what really
            "flow" in a circuit. EEs just say "current flows" because (1) we're
            lazy, and (2) we're often more interested in current values (amps)
            than charge values (coulombs). But it's really charge that flows.
            That flow of charge is what we call current. If it helps for some
            reason, you can think of charge flow as <i>inducing</i> a current
            in circuit theory. </p>
          <p> We have two types of current: <br>
            <ol>
            <li> direct current (DC), and </li>
            <li> alternating current (AC). </li>
            </ol>
          </p>
          <p>Direct current is always a constant value at low frequencies. Alternating current is not a constant value. In fact, AC is typically a sinusoid of some kind. AC can also take any frequency value you want, from around \( 9 Hz \) all the way up to around \( 200 GHz \).</p>
          <p>Side note: sometimes we use dc instead of DC and ac instead of AC. The lowercase acronyms mean the exact same things as their uppercase counterparts.
          
          <p><strong>Bottom line. </strong><em>Charge</em> flows, not
            current. Direct current is low-frequency and has a constant value. Alternating current can take any frequency and has a variable value.</p>
        </div>
      </div>
      <!-- Footer -->
  <?php
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
