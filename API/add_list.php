<?php 
	include 'connect.php';		
		$title = mysql_real_escape_string($_POST['title']);
		

		$query = mysql_query("INSERT INTO lists VALUES ('','$title')") or die(mysql_error);
		$data = mysql_query("SELECT id, name FROM lists WHERE name='$title'", $connect);
		while($rows = mysql_fetch_array($data, MYSQL_ASSOC))
			{
			$json = array('id'=>$rows['id'], 'title'=>$rows['name']);
			};
		echo  json_encode($json, JSON_NUMERIC_CHECK);
		mysql_close($connect);
?>