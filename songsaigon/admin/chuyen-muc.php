<?php
include_once "../config.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = 0;
if (isset($_REQUEST["id"])) {
    $id = $_REQUEST["id"];
}

if (isset($_REQUEST["delid"])) {
    $sql = "DELETE FROM danh_muc WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $_REQUEST["delid"]);
    $stmt->execute();
}

// lưu giá trị
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($id == 0) {
        // thêm mới
        $sql = "INSERT INTO danh_muc(ten) VALUES(?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $ten);

        $ten = $_POST['ten'];
        $stmt->execute();
    } else {
        // cập nhật
        $sql = "UPDATE danh_muc SET ten=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $ten, $id);

        $ten = $_POST['ten'];
        $stmt->execute();
    }
}


// lấy dữ liệu 1 dòng
$ten = "";
if ($id > 0) {
    $sql = "SELECT id, ten FROM danh_muc WHERE id=" . $id;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $rowData = $result->fetch_row();
        $ten = $rowData[1];
    }
}

// lấy dữ liệu nhiều dòng
$sql = "SELECT id, ten FROM danh_muc";
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
    <title>Chuyên mục</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css" />
</head>

<body>
    <?php include_once "header.php" ?>
    <main class="mt-4">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h3>Quản lý chuyên mục</h3>
                        </div>
                        <div class="col-auto">
                            <a href="chuyen-muc.php" class="btn btn-primary">Thêm mới</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm">
                            <div class="card border-primary">
                                <div class="card-body">
                                    <form method="post">
                                        <div class="mb-3">
                                            <label for="txtTen" class="form-label">Tên chuyên mục</label>
                                            <input type="text" autocomplete="off" class="form-control" id="txtTen" name="ten" value="<?php echo $ten ?>" />
                                        </div>
                                        <button type="submit" class="btn btn-primary">Lưu</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="card border-primary">
                                <div class="card-body">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 40px;">#</th>
                                                <th>Tên chuyên mục</th>
                                                <th style="width: 70px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 0;
                                            foreach ($data as $row) {
                                            ?>
                                                <tr>
                                                    <td><?php echo ++$count ?></td>
                                                    <td><?php echo $row["ten"] ?></td>
                                                    <td>
                                                        <a href="?id=<?php echo $row["id"] ?>" class="link-success"><i class="fa fa-edit me-1"></i></a>
                                                        <a href="?delid=<?php echo $row["id"] ?>" class="link-danger"><i class="fa fa-trash-alt"></i></a>
                                                    </td>
                                                </tr>
                                            <?php
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
        </div>
    </main>
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/jquery-3.7.1.min.js"></script>
</body>

</html>