<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

if (isset($_POST['id']) && isset($_POST['status']) && $_SESSION['role'] == 'employee') {
	include "../DB_connection.php";

    function validate_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	$status = validate_input($_POST['status']);
	$id = validate_input($_POST['id']);

	if (empty($status)) {
		$em = "status is required";
	    header("Location: ../edit-task-employee.php?error=$em&id=$id");
	    exit();
	}else {
    
       include "Model/Task.php";
       include "Model/Notification.php";

       $data = array($status, $id);
       update_task_status($conn, $data);

       if ($status == 'completed') {
           // Notify Admin
           $task = get_task_by_id($conn, $id);
           $msg = "Task '{$task['title']}' has been marked as completed by the Assigned Person.";
           insert_notification($conn, array($msg, 1, 'Task Completed'));
       }

       $em = "Task updated successfully";
	    header("Location: ../edit-task-employee.php?success=$em&id=$id");
	    exit();

    
	}
}else {
   $em = "Unknown error occurred";
   header("Location: ../edit-task-employee.php?error=$em");
   exit();
}

}else{ 
   $em = "First login";
   header("Location: ../login.php?error=$em");
   exit();
}