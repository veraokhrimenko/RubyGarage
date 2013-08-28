	function Lists (){		
		this.listTitle = ko.observable();
		this.lists = ko.observableArray([]);
	};
		
		Lists.prototype.setLists = function(){
			var self = this;
			$.ajax({
				type: "GET",
				url: 'API/get_lists.php',
				dataType : 'json',
				success: function(data){
					$.each(data, function(i, item) {
						self.lists.push(new List(data[i]));							
					});
				}	
			});
		};
		
		Lists.prototype.addList = function(){
			var value = this.listTitle();
			var self = this;
			$.ajax({
				type: "POST",
				url: 'API/add_list.php',
				dataType : 'json',
				data: {title:value},
				success: function(data){
					self.lists.push(new List(data));
					self.listTitle("");
				}	
			});
		};
		
		Lists.prototype.removeList = function(data) { 
			var self = this;
			var id = data.id;
			$.ajax({
				type: "POST",
				url: 'API/remove_list.php',
				dataType : 'json',
				data: {id:id},
				success: function(){
					self.lists.remove(data);
				}
			}); 
		};
		
	function List(data) {
		var self = this;
		self.title = ko.observable(data.title);
		self.isEdit = ko.observable(data.isEdit) || ko.observable(false);
		self.id = data.id;
		self.tasks = ko.observableArray([]);
		self.newTaskText = ko.observable() ;
		self.setTask(data);
	};
	
		List.prototype.setTask = function(data){
			var self = this;
			if(data.tasks){
				$.each(data.tasks, function(i, item) {
					self.tasks.push(new Task(data.tasks[i]));
				});
			};
		}
		List.prototype.editList = function(data) {
			data.isEdit(true);
		};
		
		List.prototype.saveList = function() {
			var self = this;
			var value = self.title;
			var id = self.id;
			
			$.ajax({
				type: "POST",
				url: 'API/edit_list.php',
				dataType : 'json',
				data: {id:id, title:value},
				success: function(data){
					self.isEdit(false);
				}
			}); 
		};
		
		List.prototype.addTask = function(data) {
			var self = this;
			var value = self.newTaskText();
			var id = data.id;
			var tasksArr = self.tasks();
			var tasksArrLen = tasksArr.length;
			var position = tasksArrLen ? parseFloat(tasksArr[tasksArrLen - 1].position()) : 0;
			$.ajax({
				type: "POST",
				url: 'API/add_task.php',
				dataType : 'json',
				data: {id:id,task_name:value,position:position+1},
				success: function(data){
					self.tasks.push(new Task(data));
					self.newTaskText('');
				}	
			});  
		};
		
		List.prototype.removeTask = function(data) {
			var self = this;
			var id = data.id;
			var name = data.title();
			$.ajax({
				type: "POST",
				url: 'API/remove_task.php',
				dataType : 'json',
				data: {id:id, name:name},
				success: function(){
					self.tasks.remove(data);
				}
			}); 
		};

		List.prototype.sortTaskUp = function(task){	
			var self = this;
			self.sortTask(task, 'up')
		};
		
		List.prototype.sortTaskDown = function(task){
			var self = this;
			self.sortTask(task, 'down')
		};

		List.prototype.sortTask = function(task, direction){
			var self = this;
			var id = task.id;
			var position = task.position();			
			var currPosition = self.tasks.indexOf(task);
			var tasksArr = self.tasks();
			var tasksArrLen = tasksArr.length;
			if (direction == 'up'){
				var replaceTask = tasksArr[currPosition-1] ? tasksArr[currPosition-1] : false;
				var replaceId = replaceTask ? replaceTask.id : false;
				var replacePosition = replaceTask ? replaceTask.position() : false;
				var arrPosition = currPosition-1;
			} else {
				var replaceTask = tasksArr[currPosition+1] ? tasksArr[currPosition+1] : false;
				var replaceId = replaceTask ? replaceTask.id : false;
				var replacePosition = replaceTask ? replaceTask.position() : false;
				var arrPosition = currPosition+1;
			}
			if (replaceId && replacePosition){
				$.ajax({
					type: "POST",
					url: 'API/edit_task.php',
					dataType : 'json',
					data: {id:id, position:replacePosition, replaceId:replaceId,replacePosition:position },
					success: function(data){
						task.position = ko.observable(replacePosition);
						replaceTask.position =  ko.observable(position);
						self.tasks.splice(currPosition,1)
						self.tasks.splice(arrPosition, 0, task);
					}
				});
			}
			
		}
		
		function Task(data){
			var self = this;
			self.title = ko.observable(data.title);
			self.id = data.id;
			self.deadline = ko.observable(data.deadline);
			self.position = ko.observable(data.position);
			self.late = ko.observable(this.checkDate(data.deadline));
			self.isEdit = ko.observable(data.isEdit);
			self.isDone = data.status === 'true' ? ko.observable(true) : ko.observable(false);
		};
		
		Task.prototype.editTask = function(data){
			data.isEdit(true);
		};
		
		Task.prototype.checkDate = function(deadline){
			var self = this;
			var currentDate = new Date();
			
			if (deadline){
			var dealineYear = deadline.split('-')[2];
			var dealineMonth = deadline.split('-')[1]-1;
			var dealineDay = deadline.split('-')[0];
			var dealineDate = new Date(dealineYear,dealineMonth,dealineDay );
			if (currentDate == dealineDate || currentDate > dealineDate) {
				return true;
				}
			return false;
			}
		};
		
		Task.prototype.saveTask = function(data){
			var self = this;
			var id = self.id;
			var value = self.title;
			$.ajax({
				type: "POST",
				url: 'API/edit_task.php',
				dataType : 'json',
				data: {id:id, title:value},
				success: function(data){
					self.isEdit(false);
				}
			}); 
		};
		
		Task.prototype.changeStatus = function(data){
			var self = this;
			var id = self.id;
			var value = self.title;
			var status = self.isDone() ? false : true;
			$.ajax({
				type: "POST",
				url: 'API/edit_task.php',
				dataType : 'json',
				data: {id:id, status:status, title:value},
				success: function(data){
					self.isDone(status);
				}
			});  
		};
		
		Task.prototype.setDeadline = function(data){
			var self = this;
			var id = self.id;
			$.datepicker.setDefaults({ 
				onSelect: function(value, date) { 
				$.ajax({
					type: "POST",
					url: 'API/edit_task.php',
					dataType : 'json',
					data: {id:id, date:value},
					success: function(){	
							self.late(self.checkDate(value))
							self.deadline(value)
						}
					}); 
				}, 
				dateFormat: "dd-mm-yy"
			});	
		};
		
		function getInfo(task) {
			$.ajax({
				type: "POST",
				url: 'API/sql_task.php',
				dataType : 'html',
				data: {task:task},
				success: function(data){	
						$('#result').html(data)	
					}
				}); 
			};
			
$('document').ready(function(){
	var  lists = new Lists();
	lists.setLists();
	ko.applyBindings(lists);	
});
