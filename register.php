<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Log in</title>
        <style>
            input {
                margin-bottom: 0.5em;
            }
        </style>
    </head>
    <body>
        <?php
		require_once 'resources/library/connect.php';
		session_start();
		
		//If the POST var "register" exists (our submit button), then we can assume that the user has submitted the registration form.
		//RETRIEVE FIELD VALUES FROM REGISTRATION FORM
		if(isset($_POST['register']))
		{
			if(!empty($_POST['username']) && !empty($_POST['password']))
			{
				//Retrieve the field values from our registration form.
				$username = !empty($_POST['username']) ? trim($_POST['username']) : null;
				$pass = !empty($_POST['password']) ? trim($_POST['password']) : null;
			}
			else
				die("Required field empty");

			
		
		//TO ADD: Error checking (username characters, password length, etc).
		
		//CHECK IS USERNAME EXISTS
		//Construct the SQL statement and prepare it.
		//The SQL statement can contain zero or more named (:name) or question mark (?) parameter markers for which real values will be 
		//substituted when the statement is executed.
		$sql = "SELECT COUNT(username) AS num FROM users WHERE username = :username";
		$statement = $db->prepare($sql);
		
		//Bind the provided username to our prepared statement.
		$statement->bindValue(':username', $username);
		
		//Execute.
		$statement->execute();
		
		//Fetch the row.
		$row = $statement->fetch(PDO::FETCH_ASSOC);
		
		//If the provided username already exists - display error.
		//TO ADD - Your own method of handling this error. 
		if($row['num'] > 0)
		{
			die("That username already exists!");
		}
		
		
		//Hash the password as we do NOT want to store our passwords in plain text.
		$passwordHash = password_hash($pass, PASSWORD_BCRYPT, array("cost" => 12));
		
		//Prepare our INSERT statement.
		$sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
		$statement = $db->prepare($sql);
		
		//Bind our variables.
		$statement->bindValue(':username', $username);
		$statement->bindValue(':password', $passwordHash);
	 
		//Execute the statement and insert the new account.
		$result = $statement->execute();
		
		//If the signup process is successful.
		if($result)
		{
			//What you do here is up to you!
			echo 'Thank you for registering with our website.';
		}
		else
		{
			echo "Error with registration";
		}
		
		$result->close();
		$statement = null;
		$db = null;
	}
        ?>
		
        <h1>Welcome to <span style="font-style:italic; font-weight:bold; color: pink">
                Dev Ops Create Account</span>!</h1>
                
        <p style="color: red">
        <!--Placeholder for error messages-->
        </p>
        
        <form method="post" action="register.php">
            <label>Username: </label>
            <input type="text" name="username" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>"> <br>
            <label>Password: </label>
            <input type="password" name="password" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>"> <br>
            <input type="submit" name="register" value="Register">
        </form>
</html>
