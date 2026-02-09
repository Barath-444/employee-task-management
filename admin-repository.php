<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/User.php";
    
    // Get filter
    $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
    
    if ($filter == 'task_documents') {
        $tasks = get_tasks_with_documents($conn);
        $title = "Task Documents (Uploaded by Admin)";
    } elseif ($filter == 'acknowledgments') {
        $tasks = get_tasks_with_acknowledgments($conn);
        $title = "Acknowledgments (Uploaded by Faculty)";
    } else {
        $all_tasks = get_all_tasks($conn);
        $tasks = $all_tasks;
        $title = "All Tasks Repository";
    }
    
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Repository</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
	<style>
		.doc-badge {
			background: #28a745;
			color: white;
			padding: 3px 8px;
			border-radius: 3px;
			font-size: 0.85em;
			margin-left: 5px;
		}
		.ack-badge {
			background: #17a2b8;
			color: white;
			padding: 3px 8px;
			border-radius: 3px;
			font-size: 0.85em;
			margin-left: 5px;
		}
		.filter-tabs {
			margin: 20px 0;
			display: flex;
			gap: 10px;
		}
		.filter-tab {
			padding: 10px 20px;
			background: #f0f0f0;
			border-radius: 5px;
			text-decoration: none;
			color: #333;
		}
		.filter-tab.active {
			background: #007bff;
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
			<h4 class="title">📁 Admin Repository</h4>
			
			<!-- Filter Tabs -->
			<div class="filter-tabs">
				<a href="admin-repository.php?filter=all" class="filter-tab <?=$filter=='all'?'active':''?>">
					<i class="fa fa-list"></i> All Tasks
				</a>
				<a href="admin-repository.php?filter=task_documents" class="filter-tab <?=$filter=='task_documents'?'active':''?>">
					<i class="fa fa-file-pdf-o"></i> Task Documents
				</a>
				<a href="admin-repository.php?filter=acknowledgments" class="filter-tab <?=$filter=='acknowledgments'?'active':''?>">
					<i class="fa fa-check-circle"></i> Acknowledgments
				</a>
			</div>
			
			<h4 class="title-2"><?=$title?></h4>
			
			<?php if (isset($_GET['success'])) {?>
      	  	<div class="success" role="alert">
			  <?php echo stripcslashes($_GET['success']); ?>
			</div>
		<?php } ?>
		
			<?php if ($tasks != 0) { ?>
			<table class="main-table">
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>Task Type</th>
					<th>Assigned To</th>
					<th>Department</th>
					<th>Due Date</th>
					<th>Task Document</th>
					<th>Acknowledgment</th>
					<th>Action</th>
				</tr>
				<?php $i=0; foreach ($tasks as $task) { 
					$user = get_user_by_id($conn, $task['assigned_to']);
				?>
				<tr>
					<td><?=++$i?></td>
					<td><?=$task['title']?></td>
					<td>
						<?php 
							$type_class = ($task['task_type'] == 'Verification') ? 'badge-verification' : '';
						?>
						<span class="badge-type <?=$type_class?>"><?=$task['task_type']?></span>
					</td>
					<td><?=$user ? $user['full_name'] : 'N/A'?></td>
					<td><?=$user ? $user['department'] : 'N/A'?></td>
					<td><?=date('M d, Y h:i A', strtotime($task['due_date']))?></td>
					<td>
						<?php if ($task['task_document']) { ?>
							<a href="app/download-document.php?file=<?=$task['task_document']?>&type=task" class="btn" style="background: #28a745; font-size: 0.85em;">
								<i class="fa fa-download"></i> Download
							</a>
						<?php } else { ?>
							<span style="color: #999;">No document</span>
						<?php } ?>
					</td>
					<td>
						<?php if ($task['acknowledgment_document']) { ?>
							<a href="app/download-document.php?file=<?=$task['acknowledgment_document']?>&type=ack" class="btn" style="background: #17a2b8; font-size: 0.85em;">
								<i class="fa fa-download"></i> Download
							</a>
							<br><small style="color: #666;">Uploaded: <?=date('M d, Y', strtotime($task['acknowledgment_uploaded_at']))?></small>
						<?php } else { ?>
							<span style="color: #999;">Not uploaded</span>
						<?php } ?>
					</td>
					<td>
						<a href="edit-task.php?id=<?=$task['id']?>" class="btn-edit">View Task</a>
					</td>
				</tr>
			   <?php	} ?>
			</table>
		<?php }else { ?>
			<h3>Empty</h3>
		<?php  }?>
			
		</section>
	</div>

<script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(5)");
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