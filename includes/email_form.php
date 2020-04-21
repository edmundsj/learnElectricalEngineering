<?php
require_once "Mail.php";

$name = $_POST['name'];
$visitor_email = $_POST['email'];
$message = $_POST['message'];

$from = $visitor_email;
$to = 'jordan.e@berkeley.edu';

$host = "ssl://smtp.gmail.com";
$port = "465";
$username = 'learneecs@gmail.com';
$password = 'QPp-9bP`g9s6';

$subject = 'Message from: ' . $name . ". Email: " . $visitor_email;
$body = $message;

$headers = array ('From' => $from, 'To' => $to,'Subject' => $subject);
$smtp = Mail::factory('smtp',
  array ('host' => $host,
    'port' => $port,
    'auth' => true,
    'username' => $username,
    'password' => $password));

$mail = $smtp->send($to, $headers, $body);

if (PEAR::isError($mail)) {
  echo($mail->getMessage());
} else {
  echo("<script>alert('Message succesfully sent!'); " .
	  "window.history.go(-1);</script>");
}
