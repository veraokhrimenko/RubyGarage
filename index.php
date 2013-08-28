<!DOCTYPE html>
<html>
<head>
	<title>Task manager</title>
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/jquery-ui-1.10.3.custom.min.css">
	<script type="text/javascript" src="js/jquery-2.0.3.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/knockout-2.2.1.js"></script>	
	<script type="text/javascript" src="js/knockout-jquery-ui-widget.js"></script>	
	<meta http-equiv="content-type" content="text/html" charset="utf-8" />	
</head>
<body>
	<div data-bind="foreach: lists">
	<div class="task-item">
		<div class="task-header" >
			<img src="images/task-icon.png" />
			<input type="text"  data-bind="value: title, disable:!isEdit(), valueUpdate: 'afterkeydown'" />
			<div class="task-links">
				<a class="edit-list" title="edit" data-bind="click: editList, visible: !isEdit()">edit</a>
				<a class="save" title="save" data-bind="click: saveList,visible: isEdit, css:{'visible':title}">save</a>
				<a class="remove-list" title="remove" data-bind="click: $parent.removeList.bind($parent), attr: {'data-id': id}">delete</a>
			</div>
		</div>
		<form class="add-task">
			<img src="images/plus-icon.png" /><input data-bind="value: newTaskText, valueUpdate: 'afterkeydown'" placeholder="What needs to be done?" /><button type="submit" data-bind="click: addTask, attr: {'data-id': id},  disable:!newTaskText()" />add task</button>
		</form>	
		<div class="task-list">
			<ul data-bind="foreach: tasks, visible: tasks().length > 0">
				<li data-bind="attr: {'data-id': id,'data-late':late}, css:{'deadline': late}">
					<input type="checkbox" data-bind="checked: isDone(), click: changeStatus, attr: {'data-status':isDone()}"  />
					<input data-bind="value: title, disable:!isEdit() || isDone, css: { 'finish': isDone }, valueUpdate: 'afterkeydown'">
					<div class="list-links" data-bind="css:{'hide': isDone}">
						<input type="text" placeholder="choose deadline" name="calendar" class="calendar datepicker" data-bind="value:deadline, click: setDeadline, jqueryui: 'datepicker'">
						<a class="edit" href="#" data-bind="click: editTask, valueUpdate: 'afterkeydown', visible: !isEdit()">edit</a>
						<a class="save" href="#" data-bind="click: saveTask, valueUpdate: 'afterkeydown', visible: isEdit, css:{'visible':title}">edit</a>
						<div class="sort">
							<a class="sort-top" data-bind="click: $parent.sortTaskUp.bind($parent)">sort</a>
							<a class="sort-bottom" data-bind="click: $parent.sortTaskDown.bind($parent)">sort</a>
						</div>
						<a class="remove" href="#" data-bind="click: $parent.removeTask.bind($parent)">Delete</a>
					</div>
				</li> 
			</ul>
		</div>
	</div>
</div>
<div class="fixed">
	<input data-bind="value: listTitle, valueUpdate: 'afterkeydown'" /><button class="add-list" data-bind="click: addList, disable: !listTitle()" type="submit">Add TODO list</button>
</div>
<div class="task-item">
	<div class="task-list">
	<ul class="info-sql">
		<div class="task-header">SQL tasks</div>
		<li data-bind="click: getInfo.bind($data,'status')">1. get all statuses, not repeating, alphabetically ordered</li>
		<li data-bind="click: getInfo.bind($data,'count')">2. get the count of all tasks in each project, order by tasks count descending</li>
		<li data-bind="click: getInfo.bind($data,'count_project')">3. get the count of all tasks in each project, order by projects names</li>
		<li data-bind="click: getInfo.bind($data,'task_letter')">4. get the tasks for all projects having the name beginning with 'N' letter</li>
		<li data-bind="click: getInfo.bind($data,'project_a')">5. get the list of all projects containing the 'a' letter in the middle of the name, and show the tasks count near each project. Mention that there can exist projects without tasks and tasks with project_id=NULL</li>
		<li data-bind="click: getInfo.bind($data,'duplicate')">6. get the list of tasks with duplicate names. Order alphabetically</li>
		<li data-bind="click: getInfo.bind($data,'matches')">7. get the list of tasks having several exact matches of both name and status, from the project "Garage". Order by matches count</li>
		<li data-bind="click: getInfo.bind($data,'complete')">8. get the list of project names having more than 10 tasks in status "completed". Order by project_id</li>
	</ul>
	</div>
</div>
<div class="task-item">
	<ul>
		<div class="task-header">Answer</div>
		<li id="result"></li>
	</ul>
</div>
</div>
</body>
</html> 






















