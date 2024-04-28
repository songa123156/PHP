<?php
include_once "../config.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// lưu giá trị
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // cập nhật tiêu đề
    $sql = "UPDATE gioi_thieu SET gia_tri=? WHERE ten_field='tieu_de'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $giaTri);

    $giaTri = $_POST['tieu_de'];
    $stmt->execute();

    // cập nhật giới thiệu ngắn
    $sql = "UPDATE gioi_thieu SET gia_tri=? WHERE ten_field='gioi_thieu_ngan'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $giaTri);

    $giaTri = $_POST['gioi_thieu_ngan'];
    $stmt->execute();

    // cập nhật giới thiệu
    $sql = "UPDATE gioi_thieu SET gia_tri=? WHERE ten_field='noi_dung'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $giaTri);

    $giaTri = $_POST['noi_dung'];
    $stmt->execute();
}

// lấy tiêu đề
$sql = "SELECT gia_tri FROM gioi_thieu where ten_field='tieu_de'";
$result = $conn->query($sql);
$tieuDe = "";
if ($result->num_rows > 0) {
    $row = $result->fetch_row();
    $tieuDe = $row[0];
}
// lấy giới thiệu ngắn
$sql = "SELECT gia_tri FROM gioi_thieu where ten_field='gioi_thieu_ngan'";
$result = $conn->query($sql);
$gioiThieuNgan = "";
if ($result->num_rows > 0) {
    $row = $result->fetch_row();
    $gioiThieuNgan = $row[0];
}

// lấy giới thiệu ngắn
$sql = "SELECT gia_tri FROM gioi_thieu where ten_field='noi_dung'";
$result = $conn->query($sql);
$gioiThieu = "";
if ($result->num_rows > 0) {
    $row = $result->fetch_row();
    $gioiThieu = $row[0];
}

$conn->close();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới thiệu</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css" />
</head>

<body>
    <?php include_once "header.php" ?>
    <main class="mt-4">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h3>Quản lý nội dung giới thiệu</h3>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <label for="txtTieuDe" class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control" id="txtTieuDe" name="tieu_de" value="<?php echo $tieuDe ?>" />
                        </div>
                        <div class="mb-3">
                            <label for="txtGioiThieuNgan" class="form-label">Giới thiệu ngắn</label>
                            <textarea class="form-control" id="txtGioiThieuNgan" name="gioi_thieu_ngan" rows="3" maxlength="500"><?php echo $gioiThieuNgan ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="txtNoiDung" class="form-label">Nội dung</label>
                            <textarea class="form-control" id="txtNoiDung" name="noi_dung" rows="10"><?php echo $gioiThieu ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/jquery-3.7.1.min.js"></script>
</body>

</html>