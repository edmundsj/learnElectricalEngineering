<?php

function beginPage() {
	echo '<body class="is-preload">';
	echo '<div id="wrapper">';
}

function endPage() {
	echo '</div>';
	echo '</body>';
	echo '</html>';
}

function beginWrapper() {
	echo '<div id="main">';
	echo '<div class="inner">';
}

function endWrapper() {
	echo '<p>If you found this content helpful, it would mean a lot to me if you would support me on Patreon. Get access to my Discord server, exclusive content, and my personal thanks :)</p>';
	echo '<a href="https://www.patreon.com/bePatron?u=14713334" data-patreon-widget-type="become-patron-button">Become a Patron!</a><script async src="https://c6.patreon.com/becomePatronButton.bundle.js"></script>';
	echo '</div>';
	echo '</div>';
}

function addLessonNavigation($leftLink, $rightLink, $leftName="", $rightName="") {
	echo '<div style="width:100%; overflowlow: hidden;">';
	echo '<a style="float:left!important" href="' . $leftLink . '">&#8592;Previous Lesson: ' . $leftName . '</a>';
	echo '<a style="float:right!important" href="' . $rightLink . '">Next Lesson: ' . $rightName . ' &#8594;</a>';
	echo '</div>';
	echo '<br>';
	echo '<br>';
}

function addMobileImageFull($imageName) {
	echo '<div style="width:100%; overflow: hidden;">';
	echo '<img src="/images/' . $imageName . '", style="width:auto; height:auto; max-width:100%" />';
	echo '</div>';
}

function addMobileImage($imageName, $alignment="left") {
	echo '<img src="/images/' . $imageName . '", align="' . $alignment . '", style="width:auto; height: auto; max-width:100%" />';
}

function addMobileVideoFull($videoName) {
	echo '<div style="width:100%; overflow: hidden;">';
	echo '<video src="/videos/' . $videoName . '", style="width:auto; height:auto; max-width:100%" controls>';
	echo '</video>';
	echo '</div>';
	echo '<br>';
}

function appendToQuiz($counter, $question, $options, $answer) {
    // first, add the HTML for the quiz
    $questionText = 'question' . $counter;
    $buttonText = 'button' . $counter;
    $resultText = 'result' . $counter;
    $answer = strval($answer);

    echo '<b><i><p>' . $question . '</p></i></b>';
    $i = 0;
    foreach ($options as $value) {
        echo'<input type="radio" name="' . $questionText . '" value="' . $value . '" id="' . $counter .
            '_' . $i . '"/>';
        echo'<label for="' . $counter . '_' . $i .  '">' . $value . '</label><br/>';
        $i += 1;
    }
    echo '<button id="' . $buttonText . '">Check Answer</button>';
    echo '<div id="' . $resultText . '"></div>';
    echo '<hr>';

    echo '<script>' . "\n";
    echo 'function showResult' . $counter . '() {'. "\n";
    echo 'if(document.getElementById("' . $counter . '_' . $answer . '").checked == true) {' . "\n";
    echo 'question' . $counter . 'Result.innerHTML = "<p style=\"color:green;\">Correct.</p>";' . "\n";
    echo '} else {' . "\n";
    echo 'question' . $counter . 'Result.innerHTML = "<p style=\"color:red;\">Excellent! You\'ve got the wrong answer.     This presents a learning opportunity. Try again :)</p>";' . "\n";
    echo '}' . "\n";
    echo '}' . "\n";
    echo 'question' . $counter . 'Button = document.getElementById("'. $buttonText . '");' . "\n";
    echo 'question' . $counter . 'Button.addEventListener("click", showResult' . $counter . ');' . "\n";
    echo 'question' . $counter . 'Result = document.getElementById("' . $resultText . '");' . "\n";
    echo '</script>'. "\n";

    $counter += 1;
    return $counter;

// Sample code if we want the first answer to be the correct one (zero-indexed)
// $counter = 0
//$counter = appendToQuiz($counter, 'This is a question', 
//array('option 1', 'option 2'), 0);
}
