<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/User.php";

    
    if (!isset($_GET['id'])) {
    	 header("Location: tasks.php");
    	 exit();
    }
    $id = $_GET['id'];
    $task = get_task_by_id($conn, $id);

    if ($task == 0) {
    	 header("Location: tasks.php");
    	 exit();
    }
    $users = get_all_users($conn);
    

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Task</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
	<style>
		.progress-section {
			margin-top: 40px;
			padding: 20px;
			background: #f8f9fa;
			border-radius: 8px;
		}
		.progress-item {
			background: #fff;
			padding: 15px;
			margin-bottom: 15px;
			border-left: 4px solid #007bff;
			border-radius: 4px;
			box-shadow: 0 2px 4px rgba(0,0,0,0.1);
		}
		.progress-item.admin-followup {
			border-left-color: #28a745;
			background: #e8f5e9;
		}
		.progress-header {
			font-weight: bold;
			margin-bottom: 8px;
			color: #333;
		}
		.progress-time {
			color: #666;
			font-size: 0.85em;
			margin-top: 8px;
		}
		.followup-form {
			background: #fff;
			padding: 20px;
			border-radius: 8px;
			margin-top: 20px;
		}
		.subtopic-examples {
			font-size: 0.85em;
			color: #666;
			margin-top: 5px;
			font-style: italic;
		}
	</style>
</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1">
			<h4 class="title">Edit Task <a href="tasks.php">Tasks</a></h4>
			
			<!-- Task Edit Form -->
			<form class="form-1"
			      method="POST"
			      action="app/update-task.php">
			      <?php if (isset($_GET['error'])) {?>
      	  	<div class="danger" role="alert">
			  <?php echo stripcslashes($_GET['error']); ?>
			</div>
      	  <?php } ?>

      	  <?php if (isset($_GET['success'])) {?>
      	  	<div class="success" role="alert">
			  <?php echo stripcslashes($_GET['success']); ?>
			</div>
      	  <?php } ?>
				<div class="input-holder">
					<lable>Title</lable>
					<input type="text" name="title" class="input-1" placeholder="Title" value="<?=$task['title']?>"><br>
				</div>
				<div class="input-holder">
					<lable>Description</lable>
					<textarea name="description" rows="5" class="input-1" ><?=$task['description']?></textarea><br>
				</div>
				
				<div class="input-holder">
					<lable>Task Type</lable>
					<select name="task_type" class="input-1" id="taskType" required>
						<option value="">Select Task Type</option>
						<option value="Teaching" <?=$task['task_type']=='Teaching'?'selected':''?>>Teaching</option>
						<option value="Research" <?=$task['task_type']=='Research'?'selected':''?>>Research</option>
						<option value="Administrative" <?=$task['task_type']=='Administrative'?'selected':''?>>Administrative</option>
						<option value="Establishment" <?=$task['task_type']=='Establishment'?'selected':''?>>Establishment</option>
					</select><br>
				</div>
				
				<div class="input-holder">
					<lable>Subtopic</lable>
					<input type="text" name="subtopic" class="input-1" placeholder="Enter subtopic details" value="<?=$task['subtopic']?>"><br>
					<div class="subtopic-examples" id="subtopicHelp">
						<?php 
						$examples = [
							'Teaching' => 'Examples: Prepare lecture notes, Conduct tutorial sessions, Grade assignments, Create question bank',
							'Research' => 'Examples: Literature review, Data collection, Write research paper, Submit grant proposal',
							'Administrative' => 'Examples: Committee meeting, Update curriculum, Student counseling, Organize event',
							'Establishment' => 'Examples: Infrastructure planning, Purchase requests, Lab setup, Equipment maintenance'
						];
						echo isset($examples[$task['task_type']]) ? $examples[$task['task_type']] : 'Select a task type to see example subtopics';
						?>
					</div>
				</div>
				
				<div class="input-holder">
					<lable>Due Date</lable>
					<input type="date" name="due_date" class="input-1" placeholder="Due Date" value="<?=date('Y-m-d', strtotime($task['due_date']))?>"><br>
				</div>
				<div class="input-holder">
					<lable>Due Time</lable>
					<input type="time" name="due_time" class="input-1" placeholder="Due Time" value="<?=date('H:i', strtotime($task['due_date']))?>"><br>
				</div>
				
            <div class="input-holder">
					<lable>Assigned to</lable>
					<select name="assigned_to" class="input-1">
						<option value="0">Select employee</option>
						<?php if ($users !=0) { 
							foreach ($users as $user) {
								if ($task['assigned_to'] == $user['id']) { ?>
									<option selected value="<?=$user['id']?>"><?=$user['full_name']?> (<?=$user['department']?>)</option>
						<?php }else{ ?>
                  <option value="<?=$user['id']?>"><?=$user['full_name']?> (<?=$user['department']?>)</option>
						<?php } } } ?>
					</select><br>
				</div>
				<input type="text" name="id" value="<?=$task['id']?>" hidden>

				<button class="btn-primary">Update Task</button>
			</form>
			

			
		</section>
	</div>

<script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(4)");
	active.classList.add("active");
	
	// Show example subtopics based on task type
	const subtopicExamples = {
		'Teaching': 'Examples: Prepare lecture notes, Conduct tutorial sessions, Grade assignments, Create question bank',
		'Research': 'Examples: Literature review, Data collection, Write research paper, Submit grant proposal',
		'Administrative': 'Examples: Committee meeting, Update curriculum, Student counseling, Organize event',
		'Establishment': 'Examples: Infrastructure planning, Purchase requests, Lab setup, Equipment maintenance'
	};
	
	document.getElementById('taskType').addEventListener('change', function() {
		const helpText = document.getElementById('subtopicHelp');
		if (this.value) {
			helpText.textContent = subtopicExamples[this.value];
		} else {
			helpText.textContent = 'Select a task type to see example subtopics';
		}
	});
</script>
</body>
</html>
<?php }else{ 
   $em = "First login";
   header("Location: login.php?error=$em");
   exit();
}
 ?>