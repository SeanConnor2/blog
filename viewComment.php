<?php
  session_start();

  echo '<h1>View A Comment</h1>';

  // check session variable

  if (isset($_SESSION['valid_user'])){
   // echo '<p>You Are Logged In As '.$_SESSION['valid_user'].'</p>';
	print_comment();
	echo '<br><br><br><a href="index.php">Back To The Blog</a><br>' 
	. '<br><a href="logout.php">Logout  </a>';
  }
  else{ 
	print_comment();
	echo '<a href="index.php">Back To The Blog</a><br>';
	echo '<br><a href="login.php">Back To Login Page</a>';
  }
?>
<?php
function print_comment(){
	@ $db = new mysqli('localhost', '*', '*', '*');
	
	$query = "SELECT post.title, post.body, post.username, post.date, comments.body
				FROM post, comments
				WHERE post.postID = comments.postID";
				
$stmt = $db -> prepare($query);
$stmt->execute();
$stmt->store_result();		
$stmt->bind_result($title, $body, $username, $date, $combody);

	while($stmt->fetch()){
		echo "<p><strong>" . $title ."</strong><br>" . $body ."<br>" .$username ."\t\t" . $date ."<br>Comments:<br><strong>" . $combody . "</strong></p>";	
	}
$stmt->free_result();
$db->close();
}
?>