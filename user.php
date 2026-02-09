<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/User.php";

    // Check if filtering by department
    if (isset($_GET['department']) && !empty($_GET['department'])) {
        $users = get_users_by_department($conn, $_GET['department']);
        $filter_text = "Department: " . $_GET['department'];
    } else {
        $users = get_all_users($conn);
        $filter_text = "All Departments";
    }
    
    // Get all unique departments for filter dropdown
    $departments = get_all_departments($conn);
  
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Manage Users</title>
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
				<a href="add-user.php" class="btn">Add User</a>
				<a href="user.php">All Users</a>
			</h4>
			
			<!-- Department Filter -->
			<div style="margin: 20px 0;">
				<form method="GET" action="user.php" style="display: inline-block;">
					<select name="department" class="input-1" style="width: 250px; display: inline-block;" onchange="this.form.submit()">
						<option value="">-- Filter by Department --</option>
						<?php if ($departments != 0) { 
							foreach ($departments as $dept) { 
								$selected = (isset($_GET['department']) && $_GET['department'] == $dept['department']) ? 'selected' : '';
						?>
							<option value="<?=$dept['department']?>" <?=$selected?>><?=$dept['department']?></option>
						<?php } } ?>
					</select>
				</form>
				<?php if (isset($_GET['department'])) { ?>
					<a href="user.php" class="btn" style="margin-left: 10px;">Clear Filter</a>
				<?php } ?>
			</div>
			
			<h4 class="title-2"><?=$filter_text?></h4>
			
			<?php if (isset($_GET['success'])) {?>
      	  	<div class="success" role="alert">
			  <?php echo stripcslashes($_GET['success']); ?>
			</div>
		<?php } ?>
			<?php if ($users != 0) { ?>
			<table class="main-table">
				<tr>
					<th>#</th>
					<th>Full Name</th>
					<th>Username</th>
					<th>Department</th>
					<th>Role</th>
					<th>Action</th>
				</tr>
				<?php $i=0; foreach ($users as $user) { ?>
				<tr>
					<td><?=++$i?></td>
					<td><?=$user['full_name']?></td>
					<td><?=$user['username']?></td>
					<td><?=$user['department'] ? $user['department'] : 'N/A'?></td>
					<td><?=$user['role']?></td>
					<td>
						<a href="edit-user.php?id=<?=$user['id']?>" class="btn-edit">Edit</a>
						<a href="delete-user.php?id=<?=$user['id']?>" class="delete-btn">Delete</a>
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