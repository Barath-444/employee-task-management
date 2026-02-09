<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/User.php";
    
    $text = "All Task";
    
    // Filter by task type
    if (isset($_GET['task_type']) && !empty($_GET['task_type'])) {
        $text = $_GET['task_type'] . " Tasks";
        $tasks = get_tasks_by_type($conn, $_GET['task_type']);
        $num_task = count_tasks_by_type($conn, $_GET['task_type']);
    }
    // Filter by due date
    else if (isset($_GET['due_date']) &&  $_GET['due_date'] == "Due Today") {
    	$text = "Due Today";
      $tasks = get_all_tasks_due_today($conn);
      $num_task = count_tasks_due_today($conn);

    }else if (isset($_GET['due_date']) &&  $_GET['due_date'] == "Overdue") {
    	$text = "Overdue";
      $tasks = get_all_tasks_overdue($conn);
      $num_task = count_tasks_overdue($conn);

    }else if (isset($_GET['due_date']) &&  $_GET['due_date'] == "No Deadline") {
    	$text = "No Deadline";
      $tasks = get_all_tasks_NoDeadline($conn);
      $num_task = count_tasks_NoDeadline($conn);

    }else if (isset($_GET['status']) && !empty($_GET['status'])) {
    	$text = ucwords(str_replace('_', ' ', $_GET['status']));
      $tasks = get_tasks_by_status($conn, $_GET['status']);
      $num_task = count_tasks_by_status($conn, $_GET['status']);

    }else{
    	 $tasks = get_all_tasks($conn);
       $num_task = count_tasks($conn);
    }
    $users = get_all_users($conn);
    

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>All Tasks</title>
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
				<a href="create_task.php" class="btn-primary">Create Task</a>
				<a href="tasks.php" class="filter-btn-all" style="margin-left: 20px;">All Tasks</a>
			</h4>
			
			<!-- Filter Options -->
			<div style="margin: 20px 0; display: flex; gap: 10px; flex-wrap: wrap;">
				<!-- Due Date Filters -->
				<div>
					<strong>Due Date:</strong>
					<a href="tasks.php?due_date=Due Today" class="filter-btn-all">Due Today</a>
					<a href="tasks.php?due_date=Overdue" class="filter-btn-all" style="background: #ef4444;">Overdue</a>
					<a href="tasks.php?due_date=No Deadline" class="filter-btn-all" style="background: #64748b;">No Deadline</a>
				</div>
				
				<!-- Task Type Filter -->
				<div style="margin-left: 20px;">
					<strong>Task Type:</strong>
					<a href="tasks.php?task_type=Teaching" class="filter-btn-teaching">Teaching</a>
					<a href="tasks.php?task_type=Research" class="filter-btn-research">Research</a>
					<a href="tasks.php?task_type=Administrative" class="filter-btn-administrative">Administrative</a>
					<a href="tasks.php?task_type=Establishment" class="filter-btn-establishment">Establishment</a>
				</div>
			</div>
			
         <h4 class="title-2"><?=$text?> (<?=$num_task?>)</h4>
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
					<th>Assigned To</th>
					<th>Department</th>
					<th>Due Date & Time</th>
					<th>Documents</th>
					<th>Status</th>
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
                  foreach ($users as $user) {
						if($user['id'] == $task['assigned_to']){
							echo $user['full_name'];
							break;
						}}?>
	            </td>
	            <td>
						<?php 
                  foreach ($users as $user) {
						if($user['id'] == $task['assigned_to']){
							echo $user['department'] ? $user['department'] : 'N/A';
							break;
						}}?>
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
						<i class="fa fa-file-pdf-o" style="color: #28a745;" title="Task document attached"></i>
					<?php } ?>
					
					<?php if ($has_ack_doc) { ?>
						<i class="fa fa-check-circle" style="color: #17a2b8;" title="Acknowledgment uploaded"></i>
					<?php } ?>
					
					<?php if (!$has_task_doc && !$has_ack_doc) { ?>
						<span style="color: #ccc;">-</span>
					<?php } ?>
				</td>
	            <td><?=$task['status']?></td>
					<td>
						<a href="view-task-status.php?id=<?=$task['id']?>" class="btn-primary" style="margin-bottom: 5px; font-size: 11px;">View Status</a>
						<a href="edit-task.php?id=<?=$task['id']?>" class="btn-edit" style="margin-bottom: 5px;">Edit</a>
						<a href="delete-task.php?id=<?=$task['id']?>" class="delete-btn">Delete</a>
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
	var active = document.querySelector("#navList li:nth-child(4)");
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