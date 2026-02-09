<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

if (isset($_GET['file']) && isset($_GET['type'])) {
	$file = basename($_GET['file']); // Prevent directory traversal
	$type = $_GET['type'];
	
	$file_path = "";
	
	// Check in task_documents first (default location for manually created tasks)
	if (file_exists("../uploads/task_documents/" . $file)) {
		$file_path = "../uploads/task_documents/" . $file;
	} 
	// Check in acknowledgments (for auto-generated verification tasks)
	elseif (file_exists("../uploads/acknowledgments/" . $file)) {
		$file_path = "../uploads/acknowledgments/" . $file;
	} else {
		// Fallback to type-based check if file not found yet
		if ($type == 'task') {
			$file_path = "../uploads/task_documents/" . $file;
		} elseif ($type == 'ack') {
			$file_path = "../uploads/acknowledgments/" . $file;
		} else {
			die("Invalid file type");
		}
	}
	
	// Auto-complete tasks when verification document is downloaded
	if (file_exists($file_path)) {
		include "../DB_connection.php"; 
		include "Model/Task.php";
		include "Model/Notification.php";

		// 1. If downloaded file is an acknowledgment
		// Get task details first to notify admin
		$sql_check = "SELECT id, title, assigned_to FROM tasks WHERE acknowledgment_document=?";
		$stmt_check = $conn->prepare($sql_check);
		$stmt_check->execute([$file]);
		
		if($stmt_check->rowCount() > 0){
			$task = $stmt_check->fetch();
			
			// Update status
			$sql = "UPDATE tasks SET status='completed' WHERE acknowledgment_document=?";
			$stmt = $conn->prepare($sql);
			$stmt->execute([$file]);
			
			// Notify Admin
			$msg = "Task '{$task['title']}' has been completed by the assigned faculty.";
			insert_notification($conn, array($msg, 1, 'Task Completed'));
		}

		// 2. If the downloaded file is a task_document (for Verification Tasks)
		$sql_check2 = "SELECT id, title, assigned_to, verified_by FROM tasks WHERE task_document=? AND task_type='Verification'";
		$stmt_check2 = $conn->prepare($sql_check2);
		$stmt_check2->execute([$file]);
		
		if($stmt_check2->rowCount() > 0){
			$v_task = $stmt_check2->fetch();
			
			// Update status
			$sql2 = "UPDATE tasks SET status='completed' WHERE task_document=? AND task_type='Verification'";
			$stmt2 = $conn->prepare($sql2);
			$stmt2->execute([$file]);
			
			// Notify Admin
			$msg = "Verification Task '{$v_task['title']}' has been completed by the verifier.";
			insert_notification($conn, array($msg, 1, 'Verification Completed'));
		}


		// Set headers for download
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.basename($file_path).'"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file_path));
		
		// Clear output buffer
		ob_clean();
		flush();
		
		// Read file and output
		readfile($file_path);
		exit;
	} else {
		die("File not found");
	}

}else {
   die("Missing parameters");
}

}else{ 
   header("Location: ../login.php?error=Please login first");
   exit();
}
?>