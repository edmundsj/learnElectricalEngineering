<?php

echo'<html>';
include $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/head.php";
beginPage();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/header_menu.php";
beginWrapper();
?>

<!-- Main content goes here -->
<h1>Teaching Philosophy</h1>
<span class="image main"><img src="/images/pic13.jpg" alt="" /></span>
<h1>Just-in-Time Teaching</h1>
<?php
addLessonNavigation("/signals_systems.php", "physicists_vs_engineers.php", "Previous Rant", "Next Rant");
?>
<h2>Just-in-What?</h2>
<p>
My teaching philosophy centers around what I like to call "just-in-time" teaching. This means that every concept, equation, or idea should be introduced just before it is needed - just in time. It also means that complexity should be minimized at all cost. If there is an equation or a thought that isn't needed for what I am trying to teach at that moment, it should be eliminated (that's not to say I won't go off on brief tangents ;)). 
</p>
<p>
A couple examples of this - <i>always</i> introduce concepts in 1 dimension before moving to 2 dimensions or 3 dimensions. Never use 3 dimensions when 1 dimension would work to illustrate the concept. If you can say something with a picture or words instead of an equation, then do that. Equations are complicated and difficult to parse, even for experienced engineers. Pictures can be grasped by everyone.
</p>
<p>
I also like to deliberately make "mistakes" in my lectures - not mistakes in the sense of writing an equation wrong, but "mistakes" as in not using the most elegant, clever, and well-known solution right off the bat. I find that this leads more to technique memorization than actual learning. I like to first try the most obvious technique (to the beginner at least), and then stumble around for a bit, finding everything wrong with it. Then, aha! But what if we tried this? That would fix all those problems we just faceplanted into. That is preciesly the moment when the elegant technique should be introduced.
</p>
<h2>Just-in-time Learning</h2>
<p>
This extends not just to teaching itself, but to what comes after teaching - worked examples. Once a concept is introduced, students should have an opportunity to get <i>immediate feedback</i> to solidify that knowledge and correct any errors in their thinking. Both my personal experience and the teaching literature [1, 2] screams that immediate feedback improves learning, and the effect sizes are not small (think 50% more likely to get an answer correct on tests, in a somewhat contrived experiment). For this reason, on this website and in my teaching, I intersperse examples students can try, and get immediate feedback on whether they are correct or not. In physics and engineering in particular, it is very possible to have the illusion of understanding something when you do not, and examples with immediate feedback are the best way to correct this. I find things are also just more fun this way.
</p>

<h2>Just-in-time (re)Learning</h2>
<p>
Learning isn't a one-time thing. The goal of engineering coursework is not to force students to learn something, and subsequently forget it. There's a huge body of evidence [3] that re-learning the same thing multiple times makes it "stick" in the mind. The basic idea is to try and recall something <i>just</i> when you are about to forget it. To the extent possible, I try to make my individual coursework comulative, and when I give homework assignments, those certainly will be too.
</p>

<h2>References</h2>
<p>
[1] Dihoff, Roberta E., Gary M. Brosvic, Michael L. Epstein, and Michael J. Cook. "Provision of feedback during preparation for academic testing: Learning is enhanced by immediate but not delayed feedback." The Psychological Record 54, no. 2 (2004): 207-231.
[2] Prince, Michael. "Does active learning work? A review of the research." Journal of engineering education 93, no. 3 (2004): 223-231.
[3] Kang, Sean HK. "Spaced repetition promotes efficient and effective learning: Policy implications for instruction." Policy Insights from the Behavioral and Brain Sciences 3, no. 1 (2016): 12-19.
</p>

<?php
addLessonNavigation("/signals_systems.php", "lesson2.php", "Introduction", "Next");
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
