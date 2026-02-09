<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

if (isset($_POST['task_id']) && isset($_POST['progress_message'])) {
	include "../DB_connection.php";

    function validate_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	$task_id = validate_input($_POST['task_id']);
	$progress_message = validate_input($_POST['progress_message']);
	$user_id = $_SESSION['id'];

	if (empty($progress_message)) {
		$em = "Progress message is required";
	    header("Location: ../task-progress.php?error=$em&id=$task_id");
	    exit();
	}else {
    
       include "Model/Progress.php";

       $data = array($task_id, $user_id, 'faculty_progress', $progress_message);
       add_progress($conn, $data);

       $em = "Progress added successfully";
	    header("Location: ../task-progress.php?success=$em&id=$task_id");
	    exit();
	}
}else {
   $em = "Unknown error occurred";
   header("Location: ../my_task.php?error=$em");
   exit();
}

}else{ 
   $em = "First login";
   header("Location: ../login.php?error=$em");
   exit();
}