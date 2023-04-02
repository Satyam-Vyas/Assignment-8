<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect("localhost","root","","dblab8");
	$email = $_POST['email'];
	$pwd = $_POST['password'];
	
	// select query to check if profile exists 
	$query = "SELECT * FROM users WHERE email='$email' and password='$pwd'";
	$result = mysqli_query($conn, $query);
	
	//If there exists a row with the given credentials, then redirect to respective profile page otherwise stay on same page by alert 
	if (mysqli_num_rows($result) != 0) {
		session_start();
		$_SESSION['sess_user'] = $email;
		header("Location: profile.php");
	} else {
		echo "<script>alert('Invalid email or password.')</script>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
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
		<h1>Login</h1>
		<form action="login.php" method="POST" enctype="multipart/form-data">
			<label for="email">Email</label>
			<input type="email" id="email" name="email" required>

			<label for="password">Password</label>
			<input type="password" id="password" name="password" required>

			<input type="submit" value="login">
		</form>
        <p>don't have an account <a href="http://localhost/assign8/register.php">register</a></p>
	</div>
</body>
</html>