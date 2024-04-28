<?php
include_once "../config.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = 0;
if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
}
if (isset($_REQUEST['delid'])) {
    $sql = "DELETE FROM bai_viet WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $_REQUEST['delid']);
    $stmt->execute();
}
// lưu giá trị
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($id == 0) {
        //thêm mới
        $sql = "INSERT INTO bai_viet(danh_muc_id, tieu_de, gioi_thieu_ngan, noi_dung) values (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('isss', $danh_muc_id, $tieu_de, $gioi_thieu_ngan, $noi_dung);
        $danh_muc_id = $_POST['danh_muc_id'];
        $tieu_de = $_POST['tieu_de'];
        $gioi_thieu_ngan = $_POST['gioi_thieu_ngan'];
        $noi_dung = $_POST['noi_dung'];
        $stmt->execute();
    } else {
        // cập nhật
        // cập nhật tiêu đề
        $sql = "UPDATE bai_viet SET danh_muc_id=?, tieu_de=?, gioi_thieu_ngan=?, noi_dung=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('isssi', $danh_muc_id, $tieu_de, $gioi_thieu_ngan, $noi_dung, $id);
        $danh_muc_id = $_POST['danh_muc_id'];
        $tieu_de = $_POST['tieu_de'];
        $gioi_thieu_ngan = $_POST['gioi_thieu_ngan'];
        $noi_dung = $_POST['noi_dung'];
        $stmt->execute();
    }

    // kiểm tra có hình ảnh hay không?
    if (!empty($_FILES["hinh_dai_dien"] && $_FILES["hinh_dai_dien"]['error'] == 0)) {
        $check = getimagesize($_FILES["hinh_dai_dien"]["tmp_name"]);
        if ($check !== false) {
            $target_dir = "../data/avatar/";
            $target_file = time() . '_' . basename($_FILES["hinh_dai_dien"]["name"]);
            if (move_uploaded_file($_FILES["hinh_dai_dien"]["tmp_name"], $target_dir . $target_file)) {
                $latest = $id;
                // lấy id mới nhất trong DB
                if ($latest == 0) {
                    $result = $conn->query("SELECT max(id) FROM bai_viet");
                    if ($result->num_rows > 0) {
                        $rowData = $result->fetch_row();
                        $latest = $rowData[0];
                    }
                }
                // cập nhật file trong DB
                $sql = "UPDATE bai_viet SET hinh_dai_dien=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('si', $target_file, $latest);
                $stmt->execute();
            }
        }
    }
}

$danh_muc_id = '';
$tieu_de = '';
$gioi_thieu_ngan = '';
$noi_dung = '';
$hinh_dai_dien = '';
if ($id > 0) {
    // lấy dữ liệu 1 dòng
    $sql = "SELECT id, danh_muc_id, tieu_de, hinh_dai_dien, gioi_thieu_ngan, noi_dung FROM bai_viet where id=" . $id;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $rowData = $result->fetch_row();
        $danh_muc_id = $rowData[1];
        $tieu_de = $rowData[2];
        $hinh_dai_dien = $rowData[3];
        $gioi_thieu_ngan = $rowData[4];
        $noi_dung = $rowData[5];
    }
}

// lấy danh sách danh mục
$sql = "SELECT id, ten FROM danh_muc";
$result = $conn->query($sql);

$dataDM = [];
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        array_push($dataDM, $row);
    }
}
// lấy danh sách bài viết
$sql = "SELECT bai_viet.id, danh_muc_id, tieu_de, ten FROM bai_viet JOIN danh_muc on bai_viet.danh_muc_id = danh_muc.id";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        array_push($data, $row);
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Quản Trị</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
</head>

<body>
    <?php include_once "header.php" ?>
    <main class="mt-4">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h3>Quản lý bài viết</h3>
                        </div>
                        <div class="col-auto">
                            <a href="index.php" class="btn btn-primary">Thêm mới</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm">
                            <div class="card border-primary">
                                <div class="card-body">
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="drpDanhMuc" class="form-label">Danh mục</label>
                                            <select id="drpDanhMuc" class="form-select" name="danh_muc_id">
                                                <?php
                                                foreach ($dataDM as $rowDM) {
                                                ?>
                                                    <option <?php echo $rowDM['id'] == $danh_muc_id ? "selected" : "" ?> value="<?php echo $rowDM['id'] ?>"><?php echo $rowDM['ten'] ?></option>
                                                <?php
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="txtTieuDe" class="form-label">Tiêu đề</label>
                                            <input type="text" class="form-control" id="txtTieuDe" name="tieu_de" value="<?php echo $tieu_de ?>" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="txtHinh" class="form-label">Hình đại diện</label>
                                            <input type="file" class="form-control" id="txtHinh" name="hinh_dai_dien" accept="image/*" />
                                            <?php
                                            if (!empty($hinh_dai_dien)) {
                                                $hinh_dai_dien = '../data/avatar/' . $hinh_dai_dien;
                                            ?>
                                                <img src="<?php echo $hinh_dai_dien ?>" alt="" class="img-fluid mt-3" />
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="mb-3">
                                            <label for="txtGioiThieuNgan" class="form-label">Giới thiệu ngắn</label>
                                            <textarea class="form-control" id="txtGioiThieuNgan" name="gioi_thieu_ngan" rows="3" maxlength="500"><?php echo $gioi_thieu_ngan ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="txtNoiDung" class="form-label">Nội dung</label>
                                            <textarea class="form-control" id="txtNoiDung" name="noi_dung" rows="10"><?php echo $noi_dung ?></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Lưu</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="card border-primary">
                                <div class="card-body">
                                    <table class="table table-striped table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 40px;">#</th>
                                                <th>Tiêu đề</th>
                                                <th>Chuyên mục</th>
                                                <th style="width: 70px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 0;
                                            foreach ($data as $row) { ?>
                                                <tr>
                                                    <td><?php echo ++$count ?></td>
                                                    <td><?php echo $row['tieu_de'] ?></td>
                                                    <td><?php echo $row['ten'] ?></td>
                                                    <td>
                                                        <a href="?id=<?php echo $row['id'] ?>" class="link-success"><i class="fa fa-edit me-1"></i></a>
                                                        <a href="?delid=<?php echo $row['id'] ?>" class="link-danger"><i class="fa fa-trash-alt"></i></a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="../assets/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../assets/jquery-3.7.1.min.js"></script>
</body>

</html>