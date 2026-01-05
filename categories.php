<?php
require_once 'database.php';
$db = new Database();

// --- CẤU HÌNH PHÂN TRANG ---
$limit = 5; // Số bản tin một trang
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1)
    $page = 1;
$offset = ($page - 1) * $limit;

// --- XỬ LÝ TÌM KIẾM ---
$search = "";
$where_clause = "";
$params = [];

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $where_clause = " WHERE c1.name LIKE ?";
    $params[] = "%" . $search . "%";
}

// --- BƯỚC 1: ĐẾM TỔNG SỐ BẢN GHI (Để tính số trang) ---
// Dùng biến params riêng cho việc đếm vì query đếm không cần limit/offset
$sql_count = "SELECT COUNT(*) as total FROM categories c1" . $where_clause;
$count_result = $db->query($sql_count, $params);
$total_records = $count_result[0]['total'];
$total_pages = ceil($total_records / $limit);

// --- BƯỚC 2: LẤY DỮ LIỆU CÓ PHÂN TRANG ---
$sql = "SELECT c1.*, c2.name as parent_name 
        FROM categories c1 
        LEFT JOIN categories c2 ON c1.parent = c2.id"
    . $where_clause .
    " ORDER BY c1.name ASC LIMIT ? OFFSET ?";

// Thêm tham số cho LIMIT và OFFSET
// Lưu ý: Class Database của bạn dùng bind_param với 'i' cho integer, nên phải ép kiểu hoặc đảm bảo là số nguyên
$params[] = $limit;
$params[] = $offset;

$categories = $db->query($sql, $params);

?>




<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="./public/images/favicon.png" type="image/icon type">
    <meta name="description" content="Responsive Web UI Kit &amp; Dashboard Template based on Bootstrap">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap, web ui kit, dashboard template, admin template">

    <link rel="shortcut icon" href="./public/img/icons/icon-48x48.png" />

    <title>E-News Admin</title>

    <link href="./public/css/app.css" rel="stylesheet">

    <style>
        .btn.btn-secondary.active {
            background-color: #3b7ddd !important;
            border-color: #3b7ddd !important;
        }

        .category-img {
            width: 50px;
            height: auto;
        }

        .pagination {
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="#">
                    <span class="align-middle">E-News Admin</span>
                </a>
                <ul class="sidebar-nav">
                    <li>
                        <form action="result.php" class="form-inline d-none d-sm-inline-block">
                            <div class="input-group input-group-navbar">
                                <input name="q" type="text" class="form-control" placeholder="Search…"
                                    aria-label="Search" value="">
                                <div class="input-group-append">
                                    <button class="btn" type="submit">
                                        <i class="align-middle" data-feather="search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="index.php">
                            <i class="align-middle" data-feather="file-text"></i> <span
                                class="align-middle">Items</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="categories.php">
                            <i class="align-middle" data-feather="archive"></i> <span
                                class="align-middle">Categories</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="authors.php">
                            <i class="align-middle" data-feather="user"></i> <span class="align-middle">Authors</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="#">
                            <i class="align-middle" data-feather="settings"></i> <span
                                class="align-middle">Settings</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav><!-- main content-->
        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle d-flex">
                    <i class="hamburger align-self-center"></i>
                </a>
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#"
                                data-toggle="dropdown">
                                <i class="align-middle" data-feather="settings"></i>
                            </a>
                            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#"
                                data-toggle="dropdown">
                                <span class="text-dark">admin</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Đăng Xuất</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="content">
                <div class="container-fluid p-0">
                    <div class="row py-3 mb-3" style="background-color: #fff;">
                        <div class="col-6">
                            <h1 class="h3 mb-3">Manage Categories</h1>
                        </div>
                    </div>

                    <div class="card md-3">
                        <div class="card-body">
                            <form action="index.php" method="GET" class="form-inline">
                                <input type="text" name="search" class="form-control mr2"
                                    placeholder="Nhập tên danh mục....." value="<?= $search; ?>">
                                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                                <a href="index.php" class="btn btn-secondary ml-2">Làm mới</a>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 my-2">
                            <a href="form_edit_cate.php">
                                <button type="button" class="btn btn-primary">
                                    Add Categories
                                </button>
                            </a>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên danh mục</th>
                                            <th>Danh mục cha</th>
                                            <th>Hình ảnh</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php if (!empty($categories)): ?>
                                        <?php foreach ($categories as $row): ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td>
                                                    <?php echo ($row['parent'] != 0 && $row['parent_name']) ? $row['parent_name'] : "No"; ?>
                                                </td>
                                                <td>
                                                    <?php if($row['image']): ?>
                                                        <img src="./public/images/<?php echo $row['image']; ?>" class="category-img" alt="img">
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="form_edit_cate.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="5" class="text-center">Không tìm thấy dữ liệu</td></tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                                <?php if ($total_pages > 1): ?>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <li class="page-item <?php if($page <= 1) echo 'disabled'; ?>">
                                            <a class="page-link" href="?page=<?php echo $page-1; ?>&search=<?php echo $search; ?>">Trước</a>
                                        </li>

                                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                            <li class="page-item <?php if($page == $i) echo 'active'; ?>">
                                                <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>">
                                                    <?php echo $i; ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>

                                        <li class="page-item <?php if($page >= $total_pages) echo 'disabled'; ?>">
                                            <a class="page-link" href="?page=<?php echo $page+1; ?>&search=<?php echo $search; ?>">Sau</a>
                                        </li>
                                    </ul>
                                </nav>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <!--end main-->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-left">
                            <p class="mb-0">
                                <a href="index.html" class="text-muted"><strong>AdminKit Demo</strong></a> &copy;
                            </p>
                        </div>
                        <div class="col-6 text-right">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Support</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Help Center</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Privacy</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Terms</a>
                                </li>
                            </ul>
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