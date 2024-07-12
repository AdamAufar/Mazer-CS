<?php 

include_once "header-main.php";

// Date Datas
$currentDate = date('Y-m-d', time());
$startDate = date(date('Y', time()) . '-' . date('m', time()) . '-01');
$lastDate = date("Y-m-t", strtotime($currentDate));

$id = $_SESSION['id'];
// print_r($_POST['btnUpload']);
if (isset($_POST['btnUpload'])) {
    unset($_POST['btnUpload']);
    if (isset($_FILES['absenFoto'])) 
        $file = $_FILES['absenFoto'];
    else
        echo 'ERORROOROR';

    // Copy to uploads folder
    $target_dir = '../uploads/';
    $target_file = $target_dir . basename($file['name']);
    $file_ext = pathinfo($target_file, PATHINFO_EXTENSION);
    $filename = $target_dir . uniqid() . ".". $file_ext;
    move_uploaded_file($file['tmp_name'], $filename);

    // INSERT absensi photo into database
    $sql = "INSERT INTO `absensi`(`user_id`, `filename`) VALUES ('$id','$filename')";
    $insert_result = mysqli_query($conn, $sql);
} else {
    $_SESSION['error_message'] = "No photo data received!";
}

// GET current date absensi image and absen time
$sql = "SELECT filename, absen_at
        FROM absensi 
        WHERE user_id = $id AND date_format(absen_at, '%Y-%m-%d') = '$currentDate'";
$query_absen_image = mysqli_query($conn, $sql);
$absensi_image = mysqli_fetch_assoc($query_absen_image);

// GET all absensi datetime data
$sql = "SELECT filename, 
            date_format(absen_at, '%Y-%m-%d') as date, 
            date_format(absen_at, '%h:%i:%s') as time
        FROM absensi 
        WHERE user_id = $id 
            AND date_format(absen_at, '%Y-%m-%d') BETWEEN '$startDate' AND '$currentDate'
        ORDER BY absen_at";
$all_absen = mysqli_query($conn, $sql);
$_SESSION['all_absen'] = mysqli_fetch_all($all_absen);

?>

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
            
<div class="page-heading">
    <h3>Absen</h3>
</div> 
<div class="page-content"> 
    <section class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="comment">
                                <div class="comment-header">
                                    <div class="pr-50">
                                        <div class="avatar avatar-3xl">
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
                                        <div class="comment-actions">
                                            <button class="btn icon icon-left btn-primary me-2 text-nowrap" data-bs-toggle="modal"
                                            data-bs-target="#modalabsen"><i class="bi bi-pencil-square"></i> Absen</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <section class="section">
                                    <div class="row" id="basic-table">
                                        <div class="col-12 col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Absen History</h4>
                                                </div>
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <!-- <p class="card-text">
                                                            Add text if needed here
                                                        </p> -->
                                                        <!-- Table with outer spacing -->
                                                        <div class="table-responsive">
                                                            <table class="table table-lg">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Hari</th>
                                                                        <th>Tanggal</th>
                                                                        <th>Jam Absen</th>
                                                                    </tr>
                                                                </thead>
                                                                <!-- 
                                                                <tr>
                                                                    <td class="text-bold-500">Michael Right</td>
                                                                    <td>$15/hr</td>
                                                                    <td class="text-bold-500">UI/UX</td>
                                                                </tr>
                                                                 -->
                                                                <tbody>
                                                                    <?php 
                                                                    $j = 0;
                                                                    $begin = new DateTime($startDate);
                                                                    $end = new DateTime($currentDate);
                                                                    $all_absen = $_SESSION['all_absen'];
                                                                    for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
                                                                        echo '<tr>';
                                                                        echo '<td>';
                                                                            switch (date('w', strtotime($i->format("Y-m-d")))) {
                                                                                case "0":
                                                                                echo "Minggu";
                                                                                break;
                                                                                case "1":
                                                                                echo "Senin";
                                                                                break;
                                                                                case "2":
                                                                                echo "Selasa";
                                                                                break;
                                                                                case "3":
                                                                                echo "Rabu";
                                                                                break;
                                                                                case "4":
                                                                                echo "Kamis";
                                                                                break;
                                                                                case "5":
                                                                                echo "Jumat";
                                                                                break;
                                                                                case "6":
                                                                                echo "Sabtu";
                                                                                break;
                                                                            }
                                                                        echo '</td>';
                                                                        echo '<td>' . $i->format("d-m-Y") . '</td>';

                                                                        if (date('w', strtotime($i->format("Y-m-d"))) == '6' || date('w', strtotime($i->format("Y-m-d"))) == '0') {
                                                                            echo '<td>LIBUR</td>';
                                                                            if (isset($all_absen[$j][1]) && $i->format("Y-m-d") == $all_absen[$j][1]) {
                                                                                $j++;
                                                                            }
                                                                        } else if (isset($all_absen[$j][1]) && $i->format("Y-m-d") == $all_absen[$j][1]) {
                                                                            if ($all_absen[$j][2] > '08:00:00') {
                                                                                echo '<td><span style="color: red;">' . $all_absen[$j][2] . '</span></td>';
                                                                            } else {
                                                                                echo '<td>' . $all_absen[$j][2] . '</td>';
                                                                            }
                                                                            $j++;
                                                                        } else {
                                                                            echo '<td>-</td>';
                                                                        }
                                                                        echo '</tr>';
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div> 
                        </div>
                    </div>
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
            </div>
        </div>
    </div>
</div>

<?php include_once "footer-main.php"; ?>