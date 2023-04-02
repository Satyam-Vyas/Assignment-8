<?php
// function to sanitize user input
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
function myAlert($msg, $url){
    echo '<script language="javascript">alert("'.$msg.'");</script>';
    echo "<script>document.location = '$url'</script>";
     }
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
$pwd = $row["password"];
$id = $row["id"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    $Email = test_input($_POST["email"]);
    //email already registered
    $sql = "select * from users where email = '$Email'";
    $rslt = mysqli_query($conn,$sql);
    if (mysqli_num_rows($rslt) > 0) {
        $error = 1;
        echo "<script>alert('User already registered. Please use any other E-mail id.')</script>";
    }
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];
        if( mb_strlen($_POST["password"]) > 0){
        if (mb_strlen($_POST["password"]) <= 8 ) {
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
}
    if($error == 0){
           if($first_name){
            $updated_fname = $first_name;
           }
           else{
            $updated_fname = $fname;
           }
           if($last_name){
            $updated_lname = $last_name;
           }
           else{
            $updated_lname = $lname;
           }
           if($Email){
            $updated_email = $Email;
           }
           else{
            $updated_email = $email;
           }
           if($password){
           $updated_pwd = $password;
           }
           else{
            $updated_pwd = $pwd;
           }

            $query = "update users set first_name = '$updated_fname',last_name = '$updated_lname',email = '$updated_email',password = '$updated_pwd' where id = '$id'";
            $result = mysqli_query($conn,$query);
            if ($result) {
                session_start();
		        $_SESSION['sess_user'] = $updated_email;
                myAlert("User Updated Successfully!", "profile.php");
            } else {
                echo "<script>alert('Something went wrong!')</script>";
            }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Updation Form</title>
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
	padding: 10px 0px;
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
    <h1>Your Current Information</h1>
		<h3>First Name: <?php echo $fname?></h3>
        <h3>Last Name: <?php echo $lname?></h3>
        <h3>Email: <?php echo $email?></h3>
		<h1>User Updation form</h1>
        <h3>Fill Only the fields you want to change</h3>
		<form action="update.php" method="POST" enctype="multipart/form-data">
			<label for="first_name">First Name</label>
			<input type="text" id="first_name" name="first_name">

			<label for="last_name">Last Name</label>
			<input type="text" id="last_name" name="last_name">

			<label for="email">New Email</label>
			<input type="email" id="email" name="email">

			<label for="password">New Password</label>
			<input type="password" id="password" name="password">

			<label for="confirm_password">Confirm New Password</label>
			<input type="password" id="confirm_password" name="confirm_password">

			<input type="submit" value="Update">
			<p>go back <a href="http://localhost/assign8/profile.php">profile page</a></p>
		</form>
	</div>
</body>
</html>