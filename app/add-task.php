<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['assigned_to']) && $_SESSION['role'] == 'admin' && isset($_POST['due_date'])) {
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
	$assigned_to = $_POST['assigned_to']; // DO NOT validate_input for arrays!
	$due_date = validate_input($_POST['due_date']);
	$due_time = validate_input($_POST['due_time']);
	
	// Handle optional verifier
	$verified_by = null;
	if(isset($_POST['verified_by']) && !empty($_POST['verified_by'])){
		$verified_by = validate_input($_POST['verified_by']);
	}

	// Combine date and time
	$due_datetime = $due_date . ' ' . $due_time . ':00';

	if (empty($title)) {
		$em = "Title is required";
	    header("Location: ../create_task.php?error=$em");
	    exit();
	}else if (empty($description)) {
		$em = "Description is required";
	    header("Location: ../create_task.php?error=$em");
	    exit();
	}else if (empty($task_type)) {
		$em = "Task type is required";
	    header("Location: ../create_task.php?error=$em");
	    exit();
	}else if (empty($subtopic)) {
		$em = "Subtopic is required";
	    header("Location: ../create_task.php?error=$em");
	    exit();
	}else if (empty($assigned_to) || !is_array($assigned_to)) {
		$em = "Select at least one user";
	    header("Location: ../create_task.php?error=$em");
	    exit();
	}else {
    
       include "Model/Task.php";
       include "Model/Notification.php";

       // Handle file upload
       $task_document = null;
       if (isset($_FILES['task_document']) && $_FILES['task_document']['error'] == 0) {
           $allowed = ['pdf', 'doc', 'docx'];
           $file_name = $_FILES['task_document']['name'];
           $file_size = $_FILES['task_document']['size'];
           $file_tmp = $_FILES['task_document']['tmp_name'];
           $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

           if (!in_array($file_ext, $allowed)) {
               $em = "Only PDF, DOC, and DOCX files are allowed";
               header("Location: ../create_task.php?error=$em");
               exit();
           }

           if ($file_size > 5242880) { // 5MB
               $em = "File size must be less than 5MB";
               header("Location: ../create_task.php?error=$em");
               exit();
           }

           // Generate unique filename
           $new_file_name = uniqid('task_', true) . '.' . $file_ext;
           $upload_path = "../uploads/task_documents/" . $new_file_name;

           if (move_uploaded_file($file_tmp, $upload_path)) {
               $task_document = $new_file_name;
           } else {
               $em = "Failed to upload file";
               header("Location: ../create_task.php?error=$em");
               exit();
           }
       }

       // Loop through assigned users and create task for each
       foreach ($assigned_to as $user_id) {
           $user_id = validate_input($user_id); // Validate individual user ID
           
	       $data = array($title, $description, $task_type, $subtopic, $task_document, $user_id, $due_datetime, $verified_by);
	       insert_task($conn, $data);
	
	       $notif_data = array("'$title' has been assigned to you. Please review and start working on it", $user_id, 'New Task Assigned');
	       insert_notification($conn, $notif_data);
       }


       $em = "Task created successfully for " . count($assigned_to) . " user(s)";
	    header("Location: ../create_task.php?success=$em");
	    exit();

    
	}
}else {
   $em = "Unknown error occurred";
   header("Location: ../create_task.php?error=$em");
   exit();
}

}else{ 
   $em = "First login";
   header("Location: ../create_task.php?error=$em");
   exit();
}
?>