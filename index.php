<?php session_start() ?> 
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>

<?php 

	//check for form submission

	if(isset($_POST['submit'])){

		$errors = array();
		//check if the username and password has been entered

		if(!isset($_POST['email']) || strlen(trim($_POST['email'])) <1 ){
			$errors[]='Username is missing or invalid';

		}

		if(!isset($_POST['password']) || strlen(trim($_POST['password'])) <1 ){
			$errors[]='password is missing or invalid';

		}

	//check if there are any error in the form 

		if(empty($errors)){

		//save user name and password into variable
			$email = mysqli_real_escape_string($connection,$_POST['email']);
			$password = mysqli_real_escape_string($connection,$_POST['password']);
			$hashed_password = sha1($password);

	
		//prepare databse query
			$query = "SELECT * FROM user 
						WHERE email='{$email}'
						AND password='{$hashed_password}'
							lIMIT 1";

			$result_set = mysqli_query($connection,$query);
			verify_query($result_set);
				//query succsessful
				if(mysqli_num_rows($result_set) == 1)
				{
					//valid user found

					$user = mysqli_fetch_assoc($result_set);
					$_SESSION['user_id'] = $user['id'];
					$_SESSION['first_name'] = $user['first_name'];
						
					//update last login
					$query = "UPDATE user SET last_login = NOW()";
					$query .= "WHERE id = {$_SESSION['user_id']} LIMIT 1";	
					$result_set = mysqli_query($connection,$query);
					verify_query($result_set);


					//redirect to users.php
					header('Location: cart.php');
				}else{
					//user name and password invalid
					$errors[]='Invalid User name and password';
				}
			
		
		
		

		}
		
	

	}
	
	
 ?>





<!DOCTYPE html>
<html>
<head>
	<title> Login - UMS </title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>

	<div class='login'>

		<form action="index.php" method="POST">
			
			<fieldset>
				<legend><h1> User LogIn</h1></legend>

				<?php 
					if (isset($errors) && !empty($errors)) {
						echo '<p class="error">'.$errors[0].'</p>';
					}
				 ?>

				 <?php 
				 		if (isset($_GET['logout'])) {
				 			echo '<p class="logout">Successfuly Logged Out</p>';
				 		}
				  ?>
				
				

				<p>
					<label for=""><b>Username:</b></label>
					<input type="text" name='email' id="" placeholder="Email Address">
				</p>
				<p>
					<label for=""><b>Password</b></label>
					<input type="password" name='password' id="" placeholder="Password">

				</p>	
				<p>
					<button type="submit" name="submit">Log In</button>
				</p>

			</fieldset>

		</form>


	</div>



</body>
</html>


<?php
mysqli_close($connection);
?>
