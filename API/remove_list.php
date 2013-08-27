<?php 
	include 'connect.php';
		
		$id = $_POST['id'];
		$query = mysql_query("DELETE FROM tasks WHERE id = '$id'", $connect);
		$query = mysql_query("DELETE FROM lists WHERE id = '$id'", $connect);
		echo $query;
		mysql_close($connect);
?>