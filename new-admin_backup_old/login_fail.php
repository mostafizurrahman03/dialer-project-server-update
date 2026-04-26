<?php
// Add this to admin.php where login fails
$ip = $_SERVER['REMOTE_ADDR'];
$log_entry = date('Y-m-d H:i:s') . " - Failed login from IP: $ip\n";
file_put_contents('/var/log/vicidial_login_fails.log', $log_entry, FILE_APPEND);
?>
