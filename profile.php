<?php
	session_start();
	$conn = mysqli_connect("localhost","root","","dblab8");
	//If there is no session user, then redirect to login page 
	if (!isset($_SESSION['sess_user'])) {
		header("location: login.php");
	}
	
	//Find various fields for an employee and save them in variables for display purposes 
	$email = $_SESSION['sess_user'];
	$sql = "SELECT * FROM users WHERE email='$email'";
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_array($result);
	
	$fname = $row["first_name"];
    $lname = $row["last_name"];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<style>
        .container {
	background-color: #f2fae2;
	border-radius: 5px;
	max-width: 500px;
	margin: 0 auto;
	padding: 20px;
}
p{
    text-align: center;
    font-size: 20px;
	padding: 5px;
}
h1 {
	text-align: center;
}

</style>
</head>
<body>
	<div class="container">
		<h1>Welcome <?php echo $fname." ".$lname."!"?></h1>
		<p>To view Profile Information <a href = "http://localhost/assign8/information.php">Click</a> here</p>
		<p>To update User details <a href = "http://localhost/assign8/update.php">Click</a> here</p>
		<p>To delete account <a href = "http://localhost/assign8/delete.php">Click</a> here</p>
		<p><a href = "http://localhost/assign8/logout.php">Logout</a></p>
	</div>
</body>
</html>
