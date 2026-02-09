<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

if (isset($_POST['task_id']) && isset($_FILES['acknowledgment'])) {
	include "../DB_connection.php";
	include "Model/Task.php";
	include "Model/Notification.php";

	$task_id = $_POST['task_id'];
	
	// Verify task belongs to this user
	$task = get_task_by_id($conn, $task_id);
	if ($task['assigned_to'] != $_SESSION['id']) {
		$em = "Unauthorized access";
	    header("Location: ../faculty-repository.php?error=$em");
	    exit();
	}

	// Handle file upload
	if ($_FILES['acknowledgment']['error'] == 0) {
		$allowed = ['pdf', 'doc', 'docx'];
		$file_name = $_FILES['acknowledgment']['name'];
		$file_size = $_FILES['acknowledgment']['size'];
		$file_tmp = $_FILES['acknowledgment']['tmp_name'];
		$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

		if (!in_array($file_ext, $allowed)) {
			$em = "Only PDF, DOC, and DOCX files are allowed";
			header("Location: ../faculty-repository.php?error=$em");
			exit();
		}

		if ($file_size > 5242880) { // 5MB
			$em = "File size must be less than 5MB";
			header("Location: ../faculty-repository.php?error=$em");
			exit();
		}

		// Generate unique filename
		$new_file_name = uniqid('ack_', true) . '.' . $file_ext;
		$upload_path = "../uploads/acknowledgments/" . $new_file_name;

		if (move_uploaded_file($file_tmp, $upload_path)) {
			// Update task with acknowledgment
			update_task_acknowledgment($conn, $task_id, $new_file_name);
			
			// Send notification to admin
			$notif_message = "Faculty has uploaded acknowledgment for task: '{$task['title']}'";
			$notif_data = array($notif_message, 1, 'Acknowledgment Uploaded'); // Assuming admin ID is 1
			insert_notification($conn, $notif_data);
			
			// Check if verifier is assigned and create verification task
			if (!empty($task['verified_by'])) {
                $verifier_id = $task['verified_by'];
                $verifier_sql = "SELECT full_name FROM users WHERE id = ?";
                $verifier_stmt = $conn->prepare($verifier_sql);
                $verifier_stmt->execute([$_SESSION['id']]); // Get current user's name
                $uploader_name = $verifier_stmt->fetchColumn();

                $verification_title = $task['title'];
                $verification_desc = "Verify task completion for: " . $task['description'];
                $verification_type = "Verification";
                $verification_subtopic = "Verification for " . $uploader_name;
                $verification_doc = $new_file_name; // Link the acknowledgment document
                $verification_due = null; // No deadline by default
                
                $v_data = array($verification_title, $verification_desc, $verification_type, $verification_subtopic, $verification_doc, $verifier_id, $verification_due, null);
                insert_task($conn, $v_data);
                
                // Notify Verifier
                $v_notif_msg = "New Verification Task: Verify completion of '{$task['title']}' by {$uploader_name}";
                $v_notif_data = array($v_notif_msg, $verifier_id, 'Verification Request');
                insert_notification($conn, $v_notif_data);
			}
			
			$em = "Acknowledgment uploaded successfully";
			header("Location: ../faculty-repository.php?success=$em");
			exit();
		} else {
			$em = "Failed to upload file";
			header("Location: ../faculty-repository.php?error=$em");
			exit();
		}
	} else {
		$em = "Please select a file";
		header("Location: ../faculty-repository.php?error=$em");
		exit();
	}

}else {
   $em = "Unknown error occurred";
   header("Location: ../faculty-repository.php?error=$em");
   exit();
}

}else{ 
   $em = "First login";
   header("Location: ../login.php?error=$em");
   exit();
}
?>