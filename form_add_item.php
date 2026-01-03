<?php
// 1. KẾT NỐI & KHỞI TẠO
require_once 'database.php';
$db = new Database();

// Khởi tạo biến
$success = '';
$error = '';

// Lấy dữ liệu cho Dropdown trước (để dù form lỗi hay không thì vẫn có dữ liệu hiển thị)
$authors = $db->select("SELECT * FROM authors");
$categories = $db->select("SELECT * FROM categories");

// 2. XỬ LÝ SUBMIT FORM
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy và làm sạch dữ liệu đầu vào
    $title       = trim($_POST['title'] ?? '');
    $excerpt     = trim($_POST['excerpt'] ?? '');
    $content     = trim($_POST['content'] ?? '');
    $category_id = $_POST['category'] ?? '';
    $featured    = $_POST['featured'] ?? 0;
    $views       = $_POST['views'] ?? 0;
    $author_id   = $_POST['author'] ?? '';

    // Validate dữ liệu
    if (empty($title) || empty($category_id) || empty($author_id)) {
        $error = "Vui lòng nhập đầy đủ thông tin (Tiêu đề, Danh mục, Tác giả).";
    } 
    // Validate file ảnh
    elseif (!isset($_FILES['image']) || $_FILES['image']['error'] != 0) {
        $error = "Vui lòng chọn hình ảnh đại diện!";
    } 
    else {
        // Xử lý Upload ảnh
        $target_dir = "./public/images/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $valid_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Kiểm tra định dạng ảnh
        if (!in_array($file_extension, $valid_extensions)) {
            $error = "Chỉ cho phép định dạng ảnh: " . implode(", ", $valid_extensions);
        } else {
            // Đặt tên file mới để tránh trùng lặp
            $new_file_name = time() . '_' . basename($_FILES['image']['name']);
            $target_file = $target_dir . $new_file_name;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                // 3. INSERT VÀO DATABASE
                // Lưu ý: Đã sửa tên cột category_id -> category và author_id -> author theo fix trước đó
                $sql_insert = "INSERT INTO items (title, excerpt, content, image, category, featured, views, author) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                
                $params = [$title, $excerpt, $content, $new_file_name, $category_id, $featured, $views, $author_id];
                $result = $db->execute($sql_insert, $params);

                if ($result) {
                    $success = "Thêm bài viết thành công!";
                    header("Location: index.php");
                    exit();
                } else {
                    $error = "Lỗi hệ thống: Không thể thêm vào CSDL.";
                }
            } else {
                $error = "Lỗi hệ thống: Không thể lưu file ảnh.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Thêm bài viết - E-News Admin</title>
    <link href="./public/css/app.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="index.php"><span class="align-middle">E-News Admin</span></a>
                <ul class="sidebar-nav">
                    <li class="sidebar-item active"><a class="sidebar-link" href="index.php"><i class="align-middle" data-feather="file-text"></i> Items</a></li>
                    </ul>
            </div>
        </nav>

        <div class="main">
            <main class="content">
                <div class="container-fluid p-0">
                    <h1 class="h3 mb-3">Add New Item</h1>
                    <div class="row">
                        <div class="col-12 col-md-8 col-lg-6"> <div class="card">
                                <div class="card-body">
                                    
                                    <?php if ($error): ?>
                                        <div class="alert alert-danger"><?= $error ?></div>
                                    <?php endif; ?>
                                    
                                    <?php if ($success): ?>
                                        <div class="alert alert-success"><?= $success ?></div>
                                    <?php endif; ?>

                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label class="form-label">Title</label>
                                            <input name="title" type="text" class="form-control" required value="<?= isset($title) ? htmlspecialchars($title) : '' ?>">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Excerpt</label>
                                            <textarea name="excerpt" class="form-control" rows="3"><?= isset($excerpt) ? htmlspecialchars($excerpt) : '' ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Content</label>
                                            <textarea name="content" class="form-control" rows="5"><?= isset($content) ? htmlspecialchars($content) : '' ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Image</label>
                                            <input type="file" name="image" class="form-control-file" accept="image/*" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Category</label>
                                            <select class="form-control" name="category" required>
                                                <option value="" disabled selected>Select a category</option>
                                                <?php foreach ($categories as $cat): ?>
                                                    <?php $selected = (isset($category_id) && $category_id == $cat['id']) ? 'selected' : ''; ?>
                                                    <option value="<?= $cat['id'] ?>" <?= $selected ?>><?= $cat['name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label class="form-label">Featured</label>
                                                <select class="form-control" name="featured">
                                                    <option value="0">No</option>
                                                    <option value="1" <?= (isset($featured) && $featured == 1) ? 'selected' : '' ?>>Yes</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label">Views</label>
                                                <input name="views" type="number" class="form-control" value="<?= isset($views) ? $views : 0 ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Author</label>
                                            <select class="form-control" name="author" required>
                                                <option value="" disabled selected>Select an author</option>
                                                <?php foreach ($authors as $a): ?>
                                                    <?php $selected = (isset($author_id) && $author_id == $a['id']) ? 'selected' : ''; ?>
                                                    <option value="<?= $a['id'] ?>" <?= $selected ?>><?= $a['name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Add Item</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="./public/js/app.js"></script>
</body>
</html>