<?php
require_once 'includes/connection.php';
if(session_id() != '' || isset($_SESSION)) {  
    session_destroy();
}
session_start();

if (isset($_SESSION['id']) &&  $_SESSION['id'] != "") 
    header('Location: petugas');

if (isset($_GET["lokasi"])) {
    $_SESSION['lokasi'] = $_GET["lokasi"]; 
}

$lokasi_id = $_SESSION['lokasi'];
$sql = "SELECT lokasi FROM lokasi WHERE id='$lokasi_id'";
$querylokasi = mysqli_query($conn, $sql);
if (mysqli_num_rows($querylokasi) == 1)
    $lokasi = mysqli_fetch_assoc($querylokasi)['lokasi'];
else 
    $lokasi = 'Lokasi tidak ditemukan, Mohon Scan QR Code yang telah ditetapkan';

if(isset($_POST['submit'])){
    if(!empty($_POST['username'] && !empty($_POST['password']))) {
        $username = $_POST['username'];
        $password = $_POST['password'];
    }

    $sql = "SELECT id, nik, nama, jabatan 
            FROM users 
            WHERE username='$username' AND BINARY password='$password' 
            LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die('Error executing query: ' . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) == 1) {
        $qry =  mysqli_fetch_assoc($result);
        $_SESSION['id'] = $qry['id'];
        $_SESSION['nama'] = $qry['nama'];
        $_SESSION['nik'] = $qry['nik'];
        $_SESSION['jabatan'] = $qry['jabatan'];

        $userid = $_SESSION['id'];
        $sql = "UPDATE users SET status = 1 WHERE id = $userid";
        print_r($sql);
        $login_q = mysqli_query($conn, $sql);

        header('Location: petugas/absensi.php');
    } else {
        $err =  "User Tidak Valid";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cleaning Service</title>
    <link rel="stylesheet" crossorigin href="./assets/compiled/css/app.css">
    <link rel="stylesheet" crossorigin href="./assets/compiled/css/app-dark.css">
    <link rel="stylesheet" crossorigin href="./assets/compiled/css/auth.css">
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <!-- <div class="auth-logo">
                        <a href="index.html"><img src="assets/static/images/csimage/bgalogo.png" alt="Logo"></a>
                    </div> -->
                    <h1 class="auth-title">Log in.</h1>
                    <p class="auth-subtitle mb-5">Selamat Datang Di Aplikasi Cleaning Service.</p>
                    <p class="text-center mt-5 text-lg fs-4">Lokasi: <?php echo $lokasi; ?></p>
                    

                    <form action="#" method="POST"> 
                        <?php 
                        if (isset($err) && $err != "") {
                            echo '<div class="alert alert-light-danger color-danger"><i class="bi bi-exclamation-circle"></i>' . $err . '</div>';
                        }
                        ?>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" placeholder="Username" name="username" id="username" required>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" placeholder="Password" name="password" id="password" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5" name="submit" id="submit">Log in</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">Saya Karyawan,  <a href="karyawan" class="font-bold"> Komplain Disini</a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">

                </div>
            </div>
        </div>
    </div>
</body>

</html>