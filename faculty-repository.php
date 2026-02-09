<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    include "DB_connection.php";
    include "app/Model/Task.php";
    
    $tasks = get_faculty_tasks_with_documents($conn, $_SESSION['id']);
    
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>My Repository</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
	<style>
		.upload-form {
			background: #f8f9fa;
			padding: 15px;
			border-radius: 5px;
			margin-top: 10px;
		}
		.status-badge {
			padding: 5px 10px;
			border-radius: 3px;
			font-size: 0.85em;
			font-weight: bold;
		}
		.status-pending {
			background: #ffc107;
			color: #333;
		}
		.status-uploaded {
			background: #28a745;
			color: white;
		}
	</style>
</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1">
			<h4 class="title">📁 My Repository - Task Documents</h4>
			
			<?php if (isset($_GET['success'])) {?>
      	  	<div class="success" role="alert">
			  <?php echo stripcslashes($_GET['success']); ?>
			</div>
		<?php } ?>
		
		<?php if (isset($_GET['error'])) {?>
      	  	<div class="danger" role="alert">
			  <?php echo stripcslashes($_GET['error']); ?>
			</div>
		<?php } ?>
		
			<?php if ($tasks != 0) { ?>
			<table class="main-table">
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>Task Type</th>
					<th>Subtopic</th>
					<th>Due Date</th>
					<th>Task Document</th>
					<th>Acknowledgment Status</th>
					<th>Upload Acknowledgment</th>
				</tr>
				<?php $i=0; foreach ($tasks as $task) { ?>
				<tr>
					<td><?=++$i?></td>
					<td><?=$task['title']?></td>
					<td>
						<?php 
							$type_class = ($task['task_type'] == 'Verification') ? 'badge-verification' : '';
						?>
						<span class="badge-type <?=$type_class?>"><?=$task['task_type']?></span>
					</td>
					<td><?=$task['subtopic']?></td>
					<td>
						<?php 
						if (empty($task['due_date'])) {
							echo "No Deadline";
						} else {
							echo date('M d, Y h:i A', strtotime($task['due_date']));
						}
						?>
					</td>
					<td>
						<?php 
							$download_type = ($task['task_type'] == 'Verification') ? 'ack' : 'task';
						?>
						<a href="app/download-document.php?file=<?=$task['task_document']?>&type=<?=$download_type?>" class="btn" style="background: #28a745;">
							<i class="fa fa-download"></i> Download
						</a>
					</td>
					<td>
						<?php if ($task['acknowledgment_document']) { ?>
							<span class="status-badge status-uploaded">
								<i class="fa fa-check-circle"></i> Uploaded
							</span>
							<br><small>on <?=date('M d, Y', strtotime($task['acknowledgment_uploaded_at']))?></small>
							<br><a href="app/download-document.php?file=<?=$task['acknowledgment_document']?>&type=ack" style="font-size: 0.85em;">
								<i class="fa fa-download"></i> Download
							</a>
						<?php } else { ?>
							<span class="status-badge status-pending">
								<i class="fa fa-clock-o"></i> Pending
							</span>
						<?php } ?>
					</td>
					<td>
						<?php if (!$task['acknowledgment_document']) { ?>
							<form method="POST" action="app/upload-acknowledgment.php" enctype="multipart/form-data" class="upload-form">
								<input type="file" name="acknowledgment" accept=".pdf,.doc,.docx" required style="font-size: 0.85em; margin-bottom: 10px;">
								<input type="hidden" name="task_id" value="<?=$task['id']?>">
								<button type="submit" class="btn" style="background: #17a2b8; font-size: 0.85em;">
									<i class="fa fa-upload"></i> Upload
								</button>
							</form>
						<?php } else { ?>
							<span style="color: #28a745; font-size: 0.9em;">
								<i class="fa fa-check"></i> Already uploaded
							</span>
						<?php } ?>
					</td>
				</tr>
			   <?php	} ?>
			</table>
		<?php }else { ?>
			<h3>No tasks with documents found</h3>
			<p>Tasks with attached documents from your HoD will appear here.</p>
		<?php  }?>
			
		</section>
	</div>

<script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(3)");
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