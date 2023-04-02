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
h3{
    text-align: center;
}
p{
    text-align: center;
    font-size: 15px;
	padding: 5px;
}
h1 {
	text-align: center;
}

</style>
</head>
<body>
	<div class="container">
        <h1>Your Information</h1>
		<h3>First Name: <?php echo $fname?></h3>
        <h3>Last Name: <?php echo $lname?></h3>
        <h3>Email: <?php echo $email?></h3>
		<p><a href = "http://localhost/assign8/profile.php">Profile Page</a></p>
	</div>
</body>
</html>