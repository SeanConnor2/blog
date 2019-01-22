<?php
session_start();
  // check session variable
  if (isset($_SESSION['valid_user'])){
    echo '<p>You Are Logged In As '.$_SESSION['valid_user'].'</p>';
	$user = $_SESSION['valid_user'];
  }
	if (isset($_SESSION['valid_user'])) {
		if($_SERVER["REQUEST_METHOD"] == "POST"){
	$title = test_input($_POST['title']);
	$body = test_input($_POST['body']);
		}
	// provide form to add a comment
	//title of post
    echo '<form method="post" action="addBlogPosting.php">';
    echo '<table>';
	echo '<tr><td>Title</td><br>';
	echo '<tr><td><input type="text" name = "title"/><br></td>';
    echo '<tr><td>Body Of Post</td><br>';
    echo '<tr><td><textarea name="body" rows="5" cols="40"></textarea></td>';
    echo '<tr><td><input type="submit" name="submit" value="Submit"></td></tr>';
    echo '</table></form>'; 

	@ $db = new mysqli('localhost', '*', '*', '*');
	
	$query = "INSERT INTO post (postID, title, body, username, date) 
			  VALUES (NULL, ?, ?, ?, NOW());";
			  			
$stmt = $db -> prepare($query);
$stmt->bind_param('sss',$title,$body,$user);
$stmt->execute();
$stmt->store_result();	
	
	while($stmt->fetch()){

	}
$stmt->free_result();
	echo '<br><br><br><a href="login.php">Back To Login Page</a><br>' . '<a href="logout.php">Logout</a>';
  }
  else{ 
    echo '<p>You Are Not Logged In. Please Login To Add A Post</p>';
	echo '<br><br><a href="login.php">Back To Home Page</a>';
  }
$db->close();	
?>
<?php
function test_input($data) {
  $data = htmlspecialchars($data);
  return $data;
}
?>