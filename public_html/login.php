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

		include_once('resources/library/MySQLConnection.php');
		session_start();
		
		//If the POST var "login" exists (our submit button), then we can assume that the user has submitted the login form.
		//RETRIEVE FIELD VALUES FROM LOGIN FORM
		if(isset($_POST['login']))
		{
			if(!empty($_POST['username']) && !empty($_POST['password']))
			{
				//Retrieve the field values from our registration form.
				$username = !empty($_POST['username']) ? trim($_POST['username']) : null;
				$pass = !empty($_POST['password']) ? trim($_POST['password']) : null;
			}
			else
				die("Required field empty");

			
		
		//RETRIEVE ACCOUNT INFORMATION FROM DATABASE
		//Construct the SQL statement and prepare it.
		//The SQL statement can contain zero or more named (:name) or question mark (?) parameter markers for which real values will be 
		//substituted when the statement is executed.
		$sql = "SELECT username, password FROM users WHERE username=:username";
		$statement = $db->prepare($sql);
		
		//Bind the provided username to our prepared statement.
		$statement->bindValue(':username', $username);
		
		//Execute.
		$statement->execute();
		
		//Fetch the row.
		$user = $statement->fetch(PDO::FETCH_ASSOC);
		
		//If user could not be found
		if($user === false)
		{
			die("Incorrect username/password combination");
		}
		else //If user is found
		{
			//Compare the passwords.
			$validPassword = password_verify($pass, $user['password']);
			
			if($validPassword)
			{
				//Provide the user with a login session.
				$_SESSION['user_id'] = $user['username'];
				$_SESSION['logged_in'] = time();
				
				echo "Thank you!";
				
				//Redirect to our protected page, which we called home.php
				//header('Location: home.php');
				exit;
				
			} 
			else
			{
				//$validPassword was FALSE. Passwords do not match.
				die('Incorrect username / password combination!');
			}
		}
		
		$result->close();
		$statement = null;
		$db = null;
	}
 ?>
		
        <h1>Welcome to <span style="font-style:italic; font-weight:bold; color: pink">
                Dev Ops Login</span>!</h1>
                
        <p style="color: red">
        <!--Placeholder for error messages-->
        </p>
        
        <form method="post" action="login">
            <label>Username: </label>
            <input type="text" name="username" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>"> <br>
            <label>Password: </label>
            <input type="password" name="password" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>"> <br>
            <input type="submit" name="login" value="Login">
        </form>
		
		<p style="font-style:italic">
            Forgot password<br><br>
            <a href="register">Create Account</a>
        </p>

</html>
