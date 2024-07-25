<?php 
require_once 'connection.php';
session_start();
$userid = $_SESSION['id'];
$sql = "UPDATE users SET status = 0 WHERE id = $userid";
print_r($sql);
$logout_q = mysqli_query($conn, $sql);

$lokasi = $_SESSION['lokasi'];
session_unset();
session_destroy();
header("Location: ../index.php?lokasi=$lokasi");
exit;
?>