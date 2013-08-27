<?php 
	include 'connect.php';
		
		if (!$mybd) {
		  $sql = 'CREATE DATABASE task_manager';
			if (mysql_query($sql, $connect)) {
				echo "Database task_manager created successfully\n";
				$mybd = mysql_select_db('task_manager');
			} else {
				echo 'Error creating database: ' . mysql_error() . "\n";
		    }
		}
		
		$sqllist = "CREATE TABLE IF NOT EXISTS `lists`
			(`id` int NOT NULL auto_increment,
			`name` text NOT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM;";
		mysql_query($sqllist) or die ('Cannot create list' . mysql_error());
		
		$sqllist = "CREATE TABLE IF NOT EXISTS `tasks`
			(`task_id` int NOT NULL auto_increment,
			`id` int NOT NULL,
			`name` text NOT NULL,
			`status` text NOT NULL,
			`position` int NOT NULL,
			`deadline` DATE NOT NULL ,
			PRIMARY KEY (`task_id`),
			FOREIGN KEY (`id`) REFERENCES lists(id)
			) ENGINE=MyISAM;";
		mysql_query($sqllist) or die ('Cannot create list' . mysql_error());
		
		$lists = mysql_query("SELECT * FROM lists ORDER BY id", $connect);
		$tasks = mysql_query("SELECT * FROM tasks ORDER BY position", $connect);
		$json = array();
		$jsont = array();
		while($rows = mysql_fetch_array($lists, MYSQL_ASSOC))
			{
				array_push($json,array('id'=>$rows['id'], 'title'=>$rows['name'], 'tasks' => $jsont));
			};

		while($rowst = mysql_fetch_array($tasks, MYSQL_ASSOC))
			{	
			foreach ($json as &$task){
				if($rowst['id'] == $task['id']){
				if($rowst['deadline'] === '0000-00-00'){
					$rowst['deadline'] = 'choose deadline';
				} else {
					$rowst['deadline'] = date('d-m-Y', strtotime($rowst['deadline']));
				}
				 array_push($task['tasks'], array('title' => $rowst['name'], 'id' => $rowst['task_id'], 'status' => $rowst['status'], 'deadline' => $rowst['deadline'], 'position' => $rowst['position']));
				 };
			};
		};
		echo  json_encode($json, JSON_NUMERIC_CHECK ); 
		mysql_close($connect);
?>