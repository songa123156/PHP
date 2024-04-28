<?php
include_once "config.php";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$tieu_de = "";
$hinh_dai_dien = "";
$noi_dung = "";
if (isset($_REQUEST["id"])) {
  $id = $_REQUEST["id"];
  // lấy tiêu đề
  $sql = "SELECT tieu_de, hinh_dai_dien, noi_dung FROM bai_viet where id=" . $id;
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_row();
    $tieu_de = $row[0];
    $hinh_dai_dien = $row[1];
    $noi_dung = $row[2];
  }
} else {
  // not found (404)
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $tieu_de ?></title>
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
        <h1 class="mb-4"><?php echo $tieu_de ?></h1>

        <div class="row">
          <?php
          if (!empty($hinh_dai_dien)) {
            $hinh_dai_dien = "data/avatar/" . $hinh_dai_dien
          ?>
            <div class="col-sm-3">
              <img src="<?php echo $hinh_dai_dien ?>" alt="" class="img-fluid" />
            </div>
          <?php
          }
          ?>
          <div class="col-sm">
            <?php echo $noi_dung ?>
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