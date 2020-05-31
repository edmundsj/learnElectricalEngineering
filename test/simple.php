<?php
$dbhost = 'localhost:3306';
 $dbuser = 'feedbackUser';
 $dbpass = '%`Yy887"R5L4of%-';

 $mysqli = new mysqli($dbhost, $dbuser, $dbpass);
 if ($mysqli->connect_errno) {
	 echo 'Failed to connect to MySQL: ' . $mysqli->connect_error;
	 exit();
 }
 echo 'Connected successfully<br>';
 $user_id = 'None';
 $page = $_SERVER['REQUEST_URI'];
 $user_ip = $_SERVER['REMOTE_ADDR'];
 $comment = 'None';
 $type = 'None';

$desiredQuery = 'insert into user_feedback.bottom_page(timestamp, user_id, page, ip, comment, type)
	values(NOW(), "' . $user_id . '","' . $page . '","' . $user_ip . '","' . $comment . '","' . $typ            e. '")';

$queryResult = $mysqli->query($desiredQuery);
if ($queryResult  === True) {
echo 'New record created successfully<br>';
} else {
echo 'Error: ' . $mysqli->error . '<br>';
}
$mysqli->close();
echo 'Closed successfully';
?>
