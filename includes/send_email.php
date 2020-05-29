<?php

/* Namespace alias. */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;

// this is a testRefresh Token: 1//0d9xMblMydsrWCgYIARAAGA0SNgF-L9IrT2ZkQerD6vf8Wu3Cad8OBQLHqe2pB2zgW5U1m0JptSPLbtEn5jGP3Lv7hptFh76dDA

/* Include the Composer generated autoload.php file. */
require '../vendor/autoload.php';
$name = $_POST['name'];                                                                                                                                                  
$visitor_email = $_POST['email'];
$message = $_POST['message'];

/* Create a new PHPMailer object. Passing TRUE to the constructor enables exceptions. */

date_default_timezone_set('Etc/UTC');

$google_email = 'learneecs@gmail.com';
$oauth2_refreshToken = 'RefreshToken';
$oauth2_clientId = '984599864735-ierqhgh5itaf85q4ct178t597keu1d4l.apps.googleusercontent.com';
$oauth2_clientSecret = 'pOUfayf9XNGPkv--fAPqYmyU';
$oauth2_refreshToken = '1//0d9xMblMydsrWCgYIARAAGA0SNgF-L9IrT2ZkQerD6vf8Wu3Cad8OBQLHqe2pB2zgW5U1m0JptSPLbtEn5jGP3Lv7hptFh76dDA';
$redirectUri = 'https://www.learnelectricalengineering.com/vendor/phpmailer/phpmailer/get_oauth_token.php';

$mail = new PHPMailer(TRUE);

try {
	  /* Set the mail sender. */
	  $mail->setFrom($google_email, $name);
	  $mail->addAddress('jordan.e@berkeley.edu', 'Emperor');
	  $mail->Subject = 'New Message from ' . $visitor_email;
	  $mail->Body = $message;
	  $mail->isSMTP();
	  $mail->Port = 587;
	  $mail->SMTPAuth = TRUE;
	  $mail->SMTPSecure = 'tls';
	  $mail->Host = 'smtp.gmail.com';

	  /* Add a recipient. */
	  $mail->AuthType = 'XOAUTH2';
	  /* Create a new OAuth2 provider instance. */
	 $provider = new Google(
		   [
		'clientId' => $oauth2_clientId,
		'clientSecret' => $oauth2_clientSecret,
			]
		);
	     
	     /* Pass the OAuth provider instance to PHPMailer. */
	     $mail->setOAuth(
			new OAuth(
					[
					'provider' => $provider,
					'clientId' => $oauth2_clientId,
					'clientSecret' => $oauth2_clientSecret,
					'refreshToken' => $oauth2_refreshToken,
					'userName' => $google_email,
					 ]
				   )
				 );
	     
	     /* Finally send the mail. */
	     $mail->send();
	  echo("<script>alert('Message Successfully Sent!');" .
		  "window.location.href('/index.php');</script>");
}
catch (Exception $e)
{
	   echo $e->errorMessage();
}
catch (\Exception $e)
{
	   echo $e->getMessage();
}
