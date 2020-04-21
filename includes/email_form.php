<?php
$name = $_POST['name'];
$visitor_email = $_POST['email'];
$message = $_POST['message'];

$email_from = 'jordan.e@berkeley.edu';
$email_subject = 'New Website Submission';
$email_body = 'Message from user $name.\nMessage: $message';

$to = 'edmundsj.e@uci.edu';
$headers = 'From: $email_from\r\n';
$headers .= 'Reply-To: $visitor_email \r\n';

function isInjected($str) {
	$injections = array('(\n+)',
		'(\r+)',
		'(\t+)',
		'(%0A+)',
		'(%0D+)',
		'(%08+)',
		'(%09+)',
	);
	$inject = join('|', $injections);
	$inject = '/$inject/i';

	if(preg_match($inject, $str)) {
		return true;
	} else {
		return false;
	}
}
if(isInjected($visitor_email)) {
	echo "Bad email value!";
	exit;
}
else {
	mail($to, $email_subject, $email_body, $headers);
	echo'Done!';
}
?>
