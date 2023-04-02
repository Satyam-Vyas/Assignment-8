<?php
// check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$conn = mysqli_connect("localhost","root","","dblab8");
	// validate first name
	    $error = 0;
		$first_name = test_input($_POST["first_name"]);
		// check if first name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z ]*$/",$first_name)) {
			$error = 1;
			echo "<script>alert('Only letters and white space allowed in first name')</script>";
		}
		$last_name = test_input($_POST["last_name"]);
		// check if last name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z ]*$/",$last_name)) {
			$error = 1;
			echo "<script>alert('Only letters and white space allowed in last name')</script>";
		}
        $email = test_input($_POST["email"]);
        //email already registered
		$sql = "select * from users where email = '$email'";
		$rslt = mysqli_query($conn,$sql);
		if (mysqli_num_rows($rslt) > 0) {
			$error = 1;
			echo "<script>alert('User already registered. Please login.')</script>";
		}
       // check if email address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$error = 1;
		echo "<script>alert('Invalid email format')</script>";
		}
			$password = $_POST["password"];
			$confirm_password = $_POST["confirm_password"];
			if (mb_strlen($_POST["password"]) <= 8) {
				$error = 1;
				echo "<script>alert('Your Password Must Contain At Least 8 Characters!')</script>";
			}
			elseif(!preg_match("#[0-9]+#",$password)) {
				$error = 1;
				echo "<script>alert('Your Password Must Contain At Least 1 Number!')</script>";
			}
			elseif(!preg_match("#[A-Z]+#",$password)) {
				$error = 1;
				echo "<script>alert('Your Password Must Contain At Least 1 Capital Letter!')</script>";
			}
			elseif(!preg_match("#[a-z]+#",$password)) {
				$error = 1;
				echo "<script>alert('Your Password Must Contain At Least 1 Lowercase Letter!')</script>";
			}
			elseif(!preg_match("#[\W]+#",$password)) {
				$error = 1;
				echo "<script>alert('Your Password Must Contain At Least 1 Special Character!')</script>";
			} 
			elseif ($password != $confirm_password) {
				$error = 1;
				echo "<script>alert('Passwords must match!')</script>";
		}
		if($error == 0){
			
				$query = "insert into users(first_name,last_name,email,password) values('$first_name','$last_name','$email','$password')";
				$result = mysqli_query($conn,$query);
				if ($result) {
					echo "<script>alert('User registerd!')</script>";
				    header("Location: login.php");
				} else {
					echo "<script>alert('Something went wrong!')</script>";
				}
		}

}

// function to sanitize user input
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration Form</title>
	<style>
        .container {
	max-width: 500px;
	margin: 0 auto;
	padding: 20px;
}
p{
    text-align: center;
    font-size: 10px;
}
h1 {
	text-align: center;
}

label {
	display: block;
	margin-bottom: 15px;
}

input[type="text"],
input[type="email"],
input[type="password"] {
	width: 100%;
	padding: 10px;
	margin-bottom: 15px;
	border-radius: 5px;
}

input[type="submit"] {
	display: block;
	margin: 0 auto;
	padding: 10px 20px;
	border: none;
	border-radius: 5px;
	background-color: rgba(4, 31, 233, 0.615);
	color: #fff;
	font-size: 16px;

}
    </style>
</head>
<body>
	<div class="container">
		<h1>User Registration Form</h1>
		<form action="register.php" method="POST" enctype="multipart/form-data">
			<label for="first_name">First Name</label>
			<input type="text" id="first_name" name="first_name" required>

			<label for="last_name">Last Name</label>
			<input type="text" id="last_name" name="last_name" required>

			<label for="email">Email</label>
			<input type="email" id="email" name="email" required>

			<label for="password">Password</label>
			<input type="password" id="password" name="password" required>

			<label for="confirm_password">Confirm Password</label>
			<input type="password" id="confirm_password" name="confirm_password" required>

			<input type="submit" value="Register">
			<p>already have an account <a href="http://localhost/assign8/login.php">login</a></p>
		</form>
	</div>
</body>
</html>