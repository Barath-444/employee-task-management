<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    include "../DB_connection.php";
    include "Model/Notification.php";


    // Check for reminders before fetching notifications
    check_and_send_reminders($conn, $_SESSION['id']);

    $notifications = get_all_my_notifications($conn, $_SESSION['id']);
    if ($notifications == 0) { ?>
        <li>
        <a href="#">
            You have zero notification
        </a>
        </li>
       
    <?php }else{
    foreach ($notifications as $notification) {
 ?>
    <li>
    <a href="app/notification-read.php?notification_id=<?=$notification['id']?>">
        
        <?php 
        $type = $notification['type'];
        $message = $notification['message'];
        $date = $notification['date'];

        // Highlight Strategy:
        // 1. Highlight anything inside single quotes '...' (Task Titles)
        $message = preg_replace("/'([^']+)'/", "'<mark style='background: yellow;'>$1</mark>'", $message);

        // 2. Highlight words after "by " (Names) - e.g. "by barath"
        // We stop at the next space or end of string
        $message = preg_replace("/by\s+([a-zA-Z0-9_]+)/", "by <mark style='background: yellow;'>$1</mark>", $message);

        // Display Logic
        if ($notification['is_read'] == 0) {
            // Unread
            if($type == 'Deadline Alert'){
                echo "<strong style='color: red;'>$type: </strong>";
            } else {
                echo "<strong>$type: </strong>";
            }
        } else {
            // Read
             if($type == 'Deadline Alert'){
                 echo "<span style='color: red;'>$type: </span>";
            } else {
                 echo "$type: ";
            }
        }
        ?>
        
        <?=$message?>
        &nbsp;&nbsp;<small><?=$date?></small>
    </a>
    </li>
 <?php
 }
 }
}else{ 
  echo "";
}
 ?>