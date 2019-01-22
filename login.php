<?php
session_start();

if (isset($_POST['userid']) && isset($_POST['password']))
{
  // if the user has just tried to log in
  $userid = test_input($_POST['userid']);
  $password = test_input($_POST['password']);

  @ $db_conn = new mysqli('localhost', '*', '*', '*');

  if (mysqli_connect_errno()) {
   echo 'Connection to database failed:'.mysqli_connect_error();
   exit();
  }
   $query = "select username from users " 
			.	"WHERE username = ? and password = sha1(?)";
				
  $stmt = $db_conn -> prepare($query);
  $stmt->bind_param('ss',$userid,$password);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($user);
 
  if ($stmt->num_rows > 0 )
  {
    // if they are in the database register the user id
    $_SESSION['valid_user'] = $userid;    
  }
  $stmt->free_result();
  $db_conn->close();
}			
?>

<html>
<body>
<h1>Home Page</h1>
<? 
  if (isset($_SESSION['valid_user']))
  {
    echo 'You are logged in as: '.$_SESSION['valid_user'].' <br />';
    echo '<a href="logout.php">Log out</a><br />';
  }
  else
  {
    if (isset($userid))
    {
      // if they've tried and failed to log in
      echo 'Could not log you in.<br />';
    }
    else 
    {
      // they have not tried to log in yet or have logged out
      echo 'You are not logged in.<br />';
    }

    // provide form to log in 
    echo '<form method="post" action="login.php">';
    echo '<table>';
    echo '<tr><td>Userid:</td>';
    echo '<td><input type="text" name="userid"></td></tr>';
    echo '<tr><td>Password:</td>';
    echo '<td><input type="password" name="password"></td></tr>';
    echo '<tr><td colspan="2" align="center">';
    echo '<input type="submit" value="Log in"></td></tr>';
    echo '</table></form>';
  }
?>
<?php
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<br />
<a href="index.php">Proceed To The Blog</a>
</body>
</html>
