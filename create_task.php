<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/User.php";

    $users = get_all_users($conn);

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Create Task</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
	<style>
		.subtopic-examples {
			font-size: 0.85em;
			color: #666;
			margin-top: 5px;
			font-style: italic;
		}
		.file-upload-info {
			background: #e3f2fd;
			padding: 10px;
			border-radius: 5px;
			margin-top: 10px;
			font-size: 0.9em;
		}
		.file-upload-info {
			background: #e3f2fd;
			padding: 10px;
			border-radius: 5px;
			margin-top: 10px;
			font-size: 0.9em;
		}
		.user-checkbox-list {
			max-height: 200px;
			overflow-y: auto;
			border: 1px solid #ccc;
			padding: 10px;
			border-radius: 5px;
			background: white;
		}
		.user-checkbox-item {
			display: block;
			margin-bottom: 5px;
		}
		.user-checkbox-item input {
			margin-right: 10px;
		}
	</style>
</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1">
			<h4 class="title">Create Task </h4>
		   <form class="form-1"
			      method="POST"
			      action="app/add-task.php"
			      enctype="multipart/form-data">
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
					<input type="text" name="title" class="input-1" placeholder="Title" required><br>
				</div>
				<div class="input-holder">
					<lable>Description</lable>
					<textarea type="text" name="description" class="input-1" placeholder="Description" required></textarea><br>
				</div>
				
				<div class="input-holder">
					<lable>Task Type</lable>
					<select name="task_type" class="input-1" id="taskType" required>
						<option value="">Select Task Type</option>
						<option value="Teaching">Teaching</option>
						<option value="Research">Research</option>
						<option value="Administrative">Administrative</option>
						<option value="Establishment">Establishment</option>
					</select><br>
				</div>
				
				<div class="input-holder">
					<lable>Subtopic</lable>
					<input type="text" name="subtopic" class="input-1" placeholder="Enter subtopic details" required><br>
					<div class="subtopic-examples" id="subtopicHelp">
						Select a task type to see example subtopics
					</div>
				</div>
				
				<div class="input-holder">
					<lable>📎 Task Document (Optional)</lable>
					<input type="file" name="task_document" class="input-1" accept=".pdf,.doc,.docx"><br>
					<div class="file-upload-info">
						<i class="fa fa-info-circle"></i> Upload a detailed task description document (PDF/Word). 
						This will be available in the Faculty Repository for download. Max size: 5MB
					</div>
				</div>
				
				<div class="input-holder">
					<lable>Due Date</lable>
					<input type="date" name="due_date" class="input-1" placeholder="Due Date" required><br>
				</div>
				<div class="input-holder">
					<lable>Due Time</lable>
					<input type="time" name="due_time" class="input-1" placeholder="Due Time" required><br>
				</div>
				<div class="input-holder">
					<lable>Assigned to</lable>
					<div class="user-checkbox-list">
						<div class="user-checkbox-item" style="border-bottom: 1px solid #eee; padding-bottom: 5px; margin-bottom: 10px;">
							<input type="checkbox" id="selectAllUsers"> <strong>Select All Employees</strong>
						</div>
						<?php if ($users !=0) { 
							foreach ($users as $user) {
						?>
						<label class="user-checkbox-item">
							<input type="checkbox" name="assigned_to[]" value="<?=$user['id']?>" class="user-checkbox">
							<?=$user['full_name']?> (<?=$user['department']?>)
						</label>
						<?php } } ?>
					</div>
				</div>
				
				<div class="input-holder">
					<lable>Verifier (Optional)</lable>
					<select name="verified_by" class="input-1">
						<option value="">Select Verifier</option>
						<?php if ($users !=0) { 
							foreach ($users as $user) {
						?>
                  <option value="<?=$user['id']?>"><?=$user['full_name']?> (<?=$user['department']?>)</option>
						<?php } } ?>
					</select><br>
					<small style="color: #666;">Select a faculty member to verify this task upon completion.</small>
				</div>
				<button class="btn-primary">
					<i class="fa fa-plus-circle"></i> Create Task
				</button>
			</form>
			
		</section>
	</div>

<script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(3)");
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

	// Select All functionality
	document.getElementById('selectAllUsers').addEventListener('change', function() {
		const checkboxes = document.querySelectorAll('.user-checkbox');
		checkboxes.forEach(cb => cb.checked = this.checked);
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