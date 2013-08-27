<?php $connect = mysql_connect('localhost','root') or die(mysql_error());
		mysql_query('SET NAMES "utf8"');
		$mybd = mysql_select_db('task_manager');
?>