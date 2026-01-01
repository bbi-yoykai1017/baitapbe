<?php
// 1. Kết nối CSDL
require_once 'database.php';

// 2. Viết truy vấn lấy tất cả tin, kết bảng tác giả và danh mục, sắp xếp mới nhất lên đầu
$sql = "SELECT items.*, categories.name AS category_name, authors.name AS author_name 
        FROM items 
        JOIN categories ON items.category = categories.id 
        JOIN authors ON items.author = authors.id 
        ORDER BY items.created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Trang quản trị tin tức</title>
    <link href="./public/css/app.css" rel="stylesheet">
    <style>
        .news-img {
            width: 100px;
            height: auto;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="index.php">
                    <span class="align-middle">E-News Admin</span>
                </a>
                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Chức năng
                    </li>
                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="index.php">
                            <i class="align-middle" data-feather="list"></i> <span class="align-middle">Danh sách tin</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="form_add_item.php">
                            <i class="align-middle" data-feather="plus-square"></i> <span class="align-middle">Thêm tin mới</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle d-flex">
                    <i class="hamburger align-self-center"></i>
                </a>
                <form class="form-inline d-none d-sm-inline-block">
                    <div class="input-group input-group-navbar">
                        <input type="text" class="form-control" placeholder="Tìm kiếm..." aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn" type="button">
                                <i class="align-middle" data-feather="search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                </nav>

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3">Danh sách tin tức</h1>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Quản lý tin tức</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th style="width: 20%;">Tiêu đề</th>
                                                <th>Hình ảnh</th>
                                                <th>Danh mục</th>
                                                <th>Tác giả</th>
                                                <th>Ngày tạo</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // 3. Duyệt qua từng dòng dữ liệu và hiển thị
                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $row['id']; ?></td>
                                                    <td>
                                                        <strong><?php echo $row['title']; ?></strong>
                                                        <br>
                                                        <small class="text-muted"><?php echo substr($row['excerpt'], 0, 50) . '...'; ?></small>
                                                    </td>
                                                    <td>
                                                        <img src="uploads/<?php echo $row['image']; ?>" alt="News Image" class="news-img" onerror="this.src='./public/img/icons/icon-48x48.png'"> 
                                                    </td>
                                                    <td><span class="badge badge-primary"><?php echo $row['category_name']; ?></span></td>
                                                    <td><?php echo $row['author_name']; ?></td>
                                                    <td><?php echo date("d/m/Y", strtotime($row['created_at'])); ?></td>
                                                    <td class="table-action">
                                                        <a href="form_edit_item.php?id=<?php echo $row['id']; ?>"><i class="align-middle" data-feather="edit-2"></i></a>
                                                        <a href="delete_item.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Bạn có chắc muốn xóa?');"><i class="align-middle" data-feather="trash"></i></a>
                                                    </td>
                                                </tr>
                                            <?php 
                                                }
                                            } else {
                                                echo "<tr><td colspan='7' class='text-center'>Chưa có tin tức nào</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-left">
                            <p class="mb-0">
                                <a href="index.php" class="text-muted"><strong>E-News Admin</strong></a> &copy;
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="./public/js/vendor.js"></script>
    <script src="./public/js/app.js"></script>
</body>

</html>

<?php
// Đóng kết nối
$conn->close();
?>