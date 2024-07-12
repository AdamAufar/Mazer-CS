<?php
require_once 'connection.php';
session_start();

// $date = date('d/m/Y h:i:s', time());
$currentDate = date('Y-m-d', time());
$startDate = date(date('Y', time()) . '-' . date('m', time()) . '-01');
$lastDate = date("Y-m-t", strtotime($currentDate));

$id = $_SESSION['id'];
if (isset($_SESSION['filename'])) 
        $filename = $_SESSION['filename'];

if (isset($_SESSION['upload']) && $_SESSION['upload'] == 1) {
    $_SESSION['upload'] = 0;
    $sql = "INSERT INTO `absensi`(`user_id`, `filename`) VALUES ('$id','$filename')";
    $insert_result = mysqli_query($conn, $sql);
}

unset($_SESSION['absensi_image']);
$sql = "SELECT filename, absen_at
        FROM absensi 
        WHERE user_id = $id AND date_format(absen_at, '%Y-%m-%d') = '$currentDate'";
$absensi_image = mysqli_query($conn, $sql);
$_SESSION['absensi_image'] = mysqli_fetch_assoc($absensi_image);


$sql = "SELECT filename, 
               date_format(absen_at, '%Y-%m-%d') as date, 
               date_format(absen_at, '%h:%i:%s') as time
        FROM absensi 
        WHERE user_id = $id 
              AND date_format(absen_at, '%Y-%m-%d') BETWEEN '$startDate' AND '$currentDate'
        ORDER BY absen_at";
$all_absen = mysqli_query($conn, $sql);
$_SESSION['all_absen'] = mysqli_fetch_all($all_absen);
// print_r($_SESSION['all_absen']);


