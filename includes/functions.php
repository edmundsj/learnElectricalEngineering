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

function addPatreonFooter() {
	echo '<p>If you found this content helpful, it would mean a lot to me if you would support me on Patreon. Help keep this content ad-free, get access to my Discord server, exclusive content, and receive my personal thanks for as little as $2. :)</p>';
	echo '<a href="https://www.patreon.com/bePatron?u=14713334" data-patreon-widget-type="become-patron-button">Become a Patron!</a><script async src="https://c6.patreon.com/becomePatronButton.bundle.js"></script>';
}

function addUnderstandingButtons() {
	echo '<div style="text-align:center" id="feedbackButtons">';
	echo '<button id="understood" style="margin-right:10px;">I Understood This</button>';
	echo "<button id='confused'>&#x1f914;I'm still confused.</button>";
	echo '</div>';
	echo '<div id="moreFeedback"></div>';
}

// this is where to put everything that should go on the core pages.
function endWrapper() {
	addUnderstandingButtons();
	addPatreonFooter();
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

// takes the user feedback and shoves it into the SQL database
function insertFeedbackToDatabase() {
	$data = json_decode($_POST['data']);
	$dbhost = 'localhost';
	$dbuser = 'feedbackUser';
	$dbpass = '%`Yy887"R5L4of%-';

	$dbhost = 'localhost';
	$dbuser = 'feedbackUser';
	$dbpass = '%`Yy887"R5L4of%-';

	$mysqli = new mysqli($dbhost, $dbuser, $dbpass);
	if ($mysqli->connect_errno) {
	echo 'Failed to connect to MySQL: ' . $mysqli->connect_error;
	exit();
	}
	//echo 'Connected successfully<br>';
	$user_id = 'None';
	$page = $_SERVER['REQUEST_URI'];
	$user_ip = $_SERVER['REMOTE_ADDR'];
	$comment = $data->comment;
	$type = $data->feedback_type;
	$page = $data->page;

	$desiredQuery = 'insert into user_feedback.bottom_page(timestamp, user_id, page, user_ip, comment, type)
	values(NOW(), "' . $user_id . '","' . $page . '","' . $user_ip . '","' . $comment . '","' . $type .            '")';

	$queryResult = $mysqli->query($desiredQuery);
	if ($queryResult  === False) {
	echo 'Error: ' . $mysqli->error . '<br>';
	}
	$mysqli->close();
	// echo 'Closed Successfully';
}
