<?php
class MySQLConnection
{
	private $dsn;
	private $user;
	private $password;
	public $db;

	function __construct() {
		$auth_data = file_get_contents("secrets.json", true);
		$auth = json_decode($auth_data);
		$mysql = $auth->mysql;
		$this->dsn = $mysql->dsn;
		$this->user = $mysql->user;
		$this->password = $mysql->password;

		// Connect to CloudSQL from App Engine.
		$this->db = new PDO ($dsn, $user, $password);
	}

	function userExists($username)
	{
		$sql = "SELECT COUNT(username) AS num FROM users WHERE username = :username";
		$statement = $this->db->prepare($sql);
		$statement->bindValue(':username', $username);
		$statement->execute();

		$row = $statement->fetch(PDO::FETCH_ASSOC);
		
		// Return true if a user was found.
		return $row['num'] > 0;
	}

	function addUser($username, $password)
	{
		$passwordHash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));
		$sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
		$statement = $this->db->prepare($sql);
		$statement->bindValue(':username', $username);
		$statement->bindValue(':password', $passwordHash);
		return $statement->execute();
	}

}
?>
