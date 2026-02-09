<?php  

function get_all_my_notifications($conn, $id){
	$sql = "SELECT * FROM notifications WHERE recipient=? ORDER BY id DESC";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);

	if($stmt->rowCount() > 0){
		$notifications = $stmt->fetchAll();
	}else $notifications = 0;

	return $notifications;
}


function count_notification($conn, $id){
	$sql = "SELECT id FROM notifications WHERE recipient=? AND is_read=0";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);

	return $stmt->rowCount();
}

function insert_notification($conn, $data){
	$sql = "INSERT INTO notifications (message, recipient, type, date) VALUES(?,?,?, NOW())";
	$stmt = $conn->prepare($sql);
	$stmt->execute($data);
}

function notification_make_read($conn, $recipient_id, $notification_id){
	$sql = "UPDATE notifications SET is_read=1 WHERE id=? AND recipient=?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$notification_id, $recipient_id]);
}

function check_and_send_reminders($conn, $user_id){
	// Get tasks due in next 15 minutes that are not completed
	// We want tasks where due_date is BETWEEN NOW() AND NOW() + 15 MIN
	$sql = "SELECT id, title, due_date FROM tasks 
			WHERE assigned_to = ? 
			AND status != 'completed' 
			AND due_date > NOW() 
			AND due_date <= DATE_ADD(NOW(), INTERVAL 15 MINUTE)";
	
	$stmt = $conn->prepare($sql);
	$stmt->execute([$user_id]);
	
	if($stmt->rowCount() > 0){
		$tasks = $stmt->fetchAll();
		
		foreach($tasks as $task){
			$message = "Task '{$task['title']}' is due in less than 15 minutes!";
			$type = "Deadline Alert";
			
			// Check if we already sent this notification to avoid spamming
			// We check if a notification with this exact message exists for this user
			$check_sql = "SELECT id FROM notifications WHERE recipient = ? AND message = ? AND type = ?";
			$check_stmt = $conn->prepare($check_sql);
			$check_stmt->execute([$user_id, $message, $type]);
			
			if($check_stmt->rowCount() == 0){
				insert_notification($conn, array($message, $user_id, $type));
			}
		}
	}
}