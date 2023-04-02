<?php
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
    // check if the user has confirmed the deletion
    if(isset($_POST['confirm_delete'])) {
      $email = $_SESSION['sess_user'];
      $sql = "delete from users where email = '$email'";
      $result = mysqli_query($conn,$sql);
      if ($result) {
        myAlert("Account Successfully deleted!", "login.php");
    } else {
        echo "<script>alert('Something went wrong!')</script>";
    }
    } else {
      // show confirmation message
      echo "Are you sure you want to delete your account?";
      echo "<form method='post'>";
      echo "<input type='hidden' name='delete_account' value='1'>";
      echo "<input type='submit' name='confirm_delete' value='Yes'>";
      echo "<input type='button' name='cancel_delete' value='No' onclick='window.history.back();'>";
      echo "</form>";
    }
?>