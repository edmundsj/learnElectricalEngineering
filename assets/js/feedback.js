function showThanks() {
    document.getElementById('feedbackButtons').hidden = true;
    document.getElementById('moreFeedback').innerHTML = "<p style='color: green'>Thank you for your feedback :)</p>";
};

// When the user clicks on "I'm still confused"
function askAboutConfusion() {
	submitPartialConfusedFeedback();
    document.getElementById('feedbackButtons').hidden = true;
    document.getElementById('moreFeedback').innerHTML = "<form>" +
        "<input type='text' placeholder='Describe here what you are confused about.' id='confusedText'></input>" +
        "</form>" +
        "<button id='submitConfusion'>Submit Feedback</button>";

    confusedSubmitButton = document.getElementById('submitConfusion');
    confusedSubmitButton.addEventListener('click', submitConfusedFeedback);
}

// When the user clicks on "Submit feedback"
function submitConfusedFeedback() {
	let pageLocation = window.location.href;
	pageLocation = pageLocation.replace('http://localhost', '');
	pageLocation = pageLocation.replace('https://www.learnelectricalengineering.com', '');
	confusionComment = {comment: document.getElementById('confusedText').value,
		feedback_type: 'Confused', page: pageLocation};
    showThanks();
	sendDatabaseRequest(confusionComment, '/includes/submit_feedback.php');
}

// in case the user doesn't provide a reason they are confused, just that they are confused.
function submitPartialConfusedFeedback() {
	let pageLocation = window.location.href;
	pageLocation = pageLocation.replace('http://localhost', '');
	pageLocation = pageLocation.replace('https://www.learnelectricalengineering.com', '');
	confusionComment = {comment: 'None',
		feedback_type: 'Confused', page: pageLocation};
    showThanks();
	sendDatabaseRequest(confusionComment, '/includes/submit_feedback.php');
}


function submitUnderstoodFeedback() {
	let pageLocation = window.location.href;
	pageLocation = pageLocation.replace('http://localhost', '');
	pageLocation = pageLocation.replace('https://www.learnelectricalengineering.com', '');
	understoodComment = {comment: "None",
		feedback_type: 'Understood', page: pageLocation};
	showThanks();
	sendDatabaseRequest(understoodComment, '/includes/submit_feedback.php');
}

understoodButton = document.getElementById('understood');
confusedButton = document.getElementById('confused');

understoodButton.addEventListener('click', submitUnderstoodFeedback);
confusedButton.addEventListener('click', askAboutConfusion);

function sendDatabaseRequest(objectToSend, targetFile) {
    let xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
		  // uncomment this line for debugging and bidirectional communication with server.
        //document.getElementById("moreFeedback").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("POST", targetFile, true);
    xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xmlhttp.send("data=" + JSON.stringify(objectToSend));
}
