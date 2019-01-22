<?php
session_start();
  // check session variable
  if (isset($_SESSION['valid_user'])){
    echo '<p>You Are Logged In As '.$_SESSION['valid_user'].'</p>';
	$user = $_SESSION['valid_user'];
  }
	if (isset($_SESSION['valid_user'])) {
		if($_SERVER["REQUEST_METHOD"] == "POST"){
	$comment = test_input($_POST['comment']);
	$postid = test_input($_POST['postid']);
		}
	// provide form to add a comment
	//title of post
    echo '<form method="post" action="addComment.php">';
    echo '<table>';
	echo '<tr><td>Please Enter The PostID</td><br>';
	echo '<tr><td><input type="text" name = "postid"/><br></td>';
    echo '<tr><td>Comment:</td><br>';
    echo '<tr><td><textarea name="comment" rows="5" cols="40"></textarea></td>';
    echo '<tr><td><input type="submit" name="submit" value="Submit"></td></tr>';
    echo '</table></form>'; 

	@ $db = new mysqli('localhost', '*', '*', '*');
	
	$query = "INSERT INTO comments (commentID, username, body, postID, date) 
			  VALUES (NULL, ?, ?, ?, NOW());";
			  				
$stmt = $db -> prepare($query);
$stmt->bind_param('ssi',$user,$comment,$postid);
$stmt->execute();
$stmt->store_result();	
	
	while($stmt->fetch()){

	}
$stmt->free_result();
	echo '<br><br><br><a href="login.php">Back To Login Page</a><br>' . '<a href="logout.php">Logout</a>';
  }
  else{ 
    echo '<p>You Are Not Logged In. Please Login To Add A Comment</p>';
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