<?php
include_once "config.php";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// lấy tiêu đề
$sql = "SELECT gia_tri FROM gioi_thieu where ten_field='tieu_de'";
$result = $conn->query($sql);
$gioiThieuTieuDe = "";
if ($result->num_rows > 0) {
  $row = $result->fetch_row();
  $gioiThieuTieuDe = $row[0];
}
// lấy giới thiệu ngắn
$sql = "SELECT gia_tri FROM gioi_thieu where ten_field='noi_dung'";
$result = $conn->query($sql);
$noiDung = "";
if ($result->num_rows > 0) {
  $row = $result->fetch_row();
  $noiDung = $row[0];
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Họ Tên – Số báo danh – Giới thiệu</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/fontawesome/css/all.min.css" />
  <link rel="stylesheet" href="css/index.css" />
</head>

<body>
  <?php include_once "header.php"; ?>
  <main>
    <!-- Section 1 -->
    <section class="py-5">
      <div class="container">
        <h1 class="mb-4"><?php echo $gioiThieuTieuDe ?></h1>
        <div class="row">
          <div class="col-sm">
            <?php echo $noiDung ?>
          </div>
        </div>
      </div>
    </section>
    <!-- /Section 1 -->
  </main>
  <?php include_once('footer.php'); ?>
  <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/jquery-3.7.1.min.js"></script>
</body>

</html>