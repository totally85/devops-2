<?php
$auth_data = file_get_contents("secrets.json", true);
$auth_array = json_decode($auth_data, true);

//Searches the secrets.json file to get user and password credentials
foreach($auth_array as $row)
{
	foreach($row as $key=>$value)
	{
		if ($key == "user")
		{
			$user = $value;
		}
		if ($key == "password")
		{
			$password = $value;
		}
	}
}

// Connect to CloudSQL from App Engine.
$dsn = 'mysql:unix_socket=/cloudsql/devops-173103:us-central1:i1;dbname=devopsDB';
$db = new PDO ($dsn, $user, $password);
?>
