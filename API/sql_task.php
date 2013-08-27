<?php 
	include 'connect.php';
		
		$task = $_POST['task'];
		$json =  array();
		if ($task == 'status'){
			$status = mysql_query("SELECT DISTINCT status FROM tasks ORDER BY status ASC", $connect);
			while($row = mysql_fetch_array($status))
			  {
			  echo $row['status'].'<br />';
			  }
		}
		if ($task == 'count'){
			$count = mysql_query("SELECT count(id) AS count FROM tasks GROUP BY id HAVING COUNT(id) > 0 ORDER BY COUNT(id) DESC", $connect);
			while($row = mysql_fetch_array($count))
			  {
			  echo $row['count'].'<br />';
			  }
			
		}
		if ($task == 'count_project'){
			$count = mysql_query("SELECT COUNT(tasks.task_id) AS cc FROM tasks JOIN lists ON tasks.id = lists.id GROUP BY tasks.id ORDER BY lists.name ASC", $connect);
			while($row = mysql_fetch_array($count))
			  {
			  echo $row['cc'].'<br />';
			  }
			
		}
		if ($task == 'task_letter'){
			$count = mysql_query("SELECT tasks.* FROM tasks WHERE name LIKE 'N%'", $connect);
			while($row = mysql_fetch_array($count))
			  {
			  echo $row['name'].'<br />';
			  }
			
		}
		if ($task == 'project_a'){
			$count = mysql_query("SELECT lists.*, COUNT(tasks.id) AS cc FROM lists LEFT JOIN tasks ON tasks.id = lists.id WHERE lists.name LIKE '%a%' GROUP BY tasks.id", $connect);
			while($row = mysql_fetch_array($count))
			  {
			  echo $row['name'].'-(';
			  echo $row['cc'].')<br />';
			  }
			
		}
		if ($task == 'duplicate'){
			$count = mysql_query("SELECT name, COUNT(name) AS count FROM tasks GROUP BY name ASC HAVING COUNT(name) > 1", $connect);
			while($row = mysql_fetch_array($count))
			  {
			  echo $row['name'].'<br />';
			  }
			
		}
		if ($task == 'matches'){
			$count = mysql_query("SELECT tasks.name, tasks.task_id, tasks.status FROM tasks INNER JOIN (SELECT task_id, status, name FROM tasks GROUP BY status HAVING count(task_id) > 1) dup ON tasks.status = dup.status WHERE id = (SELECT id FROM lists WHERE name = 'GARAGE') ORDER BY tasks.name", $connect);
			while($row = mysql_fetch_array($count))
			  {
			  echo $row['name'].'<br />';
			  }
			
		}
		if ($task == 'complete'){
			$count = mysql_query("SELECT lists.name, COUNT(tasks.id) as count FROM lists RIGHT JOIN tasks ON lists.id = tasks.id  WHERE tasks.status = 'true'  GROUP BY lists.name HAVING count > 10 ORDER BY lists.id", $connect);
			while($row = mysql_fetch_array($count))
			  {
			  echo $row['name'].'<br />';
			  }
			
		}

		mysql_close($connect);
?>