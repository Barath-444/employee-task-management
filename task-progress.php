<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/Progress.php";
    
    if (!isset($_GET['id'])) {
    	 header("Location: my_task.php");
    	 exit();
    }
    $id = $_GET['id'];
    $task = get_task_by_id($conn, $id);

    if ($task == 0) {
    	 header("Location: my_task.php");
    	 exit();
    }
    
    // Get progress history
    $progress_history = get_task_progress($conn, $id);
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Task Progress</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
	<style>
		.progress-item {
			background: #f8f9fa;
			padding: 15px;
			margin-bottom: 15px;
			border-left: 4px solid #007bff;
			border-radius: 4px;
		}
		.progress-item.admin-followup {
			border-left-color: #28a745;
			background: #e8f5e9;
		}
		.progress-header {
			font-weight: bold;
			margin-bottom: 5px;
		}
		.progress-time {
			color: #666;
			font-size: 0.85em;
		}
	</style>
</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1">
			<h4 class="title">Task Progress: <?=$task['title']?> <a href="my_task.php">Back to My Tasks</a></h4>
			
			<!-- Add Progress Form -->
			<form class="form-1"
			      method="POST"
			      action="app/add-progress.php">
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
      	  
      	  <h5>Add Progress Update</h5>
				<div class="input-holder">
					<lable>Current Progress</lable>
					<textarea name="progress_message" rows="5" class="input-1" placeholder="Describe your current progress on this task..." required></textarea><br>
				</div>
				<input type="text" name="task_id" value="<?=$task['id']?>" hidden>
				<button class="btn-primary">Submit Progress</button>
			</form>
			
			<!-- Progress History -->
			<div style="margin-top: 40px;">
				<h5>Progress History</h5>
				<?php if ($progress_history != 0) { 
					foreach ($progress_history as $progress) { 
						$class = ($progress['progress_type'] == 'admin_followup') ? 'admin-followup' : '';
				?>
					<div class="progress-item <?=$class?>">
						<div class="progress-header">
							<?php if ($progress['progress_type'] == 'admin_followup') { ?>
								<i class="fa fa-user-md"></i> Admin Follow-up by <?=$progress['full_name']?>
							<?php } else { ?>
								<i class="fa fa-user"></i> Progress Update by <?=$progress['full_name']?>
							<?php } ?>
						</div>
						<div><?=$progress['message']?></div>
						<div class="progress-time">
							<i class="fa fa-clock-o"></i> <?=date('M d, Y h:i A', strtotime($progress['created_at']))?>
						</div>
					</div>
				<?php } 
				} else { ?>
					<p>No progress updates yet.</p>
				<?php } ?>
			</div>
			
		</section>
	</div>

<script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(2)");
	active.classList.add("active");
</script>
</body>
</html>
<?php }else{ 
   $em = "First login";
   header("Location: login.php?error=$em");
   exit();
}
 ?>