<html>
   <head>
      <title>Connecting MySQL Server</title>
   </head>
   <body>
      <?php
		/*
		 * To add the SQL database, open up the SQL program using the 'mysql' command.
		 * > create database my_database;
		 * > use database new_database;
		 * > create table new_table(column1 datatype1, ...);
		 *
		 *
		 * To create a user, and grant privileges to insert to specific table on specific database:
		 * > create user 'user'@'localhost' identified by 'password';
		 * > grant insert on new_database.new_table to 'new_user'@'localhost';
		 *
		 * To add a table to the database, first select the database then create a table:
		 *
		 * To add columns you need the alter table command (no semicolon after first command)
		 * > alter table new_table
		 * > add column_name datatype;
		 *
		 * [1] user creation
		 * https://stackoverflow.com/questions/1720244/create-new-user-in-mysql-and-give-it-full-access-to-one-database
		 */
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
			values(NOW(), "' . $user_id . '","' . $page . '","' . $user_ip . '","' . $comment . '","' . $type. '")';
		 
		$queryResult = $mysqli->query($desiredQuery);
		if ($queryResult  === True) {
		echo 'New record created successfully<br>';
		} else {
		echo 'Error: ' . $mysqli->error . '<br>';
		}
		$mysqli->close();
		echo 'Closed successfully';
      ?>
   </body>
</html>
