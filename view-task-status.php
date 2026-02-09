<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/User.php";
    include "app/Model/Progress.php";
    
    if (!isset($_GET['id'])) {
        header("Location: tasks.php");
        exit();
    }
    $id = $_GET['id'];
    $task = get_task_by_id($conn, $id);

    if ($task == 0) {
        header("Location: tasks.php");
        exit();
    }
    $users = get_all_users($conn);
    
    // Get progress history for this task
    $progress_history = get_task_progress($conn, $id);
 ?>
<!DOCTYPE html>
<html>
<head>
    <title>Task Status</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .progress-section {
            margin-top: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .progress-item {
            background: #fff;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 4px solid #007bff;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .progress-item.admin-followup {
            border-left-color: #28a745;
            background: #e8f5e9;
        }
        .progress-header {
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }
        .progress-time {
            color: #666;
            font-size: 0.85em;
            margin-top: 8px;
        }
        .followup-form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .task-details {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .detail-row {
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .detail-label {
            font-weight: bold;
            color: #555;
            width: 150px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "inc/header.php" ?>
    <div class="body">
        <?php include "inc/nav.php" ?>
        <section class="section-1">
            <h4 class="title">Task Status <a href="tasks.php">Back to Tasks</a></h4>
            
            <div class="task-details">
                <div class="detail-row">
                    <span class="detail-label">Title:</span> <?=$task['title']?>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Description:</span> <?=$task['description']?>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Assigned To:</span> 
                    <?php 
                    foreach ($users as $user) {
                        if ($task['assigned_to'] == $user['id']) {
                            echo $user['full_name'] . " (" . $user['department'] . ")"; 
                        }
                    } 
                    ?>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status:</span> 
                    <span style="text-transform: capitalize; font-weight: bold; color: #007bff;"><?=$task['status']?></span>
                </div>
            </div>

            <!-- Progress & Follow-up Section -->
            <div class="progress-section">
                <h4>📊 Progress History & Follow-up Notes</h4>
                
                <!-- Progress History Display -->
                <?php if ($progress_history != 0) { 
                    foreach ($progress_history as $progress) { 
                        $class = ($progress['progress_type'] == 'admin_followup') ? 'admin-followup' : '';
                ?>
                    <div class="progress-item <?=$class?>">
                        <div class="progress-header">
                            <?php if ($progress['progress_type'] == 'admin_followup') { ?>
                                <i class="fa fa-user-md"></i> Admin Follow-up by <?=$progress['full_name']?>
                            <?php } else { ?>
                                <i class="fa fa-user"></i> Faculty Progress by <?=$progress['full_name']?>
                            <?php } ?>
                        </div>
                        <div><?=$progress['message']?></div>
                        <div class="progress-time">
                            <i class="fa fa-clock-o"></i> <?=date('M d, Y h:i A', strtotime($progress['created_at']))?>
                        </div>
                    </div>
                <?php } 
                } else { ?>
                    <p style="color: #666; font-style: italic;">No progress updates yet.</p>
                <?php } ?>
                
                <!-- Admin Follow-up Form -->
                <div class="followup-form">
                    <h5>✍️ Add Follow-up Note (Admin)</h5>
                    <form method="POST" action="app/add-followup.php">
                        <div class="input-holder">
                            <lable>Follow-up Message</lable>
                            <textarea name="followup_message" rows="4" class="input-1" placeholder="Add your follow-up notes or instructions for the faculty..." required></textarea><br>
                        </div>
                        <input type="text" name="task_id" value="<?=$task['id']?>" hidden>
						<button class="btn-primary">
							<i class="fa fa-comment"></i> Add Follow-up Note
						</button>
                    </form>
                </div>
            </div>
            
        </section>
    </div>

<script type="text/javascript">
    var active = document.querySelector("#navList li:nth-child(4)");
    active.classList.add("active");
</script>
</body>
</html>
<?php }else{ 
   $em = "First login";
   header("Location: login.php?error=$em");
   exit();
}
 ?>
