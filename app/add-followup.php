<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == 'admin') {

if (isset($_POST['task_id']) && isset($_POST['followup_message'])) {
	include "../DB_connection.php";

    function validate_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	$task_id = validate_input($_POST['task_id']);
	$followup_message = validate_input($_POST['followup_message']);
	$user_id = $_SESSION['id'];

	if (empty($followup_message)) {
		$em = "Follow-up message is required";
	    header("Location: ../edit-task.php?error=$em&id=$task_id");
	    exit();
	}else {
    
       include "Model/Progress.php";
       include "Model/Notification.php";
       include "Model/Task.php";

       // Add follow-up to progress table
       $data = array($task_id, $user_id, 'admin_followup', $followup_message);
       add_progress($conn, $data);

       // Get task details to send notification to assigned employee
       $task = get_task_by_id($conn, $task_id);
       
       // Send notification to assigned employee
       $notif_message = "Admin added a follow-up note on task: '{$task['title']}'";
       $notif_data = array($notif_message, $task['assigned_to'], 'Admin Follow-up');
       insert_notification($conn, $notif_data);

       $em = "Follow-up note added successfully";
	    header("Location: ../edit-task.php?success=$em&id=$task_id");
	    exit();
	}
}else {
   $em = "Unknown error occurred";
   header("Location: ../tasks.php?error=$em");
   exit();
}

}else{ 
   $em = "First login as admin";
   header("Location: ../login.php?error=$em");
   exit();
}
?>