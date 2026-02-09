<?php 

function get_all_users($conn){
	$sql = "SELECT * FROM users WHERE role =? ";
	$stmt = $conn->prepare($sql);
	$stmt->execute(["employee"]);

	if($stmt->rowCount() > 0){
		$users = $stmt->fetchAll();
	}else $users = 0;

	return $users;
}


function insert_user($conn, $data){
	$sql = "INSERT INTO users (full_name, username, password, role, department) VALUES(?,?,?,?,?)";
	$stmt = $conn->prepare($sql);
	$stmt->execute($data);
}

function update_user($conn, $data){
	$sql = "UPDATE users SET full_name=?, username=?, password=?, role=?, department=? WHERE id=? AND role=?";
	$stmt = $conn->prepare($sql);
	$stmt->execute($data);
}

function delete_user($conn, $data){
	$sql = "DELETE FROM users WHERE id=? AND role=?";
	$stmt = $conn->prepare($sql);
	$stmt->execute($data);
}


function get_user_by_id($conn, $id){
	$sql = "SELECT * FROM users WHERE id =? ";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);

	if($stmt->rowCount() > 0){
		$user = $stmt->fetch();
	}else $user = 0;

	return $user;
}

function update_profile($conn, $data){
	$sql = "UPDATE users SET full_name=?,  password=? WHERE id=? ";
	$stmt = $conn->prepare($sql);
	$stmt->execute($data);
}

function count_users($conn){
	$sql = "SELECT id FROM users WHERE role='employee'";
	$stmt = $conn->prepare($sql);
	$stmt->execute([]);

	return $stmt->rowCount();
}

// NEW FUNCTION - Get all departments
function get_all_departments($conn){
	$sql = "SELECT DISTINCT department FROM users WHERE department IS NOT NULL AND department != '' ORDER BY department";
	$stmt = $conn->prepare($sql);
	$stmt->execute([]);

	if($stmt->rowCount() > 0){
		$departments = $stmt->fetchAll();
	}else $departments = 0;

	return $departments;
}

// NEW FUNCTION - Get users by department
function get_users_by_department($conn, $department){
	$sql = "SELECT * FROM users WHERE role = 'employee' AND department = ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$department]);

	if($stmt->rowCount() > 0){
		$users = $stmt->fetchAll();
	}else $users = 0;

	return $users;
}