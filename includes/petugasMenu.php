<?php
require_once 'connection.php';
session_start(); 

if($_SERVER['REQUEST_METHOD'] === 'GET' && $_SESSION["menuValue"] == "absensi"){

    $lokasi = $_GET["lokasi"];
    header('Location: ../absensi.php');
}