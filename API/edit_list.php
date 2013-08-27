<?php 
	include 'connect.php';
		
		$title = mysql_real_escape_string($_POST['title']);
		$id = $_POST['id'];
		$query = mysql_query("UPDATE lists SET name='$title' WHERE id='$id'") or die(mysql_error);
		echo $query;
		mysql_close($connect);
?>