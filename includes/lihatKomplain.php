<?php
require_once 'connection.php';
session_start();

$komplain_id = $_SESSION['komplain_id'];
$followup = $_SESSION['filename'];
if (isset($_SESSION['upload']) && $_SESSION['upload'] == 1) {
    $_SESSION['upload'] = 0;
    $sql = "UPDATE komplain SET followup = '$followup', status = 0 WHERE id = $komplain_id";
    $insert_result = mysqli_query($conn, $sql);
}

// GET list tugas harian untuk $lokasi
$lokasi = $_SESSION['lokasi'];
$sql = "SELECT k.tugas_id, th.details, k.nama, 
            CASE 
                WHEN k.status = 0 THEN 'Bersih'
                WHEN k.status = 1 THEN 'Kurang Bersih'
                WHEN k.status = 2 THEN 'Kotor'
                END as statusBersih,
            k.catatan, k.filename, k.followup, date_format(created_at, '%H:%i') as 'created_at', k.id
        FROM komplain k 
            JOIN tugas_harian th ON k.tugas_id = th.id
        WHERE th.lokasi = '$lokasi'
        ORDER BY k.tugas_id;";
$result1 = mysqli_query($conn, $sql);
if (!$result1) die('Error executing query: ' . mysqli_error($conn));

$_SESSION['allKomplain'] =  mysqli_fetch_all($result1);
header('Location: ../lihatKomplain.php');
