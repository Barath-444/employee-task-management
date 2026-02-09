<?php
include __DIR__ . "/../DB_connection.php";

// Get current time
$now = date('Y-m-d H:i:s');

// Find tasks with due date in next 15 minutes
$fifteen_min_later = date('Y-m-d H:i:s', strtotime('+15 minutes'));

$sql = "SELECT t.*, u.full_name, u.id as user_id 
        FROM tasks t 
        JOIN users u ON t.assigned_to = u.id 
        WHERE t.due_date BETWEEN ? AND ? 
        AND t.status != 'completed'
        AND NOT EXISTS (
            SELECT 1 FROM notifications n 
            WHERE n.recipient = u.id 
            AND n.message LIKE CONCAT('%', t.title, '%15 minutes%')
            AND DATE(n.date) = DATE(NOW())
        )";

$stmt = $conn->prepare($sql);
$stmt->execute([$now, $fifteen_min_later]);
$tasks = $stmt->fetchAll();

// Send 15-minute reminders
foreach ($tasks as $task) {
    $message = "Reminder: '{$task['title']}' is due in 15 minutes at " . date('h:i A', strtotime($task['due_date']));
    
    $insert_sql = "INSERT INTO notifications (message, recipient, type, date, is_read) 
                   VALUES (?, ?, 'Task Reminder', NOW(), 0)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->execute([$message, $task['user_id']]);
}

// Daily reminders for upcoming tasks (once per day at 9 AM)
$current_hour = date('H');
if ($current_hour == 9) {
    $tomorrow = date('Y-m-d', strtotime('+1 day'));
    $tomorrow_end = date('Y-m-d 23:59:59', strtotime('+1 day'));
    
    $daily_sql = "SELECT t.*, u.full_name, u.id as user_id 
                  FROM tasks t 
                  JOIN users u ON t.assigned_to = u.id 
                  WHERE t.due_date BETWEEN ? AND ? 
                  AND t.status != 'completed'
                  AND NOT EXISTS (
                      SELECT 1 FROM notifications n 
                      WHERE n.recipient = u.id 
                      AND n.message LIKE CONCAT('%', t.title, '%daily reminder%')
                      AND DATE(n.date) = DATE(NOW())
                  )";
    
    $daily_stmt = $conn->prepare($daily_sql);
    $daily_stmt->execute([$tomorrow, $tomorrow_end]);
    $daily_tasks = $daily_stmt->fetchAll();
    
    foreach ($daily_tasks as $task) {
        $message = "Daily Reminder: '{$task['title']}' is due tomorrow at " . date('h:i A', strtotime($task['due_date']));
        
        $insert_sql = "INSERT INTO notifications (message, recipient, type, date, is_read) 
                       VALUES (?, ?, 'Daily Task Reminder', NOW(), 0)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->execute([$message, $task['user_id']]);
    }
}

echo "Reminders sent successfully\n";
?>