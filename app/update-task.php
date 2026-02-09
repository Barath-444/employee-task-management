<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

if (isset($_POST['id']) && isset($_POST['title']) && isset($_POST['description']) && isset($_POST['assigned_to']) && $_SESSION['role'] == 'admin'&& isset($_POST['due_date'])) {
	include "../DB_connection.php";

    function validate_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	$title = validate_input($_POST['title']);
	$description = validate_input($_POST['description']);
	$task_type = validate_input($_POST['task_type']);
	$subtopic = validate_input($_POST['subtopic']);
	$assigned_to = validate_input($_POST['assigned_to']);
	$id = validate_input($_POST['id']);
	$due_date = validate_input($_POST['due_date']);
	$due_time = validate_input($_POST['due_time']);

	// Combine date and time
	$due_datetime = $due_date . ' ' . $due_time . ':00';

	if (empty($title)) {
		$em = "Title is required";
	    header("Location: ../edit-task.php?error=$em&id=$id");
	    exit();
	}else if (empty($description)) {
		$em = "Description is required";
	    header("Location: ../edit-task.php?error=$em&id=$id");
	    exit();
	}else if (empty($task_type)) {
		$em = "Task type is required";
	    header("Location: ../edit-task.php?error=$em&id=$id");
	    exit();
	}else if (empty($subtopic)) {
		$em = "Subtopic is required";
	    header("Location: ../edit-task.php?error=$em&id=$id");
	    exit();
	}else if ($assigned_to == 0) {
		$em = "Select User";
	    header("Location: ../edit-task.php?error=$em&id=$id");
	    exit();
	}else {
    
       include "Model/Task.php";

       $data = array($title, $description, $task_type, $subtopic, $assigned_to, $due_datetime, $id);
       update_task($conn, $data);

       $em = "Task updated successfully";
	    header("Location: ../edit-task.php?success=$em&id=$id");
	    exit();

    
	}
}else {
   $em = "Unknown error occurred";
   header("Location: ../edit-task.php?error=$em");
   exit();
}

}else{ 
   $em = "First login";
   header("Location: ../login.php?error=$em");
   exit();
}
?>