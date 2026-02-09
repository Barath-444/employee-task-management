<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/User.php";

    // Filter by task type if selected
    if (isset($_GET['task_type']) && !empty($_GET['task_type'])) {
        $tasks = get_tasks_by_user_and_type($conn, $_SESSION['id'], $_GET['task_type']);
        $filter_text = $_GET['task_type'] . " Tasks";
    } else if (isset($_GET['status']) && !empty($_GET['status'])) {
        $tasks = get_my_tasks_by_status($conn, $_SESSION['id'], $_GET['status']);
        $filter_text = ucwords(str_replace('_', ' ', $_GET['status'])) . " Tasks";
    } else {
        $tasks = get_all_tasks_by_id($conn, $_SESSION['id']);
        $filter_text = "All My Tasks";
    }

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>My Tasks</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1">
			<h4 class="title-2">
				My Tasks
				<a href="faculty-repository.php" class="btn" style="background: #17a2b8; margin-left: 20px;">
					<i class="fa fa-folder-open"></i> My Repository
				</a>
			</h4>
			
			<!-- Task Type Filter -->
			<div style="margin: 20px 0;">
				<strong>Filter by Type:</strong>
				<a href="my_task.php" class="filter-btn-all">All</a>
				<a href="my_task.php?task_type=Teaching" class="filter-btn-teaching">Teaching</a>
				<a href="my_task.php?task_type=Research" class="filter-btn-research">Research</a>
				<a href="my_task.php?task_type=Administrative" class="filter-btn-administrative">Administrative</a>
				<a href="my_task.php?task_type=Establishment" class="filter-btn-establishment">Establishment</a>
			</div>
			
			<h4 class="title-2"><?=$filter_text?></h4>
			
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
					<th>Description</th>
					<th>Task Type</th>
					<th>Subtopic</th>
					<th>Status</th>
					<th>Due Date & Time</th>
					<th>Documents</th>
					<th>Action</th>
				</tr>
				<?php $i=0; foreach ($tasks as $task) { ?>
				<tr>
					<td><?=++$i?></td>
					<td><?=$task['title']?></td>
					<td><?=$task['description']?></td>
					<td>
						<?php 
							$type_class = ($task['task_type'] == 'Verification') ? 'badge-verification' : '';
						?>
						<span class="badge-type <?=$type_class?>"><?=$task['task_type']?></span>
					</td>
					<td><?=$task['subtopic']?></td>
					<td>
						<?php 
						if (!empty($task['acknowledgment_document']) || !empty($task['task_document']) && $task['task_type'] == 'Verification') {
							echo "completed";
						} else {
							echo $task['status'];
						}
						?>
					</td>
	            <td><?php 
	                if($task['due_date'] == "" || $task['due_date'] == null) {
	                    echo "No Deadline";
	                } else {
	                    echo date('M d, Y h:i A', strtotime($task['due_date']));
	                }
	               ?></td>
	            <td>
					<?php 
					$has_task_doc = !empty($task['task_document']);
					$has_ack_doc = !empty($task['acknowledgment_document']);
					?>
					
					<?php if ($has_task_doc) { ?>
						<a href="faculty-repository.php" title="Go to Repository">
							<i class="fa fa-file-pdf-o" style="color: #28a745;"></i>
						</a>
					<?php } ?>
					
					<?php if ($has_ack_doc) { ?>
						<i class="fa fa-check-circle" style="color: #17a2b8;" title="Acknowledgment uploaded"></i>
					<?php } ?>
					
					<?php if (!$has_task_doc && !$has_ack_doc) { ?>
						<span style="color: #ccc;">-</span>
					<?php } ?>
	            </td>
				<td>
					<a href="edit-task-employee.php?id=<?=$task['id']?>" class="btn-edit">Edit</a>
					<a href="task-progress.php?id=<?=$task['id']?>" class="btn-primary">Progress</a>
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