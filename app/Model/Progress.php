<?php

// Get all progress for a specific task
function get_task_progress($conn, $task_id) {
    $sql = "SELECT tp.*, u.full_name, u.role 
            FROM task_progress tp
            JOIN users u ON tp.user_id = u.id
            WHERE tp.task_id = ?
            ORDER BY tp.created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$task_id]);
    
    if ($stmt->rowCount() > 0) {
        return $stmt->fetchAll();
    }
    return 0;
}

// Add progress (faculty or admin follow-up)
function add_progress($conn, $data) {
    $sql = "INSERT INTO task_progress (task_id, user_id, progress_type, message) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
    return 1;
}

// Get latest progress for a task
function get_latest_progress($conn, $task_id) {
    $sql = "SELECT tp.*, u.full_name 
            FROM task_progress tp
            JOIN users u ON tp.user_id = u.id
            WHERE tp.task_id = ?
            ORDER BY tp.created_at DESC
            LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$task_id]);
    
    if ($stmt->rowCount() == 1) {
        return $stmt->fetch();
    }
    return 0;
}

// Count progress entries for a task
function count_progress($conn, $task_id) {
    $sql = "SELECT COUNT(*) as total FROM task_progress WHERE task_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$task_id]);
    $result = $stmt->fetch();
    return $result['total'];
}