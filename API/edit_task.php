<?php 
	include 'connect.php';
		
		$title = mysql_real_escape_string($_POST['title']);
		$id = $_POST['id'];
		$prev_id = $_POST['replaceId'];
		$status = $_POST['status'];
		$date =$_POST['date'];
		$position =$_POST['position'];
		$replace_position =$_POST['replacePosition'];
		if ($title){
			$query = mysql_query("UPDATE tasks SET name='$title' WHERE task_id='$id'") or die(mysql_error);
		}
		if($status){
			$query = mysql_query("UPDATE tasks SET status='$status' WHERE task_id='$id'") or die(mysql_error);
		}
		if($date){
			$date = date('Y-m-d', strtotime($_POST['date']));
			$query = mysql_query("UPDATE tasks SET deadline='$date' WHERE task_id='$id'") or die(mysql_error);
		}
		if($position){
			$query = mysql_query("UPDATE tasks SET position='$position' WHERE task_id='$id'") or die(mysql_error);
			$query = mysql_query("UPDATE tasks SET position='$replace_position' WHERE task_id='$prev_id'") or die(mysql_error);
		}
		echo $query;
		mysql_close($connect);
?>