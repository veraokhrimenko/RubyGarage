<?php 
	include 'connect.php';
		
		$id = $_POST['id'];
		$name = $_POST['name'];
		$query = mysql_query("DELETE FROM tasks WHERE task_id = '$id'", $connect) or die('something wrong!');
		echo $query;
		mysql_close($connect);
?>