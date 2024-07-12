<?php
session_start();
include 'conn.php';

// Update logout time in the database
date_default_timezone_set('Asia/Dhaka');
$logout_time = date("Y-m-d h:i:s");
$id = $_SESSION["id"];
$time_log = $_SESSION["time"];
mysqli_query($con, "UPDATE emp_history SET logout_date_time='$logout_time' WHERE id='$id' AND log_date_time='$time_log'");

// Unset all session variables
$_SESSION = array();

// Destroy the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Redirect to login page
header("location: index.php");
exit;
?>
