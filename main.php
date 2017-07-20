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

		require_once 'connect.php';
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
		
		
		 //error_reporting(E_ALL);
         //ini_set('display_errors', 1);
		  
		/*require_once 'connect.php';
		session_start();
		
		$connection = new mysqli($hn, $un, $pw, $db);
		
		if ($connection->connect_error) die($connection->connect_error);
		
		
			if ($_SESSION['type'] == "admin")
			{
				header("Location: admin_page.php");
			}
			elseif ($_SESSION['type'] == "user")
			{
				header("Location: user_page.php");
			}*/
		
		/*{
			header("Location: admin_page.php");
		}
		else
		{
			header("Location: user_page.php");
		}*/
		
          // Is someone already logged in? If so, forward them to the correct
          // page. (HINT: Implement this last, you cannot test this until
          //              someone can log in.)

          
          //      If username / password were valid, set session variables
          //      and forward them to the correct page
        /*if (isset($_POST['username']))
		{
			        
		
				$un_temp = $_POST['username'];
				$pw_temp = $_POST['password'];
								
				$query = "SELECT * FROM lab5_users WHERE username='$un_temp'";
				$result = $connection->query($query);
				$count=mysql_num_rows($result);
				

				
				if (!$result) die($connection->error);
				
				
				
				// Were a username and password provided? If so check them against
				// the database.
				else if ($result->num_rows)
				{
					//$result->data_seek(1);
					$row = $result->fetch_array(MYSQLI_ASSOC);

					$salt1 = "qm&h*"; // same salt values used when creating the users12 table
					$salt2 = "pg!@";
					$token = hash('ripemd128', "$salt1$pw_temp$salt2");
					
					

					if ($token == $row['password'])
					{
						$_SESSION['username'] = $un_temp;
						$_SESSION['password'] = $pw_temp;
						$_SESSION['forename'] = $row['forename'];
						$_SESSION['surname']  = $row['surname'];
						$_SESSION['type'] = $row['type'];
						
						if ($row['type'] == "admin")
						{
							header("Location: admin_page.php");
						}
						else
						{
							header("Location: user_page.php");
						}
					}
					else echo ("Invalid username/password combination");
				}  
          
          //      If the username / password were not valid, show error message
          //      and populate form with the original inputs
			else
			{
				echo ("Invalid username/password combination");
			}	
				
				$result->close();
				$connection->close();

		}
			
			
			*/
        ?>
		
        <h1>Welcome to <span style="font-style:italic; font-weight:bold; color: pink">
                Dev Ops Create Account</span>!</h1>
                
        <p style="color: red">
        <!--Placeholder for error messages-->
        </p>
        
        <form method="post" action="main.php">
            <label>Username: </label>
            <input type="text" name="username" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>"> <br>
            <label>Password: </label>
            <input type="password" name="password" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>"> <br>
            <input type="submit" name="register" value="Register">
        </form>
</html>
