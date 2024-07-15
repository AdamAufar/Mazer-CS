<?php 
ob_start();
include_once "header-main.php";

if (!isset($_SESSION['id']) || $_SESSION['id'] == "") {
    header('Location: ../auth-login.php');
    exit(); // Always use exit() after header redirect
}


// Date Datas
$currentDate = date('Y-m-d', time());
$startDate = date(date('Y', time()) . '-' . date('m', time()) . '-01');
$lastDate = date("Y-m-t", strtotime($currentDate));

$id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnUploadSesudah'])) {
    unset($_POST['btnUploadSesudah']);
    if (isset($_FILES['sesudahFoto'])) {
        $file = $_FILES['sesudahFoto'];
        
        // Copy to uploads folder
        $target_dir = '../uploads/komplain/';
        $target_file = $target_dir . basename($file['name']);
        $file_ext = pathinfo($target_file, PATHINFO_EXTENSION);
        $filename = $target_dir . uniqid() . ".". $file_ext;

        if (move_uploaded_file($file['tmp_name'], $filename)) {
            // Get tugas_id from POST data
            $komplain_id = $_POST['komplain_id'];

            // INSERT absensi photo into database
            $sql = "UPDATE komplain SET followup = '$filename', status = 0 WHERE id = $komplain_id";
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
}
 else {
    $_SESSION['error_message'] = "No photo data received!";
}

// GET all komplains
// 5: komplain_image
// 6: followup_image
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
$allKomplain =  mysqli_fetch_all($result1);

?>

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
            
<div class="page-heading">
    <h3>Lihat Komplain</h3>
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
                    $tableFlag = 0;
                    $headerFlag = 0;
                    for ($i = 0; $i <= count($allKomplain)-1; $i++) { 
                        if ($headerFlag == 0) {
                            ?>
                            <h4 class="card-title">
                                <?php echo $allKomplain[$i][0] . ". " . $allKomplain[$i][1] ?>
                            </h4> <?php 
                        } ?>
                        <br>
                        <div class="row">
                            <!-- Komplain BLOCK -->
                            <div class="col-md-6 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-content">
                                            <h4 class="card-title">Komplain | Difoto : <?php echo $allKomplain[$i][7] ?></h4>
                                            <img class="card-img-bottom img-fluid" 
                                                src="<?php echo $allKomplain[$i][5] ?>"
                                                alt="Image Komplain" 
                                                style="height: 20rem; object-fit: cover;">
                                            <p class="card-text">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Followup BLOCK -->
                            <div class="col-md-6 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-content"> <?php 
                                        if ($allKomplain[$i][6] != "-") {
                                        ?>
                                            <h4 class="card-title">Followup | Difoto : <?php echo $allKomplain[$i][7] ?></h4>
                                            <img class="card-img-bottom img-fluid" 
                                                src="<?php echo $allKomplain[$i][6] ?>"
                                                alt="Image Sesudah" 
                                                style="height: 20rem; object-fit: cover;">
                                            <p class="card-text">
                                            </p> <?php
                                        } else { ?>
                                            <h4 class="card-title"> Sesudah | Belum difoto </h4>
                                            <form action="#" method="POST" enctype="multipart/form-data">
                                                <fieldset>
                                                    <input type="hidden" name="komplain_id" value="<?php echo $allKomplain[$i][0]; ?>">
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" id="sesudahFoto" name="sesudahFoto"  aria-label="Upload" accept='image/*' capture='camera' required>
                                                        <button class="btn btn-primary" type="submit" id="btnUploadSesudah" name="btnUploadSesudah">Upload Sebelum</button>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        <?php
                                        } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php 
                        if (isset($allKomplain[$i+1][0]) && $allKomplain[$i][0] == $allKomplain[$i+1][0])
                            $headerFlag = 1;
                        else 
                            $headerFlag = 0;
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
