<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) ) {

	 include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/User.php";

	if ($_SESSION['role'] == "admin") {
		  $todaydue_task = count_tasks_due_today($conn);
	     $overdue_task = count_tasks_overdue($conn);
	     $nodeadline_task = count_tasks_NoDeadline($conn);
	     $num_task = count_tasks($conn);
	     $num_users = count_users($conn);
	     $pending = count_pending_tasks($conn);
	     $in_progress = count_in_progress_tasks($conn);
	     $completed = count_completed_tasks($conn);
	}else {
        $num_my_task = count_my_tasks($conn, $_SESSION['id']);
        $overdue_task = count_my_tasks_overdue($conn, $_SESSION['id']);
        $nodeadline_task = count_my_tasks_NoDeadline($conn, $_SESSION['id']);
        $pending = count_my_pending_tasks($conn, $_SESSION['id']);
	     $in_progress = count_my_in_progress_tasks($conn, $_SESSION['id']);
	     $completed = count_my_completed_tasks($conn, $_SESSION['id']);

	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1">
			<?php if ($_SESSION['role'] == "admin") { ?>
				<div class="dashboard">
					<a href="user.php" style="text-decoration: none; color: inherit;">
					<div class="dashboard-item">
						<i class="fa fa-users"></i>
						<span><?=$num_users?> Employee</span>
					</div>
					</a>
					<a href="tasks.php" style="text-decoration: none; color: inherit;">
					<div class="dashboard-item">
						<i class="fa fa-tasks"></i>
						<span><?=$num_task?> All Tasks</span>
					</div>
					</a>
					<a href="tasks.php?due_date=Overdue" style="text-decoration: none; color: inherit;">
					<div class="dashboard-item">
						<i class="fa fa-window-close-o"></i>
						<span><?=$overdue_task?> Overdue</span>
					</div>
					</a>
					<a href="tasks.php?due_date=No Deadline" style="text-decoration: none; color: inherit;">
					<div class="dashboard-item">
						<i class="fa fa-clock-o"></i>
						<span><?=$nodeadline_task?> No Deadline</span>
					</div>
					</a>
					<a href="tasks.php?due_date=Due Today" style="text-decoration: none; color: inherit;">
					<div class="dashboard-item">
						<i class="fa fa-exclamation-triangle"></i>
						<span><?=$todaydue_task?> Due Today</span>
					</div>
					</a>
					<a href="notifications.php" style="text-decoration: none; color: inherit;">
					<div class="dashboard-item">
						<i class="fa fa-bell"></i>
						<span><?=$overdue_task?> Notifications</span>
					</div>
					</a>
					<a href="tasks.php?status=pending" style="text-decoration: none; color: inherit;">
					<div class="dashboard-item">
						<i class="fa fa-square-o"></i>
						<span><?=$pending?> Pending</span>
					</div>
					</a>
					<a href="tasks.php?status=in_progress" style="text-decoration: none; color: inherit;">
					<div class="dashboard-item">
						<i class="fa fa-spinner"></i>
						<span><?=$in_progress?> In progress</span>
					</div>
					</a>
					<a href="tasks.php?status=completed" style="text-decoration: none; color: inherit;">
					<div class="dashboard-item">
						<i class="fa fa-check-square-o"></i>
						<span><?=$completed?> Completed</span>
					</div>
					</a>
				</div>
			<?php }else{ ?>
				<div class="dashboard">
					<a href="my_task.php" style="text-decoration: none; color: inherit;">
					<div class="dashboard-item">
						<i class="fa fa-tasks"></i>
						<span><?=$num_my_task?> My Tasks</span>
					</div>
					</a>
					<a href="my_task.php?due_date=Overdue" style="text-decoration: none; color: inherit;">
					<div class="dashboard-item">
						<i class="fa fa-window-close-o"></i>
						<span><?=$overdue_task?> Overdue</span>
					</div>
					</a>
					<a href="my_task.php?due_date=No Deadline" style="text-decoration: none; color: inherit;">
					<div class="dashboard-item">
						<i class="fa fa-clock-o"></i>
						<span><?=$nodeadline_task?> No Deadline</span>
					</div>
					</a>
					<a href="my_task.php?status=pending" style="text-decoration: none; color: inherit;">
					<div class="dashboard-item">
						<i class="fa fa-square-o"></i>
						<span><?=$pending?> Pending</span>
					</div>
					</a>
					<a href="my_task.php?status=in_progress" style="text-decoration: none; color: inherit;">
					<div class="dashboard-item">
						<i class="fa fa-spinner"></i>
						<span><?=$in_progress?> In progress</span>
					</div>
					</a>
					<a href="my_task.php?status=completed" style="text-decoration: none; color: inherit;">
					<div class="dashboard-item">
						<i class="fa fa-check-square-o"></i>
						<span><?=$completed?> Completed</span>
					</div>
					</a>
				</div>
			<?php } ?>
		</section>
	</div>

<script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(1)");
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