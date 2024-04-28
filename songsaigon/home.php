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
$sql = "SELECT gia_tri FROM gioi_thieu where ten_field='gioi_thieu_ngan'";
$result = $conn->query($sql);
$gioiThieuNgan = "";
if ($result->num_rows > 0) {
  $row = $result->fetch_row();
  $gioiThieuNgan = $row[0];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Họ Tên – Số báo danh – Sông Sài Gòn, con sông thành phố tôi</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/fontawesome/css/all.min.css" />
  <link rel="stylesheet" href="css/index.css" />
</head>

<body>
  <?php include_once "header.php"; ?>
  <section class="banner">
    <div class="container">
      <div data-bs-ride="carousel" class="carousel slide">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="data/img-2206-copy.jpg" alt="banner" class="img-fluid" />
          </div>
          <div class="carousel-item">
            <img src="data/img-2206-copy.jpg" alt="banner" class="img-fluid" />
          </div>
        </div>
      </div>
    </div>
  </section>
  <main>
    <!-- Section 1 -->
    <section class="py-5">
      <div class="container">
        <h1 class="mb-4"><?php echo $gioiThieuTieuDe ?></h1>
        <div class="row">
          <div class="col-sm-4">
            <img src="data/map_songsaigon_avatar.jpg" alt="sông Sài Gòn" class="img img-fluid" />
          </div>
          <div class="col-sm">
            <?php echo $gioiThieuNgan ?>
            <p class="text-end"><a href="gioi-thieu.php" class="link-primary">Xem thêm</a></p>
          </div>
        </div>
      </div>
    </section>
    <!-- /Section 1 -->
    <!-- Section 2 -->
    <?php
    $result = $conn->query("SELECT id, ten FROM danh_muc");
    if ($result->num_rows > 0) {
      $count = 0;
      while ($rowDM = $result->fetch_assoc()) {
    ?>
        <section class="py-5 <?php echo $count++ % 2 == 0 ? 'bg-light' : '' ?>">
          <div class="container">
            <h2 class="mb-4"><?php echo $rowDM["ten"] ?></h2>
            <div class="row row-cols-1 row-cols-sm-3">
              <?php
              $sql = "SELECT id, tieu_de, hinh_dai_dien, gioi_thieu_ngan FROM bai_viet WHERE danh_muc_id=" . $rowDM["id"] . " LIMIT 3";
              $resultBV = $conn->query($sql);
              if ($resultBV->num_rows > 0) {
                while ($rowBV = $resultBV->fetch_assoc()) {
              ?>
                  <div class="col">
                    <div class="card">
                      <img src="data/avatar/<?php echo $rowBV["hinh_dai_dien"] ?>" class="card-img-top" alt="<?php echo $rowBV["tieu_de"] ?>" />
                      <div class="card-body">
                        <h5 class="card-title"><?php echo $rowBV["tieu_de"] ?></h5>
                        <p class="card-text">
                          <?php echo $rowBV["gioi_thieu_ngan"] ?>
                        </p>
                        <a href="bai-viet.php?id=<?php echo $rowBV["id"] ?>" class="link-primary">Xem thêm</a>
                      </div>
                    </div>
                  </div>
              <?php
                }
              }
              ?>
            </div>
          </div>
        </section>
    <?php
      }
    }
    ?>
    <!-- /Section 2 -->
  </main>
  <?php include_once('footer.php'); ?>
  <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/jquery-3.7.1.min.js"></script>
</body>

</html>
<?php
$conn->close();
?>