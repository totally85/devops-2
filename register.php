<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Register</title>
        <style>
            input {
                margin-bottom: 0.5em;
            }
        </style>
    </head>
    <body>
        <?php
		include_once('resources/library/MySQLConnection.php');
                $conn = new MySQLConnection();
                $db = $conn->db;
		session_start();
		
		//If the POST var "register" exists (our submit button), then we can assume that the user has submitted the registration form.
		//RETRIEVE FIELD VALUES FROM REGISTRATION FORM
		if(isset($_POST['register'])) {
			if(!empty($_POST['username']) && !empty($_POST['password'])) {
				//Retrieve the field values from our registration form.
				$username = !empty($_POST['username']) ? trim($_POST['username']) : null;
				$pass = !empty($_POST['password']) ? trim($_POST['password']) : null;
			}
			else {
				die("Required field empty");
			}

			if $db->userExists($username) {
				die("That username already exists!");
			}

			//If the signup process is successful.
			if ($db->addUser($username, $pass)) {
				echo 'Thank you for registering with our website.';
			}
			else {
				echo "Error with registration";
			}
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
