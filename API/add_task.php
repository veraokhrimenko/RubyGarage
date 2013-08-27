<?php 
	include 'connect.php';
		
		$id = $_POST['id'];
		$task_name = mysql_real_escape_string($_POST['task_name']);
		$position = $_POST['position'];
	
		$query = mysql_query("INSERT INTO tasks VALUES ('','$id','$task_name','false','$position','')") or die(mysql_error);
		$data = mysql_query("SELECT task_id, name FROM tasks WHERE name='$task_name'" , $connect);
		while($rows = mysql_fetch_array($data, MYSQL_ASSOC))
			{
			$json = array('id'=>$rows['task_id'], 'title'=>$rows['name'], 'position'=>$position);
			};
		
		echo  json_encode($json, JSON_NUMERIC_CHECK );
		mysql_close($connect);
?>