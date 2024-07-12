<?php
require_once 'connection.php';
session_start();


// upload image sebelum
if ($_SESSION['upload'] == 1) {
    $_SESSION['upload'] = 0;

    $filename = $_SESSION['filename'];
    $tugas_id = $_SESSION['tugas_id'];
    $sql = "INSERT INTO `image_tugas_harian`(`tugas_id`, `filename`, `status`) 
            VALUES ('$tugas_id','$filename',0)";
    mysqli_query($conn, $sql);
    header('Location: ../petugasInputSebelum.php');
} 

// GET list tugas harian untuk $lokasi
$lokasi = $_SESSION['lokasi'];
$sql = "SELECT id, details
        FROM tugas_harian 
        WHERE lokasi='$lokasi'";
$result1 = mysqli_query($conn, $sql);
if (!$result1) die('Error executing query: ' . mysqli_error($conn));


// GET id tugas dari $lokasi
$sql = "SELECT id
        FROM tugas_harian 
        WHERE lokasi='$lokasi'";
$result2 = mysqli_query($conn, $sql);
if (!$result2) die('Error executing query: ' . mysqli_error($conn));
$all_tugas_id = array();
while ($row = $result2->fetch_assoc()) {
    array_push($all_tugas_id, $row['id']);
}
$string_version = implode(',', $all_tugas_id);


// GET image tugas harian yg sudah di upload
$sql = "SELECT tugas_id, filename, date_format(created_at, '%H:%i') as 'created_at'
        FROM image_tugas_harian 
        WHERE tugas_id IN ($string_version) AND status = 0";
$tugas_images = mysqli_query($conn, $sql);
if (!$tugas_images) die('Error executing query: ' . mysqli_error($conn));
$_SESSION['tugas_images'] = mysqli_fetch_all($tugas_images);


if (mysqli_num_rows($result1) > 2) {
    $_SESSION['tugasList'] =  mysqli_fetch_all($result1);
    header('Location: ../petugasInputSebelum.php');
} else {
    echo "<script>alert('User Tidak Valid')</script>";
}

