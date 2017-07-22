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
		try {
			$this->db = new PDO ($this->dsn, $this->user, $this->password);
		} catch (PDOException $exception) {
			die("Unable to connect to database");
		}
	}

	function userExists($username)
	{
		$sql = "SELECT COUNT(username) AS num FROM users WHERE username = :username";
		try {
			$statement = $this->db->prepare($sql);
			$statement->bindValue(':username', $username);
			$statement->execute();

			$row = $statement->fetch(PDO::FETCH_ASSOC);

			// Return true if a user was found.
			return $row['num'] > 0;
		} catch (PDOException $exception) {
			die("Unable to check if user exists");
		}
	}

	function addUser($username, $password)
	{
		$passwordHash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));
		$sql = "INSERT INTO users (username, password) VALUES (:username, :password)";

		try {
			$statement = $this->db->prepare($sql);
			$statement->bindValue(':username', $username);
			$statement->bindValue(':password', $passwordHash);
			$results = $statement->execute();
			return $results;
		} catch (PDOException $exception) {
			die("Unable to add user");
		}
	}

}
?>
