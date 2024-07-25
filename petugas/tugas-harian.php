<?php 
ob_start();
include_once "header-main.php";

if (!isset($_SESSION['id']) || $_SESSION['id'] == "") {
    header('Location: ../index.php');
    exit(); // Always use exit() after header redirect
}

// Date Datas
$currentDate = date('Y-m-d', time());
$startDate = date(date('Y', time()) . '-' . date('m', time()) . '-01');
$lastDate = date("Y-m-t", strtotime($currentDate));

$id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnUploadSebelum'])) {
    unset($_POST['btnUploadSebelum']);
    if (isset($_FILES['sebelumFoto'])) {
        $file = $_FILES['sebelumFoto'];
        
        // Copy to uploads folder
        $target_dir = '../uploads/tugasHarian/';
        $target_file = $target_dir . basename($file['name']);
        $file_ext = pathinfo($target_file, PATHINFO_EXTENSION);
        $filename = $target_dir . uniqid() . ".". $file_ext;

        if (move_uploaded_file($file['tmp_name'], $filename)) {
            // Get tugas_id from POST data
            $tugas_id = $_POST['tugas_id'];

            // INSERT absensi photo into database with submitted_by
            $sql = "INSERT INTO `image_tugas_harian`(`tugas_id`, `filename`, `status`, `submitted_by`) 
                    VALUES ('$tugas_id', '$filename', 0, '$id')";
            if (mysqli_query($conn, $sql)) {
                // Redirect to avoid form resubmission
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                echo 'Database insert failed: ' . mysqli_error($conn) . '<br>';
            }
        } else {
            echo 'File upload failed<br>';
        }
    } else {
        echo 'Error: No file uploaded<br>';
    }
} else {
    $_SESSION['error_message'] = "No photo data received!";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnUploadSesudah'])) {
    unset($_POST['btnUploadSesudah']);
    if (isset($_FILES['sesudahFoto'])) {
        $file = $_FILES['sesudahFoto'];
        
        // Copy to uploads folder
        $target_dir = '../uploads/tugasHarian/';
        $target_file = $target_dir . basename($file['name']);
        $file_ext = pathinfo($target_file, PATHINFO_EXTENSION);
        $filename = $target_dir . uniqid() . ".". $file_ext;

        if (move_uploaded_file($file['tmp_name'], $filename)) {
            // Get tugas_id from POST data
            $tugas_id = $_POST['tugas_id'];

            // INSERT absensi photo into database with submitted_by
            $sql = "INSERT INTO `image_tugas_harian`(`tugas_id`, `filename`, `status`, `submitted_by`) 
                    VALUES ('$tugas_id', '$filename', 1, '$id')";
            if (mysqli_query($conn, $sql)) {
                // Redirect to avoid form resubmission
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                echo 'Database insert failed: ' . mysqli_error($conn) . '<br>';
            }
        } else {
            echo 'File upload failed<br>';
        }
    } else {
        echo 'Error: No file uploaded<br>';
    }
} else {
    $_SESSION['error_message'] = "No photo data received!";
}

// GET list tugas harian untuk $lokasi
$lokasi = $_SESSION['lokasi'];
$sql = "SELECT id, details, status
        FROM tugas_harian 
        WHERE lokasi='$lokasi'";
$result1 = mysqli_query($conn, $sql);
$tugas = mysqli_fetch_all($result1, MYSQLI_ASSOC);
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

// GET image tugas harian sebelum yg sudah di upload
$sql = "SELECT tugas_id, filename, date_format(created_at, '%H:%i') as 'created_at'
        FROM image_tugas_harian 
        WHERE tugas_id IN ($string_version) AND status = 0  AND date_format(created_at, '%Y-%m-%d') = '$currentDate'";
$result3 = mysqli_query($conn, $sql);
if (!$result3) die('Error executing query: ' . mysqli_error($conn));
$tugas_images_sebelum = mysqli_fetch_all($result3, MYSQLI_ASSOC);

// GET image tugas harian sesudah yg sudah di upload
$sql = "SELECT tugas_id, filename, date_format(created_at, '%H:%i') as 'created_at'
        FROM image_tugas_harian 
        WHERE tugas_id IN ($string_version) AND status = 1  AND date_format(created_at, '%Y-%m-%d') = '$currentDate'";
$result4 = mysqli_query($conn, $sql);
if (!$result4) die('Error executing query: ' . mysqli_error($conn));
$tugas_images_sesudah = mysqli_fetch_all($result4, MYSQLI_ASSOC);

?>

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
            
<div class="page-heading">
    <h3>Tugas Harian</h3>
