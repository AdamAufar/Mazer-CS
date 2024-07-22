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

// GET list tugas harian untuk $lokasi
$lokasi = $_SESSION['lokasi'];
$sql = "SELECT id, details, status
        FROM tugas_harian 
        WHERE lokasi='$lokasi'";
$result1 = mysqli_query($conn, $sql);
$tugas = mysqli_fetch_all($result1, MYSQLI_ASSOC);
if (!$result1) die('Error executing query: ' . mysqli_error($conn));

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['switchStates'])) {
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
                                            <p class="list-group-item-text truncate mb-20"> <?php echo $_SESSION['lokasi']; ?>  </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
                            <hr>
                        <?php } ?>

                        <!-- Hidden input to store the switch states array -->
                        <input type="hidden" name="switchStates" id="switchStates">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <!-- Form End -->

                </div>
            </div>
        </div>
    </section>
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
