<?php
  session_start();

  echo '<h1>Welcome To The Blog</h1>';

  // check session variable

  if (isset($_SESSION['valid_user'])){
    echo '<p>You Are Logged In As '.$_SESSION['valid_user'].'</p>';
	print_post();

  }
  else{ 
    echo '<p>You Are Not Logged In.</p>';
	print_post();
	echo '<br><a href="login.php">Back To Home Page</a>';
  }
 
?>
<?php
function print_post(){
	@ $db = new mysqli('localhost', '*', '*', '*');
	
 if (isset($_GET['page']))
	  $thispage = $_GET['page'];
  else
	  $thispage = 1;	
  
  $page = $thispage + 1;
  $first = ($thispage - 1) * 5;
  
	$query = "SELECT title, body, username, date, postID 
			FROM post
			ORDER BY date DESC
			LIMIT $first,5";
			
$stmt = $db -> prepare($query);
$stmt->execute();
$stmt->store_result();		
$stmt->bind_result($title, $body, $username, $date, $postID);

$rows = $stmt->num_rows;

	while($stmt->fetch()){
		echo "<p><strong>" . $title ."</strong><br>" . $body ."<br>" .$username . $date 
		. "<br>PostID:" . $postID ."</p>";	
	}
	echo '<a href="viewComment.php"> View Comments</a><br>';
	echo '<br><a href="addComment.php">Add A Comment</a><br>'; 
	echo '<br><a href="addBlogPosting.php">Add A Post </a><br><br>';
	
	
for($page = 1; $page <= $rows - 2; $page++)
		echo "<a href='index.php?page=$page'>$page ";
	
echo "<br>";
echo '<br><a href="logout.php">Logout </a>';
$stmt->free_result();
$db->close();

}
?>