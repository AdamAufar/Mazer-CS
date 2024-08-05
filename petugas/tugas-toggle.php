<?php 
ob_start();
include_once "header-main.php";

if (!isset($_SESSION['id']) || $_SESSION['id'] == "") {
    header('Location: ../index.php');
    exit(); // Always use exit() after header redirect
}

$id = $_SESSION['id'];

$sql = "SELECT jabatan FROM users WHERE id='$id'";
$resultjabatan = mysqli_query($conn, $sql);
$jabatan = mysqli_fetch_assoc($resultjabatan);
if ($jabatan['jabatan'] != "Admin") {
    header("Location: tugas-harian.php");
}

// Date Datas
$currentDate = date('Y-m-d', time());
$startDate = date(date('Y', time()) . '-' . date('m', time()) . '-01');
$lastDate = date("Y-m-t", strtotime($currentDate));

// GET list tugas harian untuk $lokasi
$lokasi = $_SESSION['lokasi'];
$sql = "SELECT id, details, status FROM tugas_harian WHERE lokasi='$lokasi'";
$result1 = mysqli_query($conn, $sql);
$tugas = mysqli_fetch_all($result1, MYSQLI_ASSOC);
if (!$result1) die('Error executing query: ' . mysqli_error($conn));

$sql = "SELECT DISTINCT lokasi FROM tugas_harian";
$q = mysqli_query($conn, $sql);
$list_lokasi = mysqli_fetch_all($q, MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['switchStates'])) {
        $switchStates = json_decode($_POST['switchStates'], true);
        foreach ($switchStates as $tugas_id => $status) {
            $sql = "UPDATE tugas_harian SET status=$status WHERE id=$tugas_id";
            if (!mysqli_query($conn, $sql)) {
                echo 'Database update failed: ' . mysqli_error($conn) . '<br>';
            }
        }
        // Redirect to avoid form resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } elseif (isset($_POST['detail']) && isset($_POST['lokasi'])) {
        $detail = mysqli_real_escape_string($conn, $_POST['detail']);
        $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
        $sql = "INSERT INTO tugas_harian (details, lokasi, status) VALUES ('$detail', '$lokasi', 0)";
        if (mysqli_query($conn, $sql)) {
            // Redirect to avoid form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo 'Database insert failed: ' . mysqli_error($conn) . '<br>';
        }
    } elseif (isset($_POST['delete_tugas_id'])) {
        $delete_tugas_id = mysqli_real_escape_string($conn, $_POST['delete_tugas_id']);
        $sql = "DELETE FROM tugas_harian WHERE id='$delete_tugas_id'";
        if (mysqli_query($conn, $sql)) {
            // Redirect to avoid form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo 'Database delete failed: ' . mysqli_error($conn) . '<br>';
        }
    }
}
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
                                            <p class="list-group-item-text truncate mb-20"> <?php echo $lokasiName['lokasi']; ?>  </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button class="btn icon icon-left btn-primary me-2 text-nowrap" data-bs-toggle="modal" data-bs-target="#modalabsen">
                        <i class="bi bi-pencil-square"></i> 
                        Tambah Tugas
                    </button>
                    <hr>

                    <!-- Form Start -->
                    <form id="tugasForm" method="POST" action="#">
                        <?php
                        for ($i = 0; $i <= count($tugas)-1; $i++) { ?>
                            <h4 class="card-title">
                                <?php echo ($i+1) . ". " . $tugas[$i]['details'] ?>
                            </h4>
                            
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="tugasSwitch<?php echo $i; ?>" name="tugasSwitch[<?php echo $tugas[$i]['id']; ?>]" value="1" <?php if ($tugas[$i]['status'] == 1){echo "checked";} ?> >
                            </div>
                            <!-- DELETE tugas -->
                            <form method="POST" action="#">
                                <input type="hidden" name="delete_tugas_id" value="<?php echo $tugas[$i]['id']; ?>">
                                <button type="submit" class="btn btn-danger mt-2">Delete</button>
                            </form>
                            <hr>
                        <?php } ?>
                        <input type="hidden" name="switchStates" id="switchStates">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <!-- Form End -->

                </div>
            </div>
        </div>
    </section>
</div>

<!-- Basic Modal -->
<div class="modal fade text-left" id="modalabsen" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel1" aria-hidden="true"  data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <form id="modalForm" method="POST" action="#">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel1">Tambah Tugas</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-1">
                            <div class="form-group">
                                <label for="detail">Detail Tugas</label>
                                <input type="text" class="form-control" id="detail" name="detail" placeholder="Enter tugas" required>
                            </div>
                            <h6>Lokasi:</h6>
                            <fieldset class="form-group">
                                <select class="form-select" id="lokasi" name="lokasi" required>
                                    <?php foreach ($list_lokasi as $l) {
                                    echo "<option> " . $l['lokasi'] . " </option>";
                                    } ?>
                                </select>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">
                        <span class="d-sm-block">Close</span>
                    </button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once "footer-main.php"; ?>

<script>
document.getElementById('tugasForm').addEventListener('submit', function(event) {
    const switchStates = {};
    <?php foreach ($tugas as $index => $task) { ?>
        switchStates['<?php echo $task['id']; ?>'] = document.getElementById('tugasSwitch<?php echo $index; ?>').checked ? 1 : 0;
    <?php } ?>
    document.getElementById('switchStates').value = JSON.stringify(switchStates);
});
</script>
