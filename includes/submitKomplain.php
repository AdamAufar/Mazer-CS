<?php
require_once 'connection.php';
session_start();

if ($_SESSION['upload'] == 1) {
    $_SESSION['upload'] = 0;

    $filename = $_SESSION['filename'];
    $tugas_id = $_SESSION['tugas_id_k'];
    $nama = $_SESSION['namaKaryawan'];
    $status = $_SESSION['cleanStatus'];
    $catatan = $_SESSION['cleanNote'];


    $sql = "INSERT INTO `komplain`(`nama`, `tugas_id`, `filename`, `status`, `catatan`) 
            VALUES ('$nama','$tugas_id','$filename','$status','$catatan')";
    mysqli_query($conn, $sql);
    header('Location: includes/userInput.php');
} 

$lokasi = $_SESSION['lokasi'];
$tugas_id = $_GET['tugas_id'];


$sql = "SELECT id, details
        FROM tugas_harian 
        WHERE id = $tugas_id";
$nama_tugas = mysqli_query($conn, $sql);
if (!$nama_tugas) die('Error executing query: ' . mysqli_error($conn));
$_SESSION['nama_tugas'] = mysqli_fetch_row($nama_tugas);
print_r($_SESSION['nama_tugas']);


// GET image sebelum
$sql = "SELECT filename
        FROM image_tugas_harian 
        WHERE tugas_id = $tugas_id AND status = 0";
$tugas_images_sebelum = mysqli_query($conn, $sql);
if (!$tugas_images_sebelum) die('Error executing query: ' . mysqli_error($conn));
$_SESSION['tugas_images_sebelum'] = mysqli_fetch_row($tugas_images_sebelum);


// GET image sesudah
$sql = "SELECT filename
        FROM image_tugas_harian 
        WHERE tugas_id = $tugas_id AND status = 1";
$tugas_images_sesudah = mysqli_query($conn, $sql);
if (!$tugas_images_sesudah) die('Error executing query: ' . mysqli_error($conn));
$_SESSION['tugas_images_sesudah'] = mysqli_fetch_row($tugas_images_sesudah);

header('Location: ../submitKomplain.php');

