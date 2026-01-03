<?php
// KẾT NỐI CSDL
require_once 'database.php';
$db = new Database();

// khoi tao bien bao loi/thanh cong
$suscess = '';
$error = '';

// xu ly khi nguoi dung submit form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // lay du lieu tu form
    $title = $_POST['title'];
    $excerpt = $_POST['excerpt'];
    $content = $_POST['content'];
    $category_id = $_POST['category'];
    $featured = $_POST['featured'];
    $views = $_POST['views'];
    $author_id = $_POST['author'];

    // kiem tra du lieu nhap
    if (empty($title) || empty($category_id) || empty($author_id)) {
        $error = "Vui lòng nhập đầy đủ thông tin";
    }
    // Kiểm tra xem có file ảnh được upload không
    elseif (!isset($_FILES['image']) || $_FILES['image']['error'] != 0) {
        $error = "Vui lòng chọn hình ảnh đại diện!";
    } else {
        // xi ly upload anh
        $tager_dir = "./public/images/";
        // dam bao thu muc ton tai
        if (!file_exists($tager_dir)) {
            mkdir($tager_dir, 0777, true);
        }
        $file_name = time() . '_' . basename($_FILES['image']['name']); // them time() de tranh trung ten
        $tager_file = $tager_dir . $file_name;
        $imgfile_type = strtolower(pathinfo($tager_file, PATHINFO_EXTENSION));

        // kiem tra dinh dang anh hop le
        $valid_extensions = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($imgfile_type, $valid_extensions)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $tager_file)) {
                // chen du lieu vao csdl
                $sql_insert = "INSERT INTO items (title, excerpt, content, image, category_id, featured, views, author_id) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $result = $db->execute($sql_insert, [$title, $excerpt, $content, $file_name, $category_id, $featured, $views, $author_id]);
                if ($result) {
                    $suscess = "Thêm bài viết thành công!";
                    // chuyen huong ve trang danh sach
                    header("Location: index.php");
                    exit();
                } else {
                    $error = "Lỗi thêm bài viết.";
                }
            } else {
                $error = "Lỗi khi tải lên hình ảnh.";
            }
        }
        else {
            $error = "Chỉ cho phép tải lên các định dạng ảnh: " . implode(", ", $valid_extensions);
        }
    }
}
// LẤY DANH SÁCH TÁC GIẢ
$sql_auth = "SELECT * FROM authors";
$authors = $db->select($sql_auth);

// LẤY DANH SÁCH DANH MỤC
$sql_cat = "SELECT * FROM categories";
$categories = $db->select($sql_cat);
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
                    <h1 class="h3 mb-3">Add Item</h1>
                    <div class="row">
                        <div class="col-12 col-6">
                            <div class="card px-5">
                                <div class="card-body">
                                    <?php if (!empty($error)): ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <?= $error ?>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($suscess)): ?>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <?= $suscess ?>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                    <form method="POST" enctype="multipart/form-data" action="">
                                        <div class="form-group">
                                            <label class="form-label">Title</label>
                                            <input name="title" type="text" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Excerpt</label>
                                            <textarea name="excerpt" class="form-control" rows="3"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Content</label>
                                            <textarea name="content" class="form-control" rows="3"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label w-100">Image</label>
                                            <input type="file" name="image" accept="image/*" required>
                                            <small class="form-text text-muted">Choose featured image</small>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Category</label>
                                            <select class="form-control" name="category" id="">
                                                <option disabled selected>Select a category</option>
                                                  <?php foreach ($categories as $cat): ?>
                                                    <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                                                  <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Feature</label>
                                            <select class="form-control" name="featured" id="">
                                                <option value="1">1</option>
                                                <option value="0" selected>0</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Views</label>
                                            <input name="views" type="number" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Author</label>
                                            <select class="form-control" name="author" id="" required>
                                                <option disabled selected>Select an author</option>
                                                <?php foreach ($authors as $a): ?>
                                                    <option value="<?= $a['id'] ?>"><?= $a['name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Add</button>
                                    </form>
                                </div>
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