</div> 
<div class="page-content"> 
    <section class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <!-- Header Data BLOCK -->
                    <div class="card">
                        <div class="card-header">
                            <div class="comment">
                                <div class="comment-header">
                                    <div class="pr-50">
                                        <div class="avatar avatar-2xl">
                                            <?php
                                            if (isset($absensi_image)) {
                                                ?> <img src="<?php echo $absensi_image['filename']; ?>" alt="Avatar"> <?php   
                                            } else {
                                               ?> <img src="..\assets\static\images\csimage\karyawan.png" alt="Avatar"> <?php   
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="comment-body">
                                        <div class="comment-profileName"> <?php echo $_SESSION['nama'] . " (" . $_SESSION['nik'] . ")"; ?> </div>
                                        <div class="comment-message">
                                            <p class="list-group-item-text truncate mb-20"> <?php echo $_SESSION['lokasi']; ?>  </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $flag1 = 0; 
                    $flag2 = 0;
                    $skipSesudah = 0;
                    for ($i = 0; $i <= count($tugas)-1; $i++) { 
                        if ($tugas[$i]['status'] == 0) continue; ?>
                        <h4 class="card-title">
                            <?php echo ($i+1) . ". " . $tugas[$i]['details'] ?>
                        </h4>
                        <br>
                        <div class="row">
                            <!-- Sebelum BLOCK -->
                            <div class="col-md-6 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-content">
                                            <?php 
                                            for ($j = 0; $j <= count($tugas_images_sebelum)-1; $j++) {
                                                if (isset($tugas_images_sebelum[$j]['tugas_id']) && $tugas_images_sebelum[$j]['tugas_id'] == $tugas[$i]['id']){ 
                                                    $flag1 = 1; ?>
                                                    <h4 class="card-title">Sebelum | Difoto : <?php echo $tugas_images_sebelum[$j]['created_at'] ?></h4>
                                                    <img class="card-img-bottom img-fluid" 
                                                        src="<?php echo $tugas_images_sebelum[$j]['filename'] ?>"
                                                        alt="Image Sebelum" 
                                                        style="height: 20rem; object-fit: cover;">
                                                    <?php 
                                                    break;
                                                } 
                                            }
                                            if ($flag1 == 0) { ?>
                                                <h4 class="card-title"> Sebelum | Belum difoto </h4>
                                                <form action="#" method="POST" enctype="multipart/form-data">
                                                    <fieldset>
                                                        <input type="hidden" name="tugas_id" value="<?php echo $tugas[$i]['id']; ?>">
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" id="sebelumFoto" name="sebelumFoto"  aria-label="Upload" accept='image/*' capture='camera' required>
                                                            <button class="btn btn-primary" type="submit" id="btnUploadSebelum" name="btnUploadSebelum">Upload Sebelum</button>
                                                        </div>
                                                    </fieldset>
                                                </form>
                                                <?php 
                                                $skipSesudah = 1;
                                            } ?>
                                            <p class="card-text">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Sesudah BLOCK -->
                            <?php if ($skipSesudah == 0) { ?>
                            <div class="col-md-6 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-content">
                                            <?php 
                                            for ($j = 0; $j <= count($tugas_images_sesudah)-1; $j++) {
                                                if (isset($tugas_images_sesudah[$j]['tugas_id']) && $tugas_images_sesudah[$j]['tugas_id'] == $tugas[$i]['id']){ 
                                                    $flag2 = 1; ?>
                                                    <h4 class="card-title">Sesudah | Difoto : <?php echo $tugas_images_sesudah[$j]['created_at'] ?></h4>
                                                    <img class="card-img-bottom img-fluid" 
                                                        src="<?php echo $tugas_images_sesudah[$j]['filename'] ?>"
                                                        alt="Image Sesudah" 
                                                        style="height: 20rem; object-fit: cover;">
                                                    <?php 
                                                    break;
                                                } 
                                            }
                                            if ($flag2 == 0) { ?>
                                                <h4 class="card-title"> Sesudah | Belum difoto </h4>
                                                <form action="#" method="POST" enctype="multipart/form-data">
                                                    <fieldset>
                                                        <input type="hidden" name="tugas_id" value="<?php echo $tugas[$i]['id']; ?>">
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" id="sesudahFoto" name="sesudahFoto"  aria-label="Upload" accept='image/*' capture='camera' required>
                                                            <button class="btn btn-primary" type="submit" id="btnUploadSesudah" name="btnUploadSesudah">Upload Sesudah</button>
                                                        </div>
                                                    </fieldset>
                                                </form>
                                                <?php
                                            } ?>
                                            <p class="card-text">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <hr>
                    <?php 
                    
                    $flag1 = 0;
                    $flag2 = 0;
                    $skipSesudah = 0;
                    } ?>
                </div>
            </div>
        </div>
    </section>
</div>

<!--Basic Modal -->
<div class="modal fade text-left" id="modalabsen" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel1" aria-hidden="true"  data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel1">Basic Modal</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <!-- <input type='file' accept='image/*' capture='camera'> -->
                <div class="row">
                    <div class="col-md-12 mb-1">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            <fieldset>
                                <div class="input-group">
                                    <input type="file" class="form-control" id="absenFoto" name="absenFoto" aria-label="Upload" accept='image/*' capture='camera' required>
                                    <button class="btn btn-primary" type="submit" id="btnUpload" name="btnUpload">Upload</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">
                    <span class="d-sm-block">Close</span>
                </button>
                <button type="button" class="btn btn-primary ms-1" data-bs-dismiss="modal">
                    <span class="d-sm-block">Accept</span>
                </button>
            </div>
        </div>
    </div>
</div>

<?php include_once "footer-main.php"; ?>
