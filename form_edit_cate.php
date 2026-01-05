<?php
require_once 'database.php';
$db = new Database();

$message = "";
$error = "";

// 1. LẤY DỮ LIỆU CHO DROPDOWN
$categories = $db->query("SELECT * FROM categories");
$authors    = $db->query("SELECT * FROM authors");

// 2. XỬ LÝ KHI SUBMIT FORM
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $title      = trim($_POST['title']);
    $excerpt    = trim($_POST['excerpt']);
    $content    = trim($_POST['content']);
    $category   = $_POST['category'];
    $author     = $_POST['author'];
    $featured   = isset($_POST['featured']) ? 1 : 0;
    
    // Kiểm tra dữ liệu rỗng
    if (empty($title) || empty($category) || empty($author)) {
        $error = "Vui lòng nhập Tiêu đề, chọn Danh mục và Tác giả.";
    } else {
        // Xử lý upload ảnh
        $imageName = "";
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            
            if (in_array($ext, $allowed)) {
                $imageName = time() . "_" . $_FILES['image']['name']; // Đổi tên tránh trùng
                move_uploaded_file($_FILES['image']['tmp_name'], "./public/images/" . $imageName);
            } else {
                $error = "Chỉ chấp nhận file ảnh (jpg, png, gif).";
            }
        }

        if (empty($error)) {
            // Câu lệnh SQL Insert
            // Cột: title, excerpt, content, image, category, featured, views, created_at, author
            $sql = "INSERT INTO items (title, excerpt, content, image, category, featured, views, created_at, author) 
                    VALUES (?, ?, ?, ?, ?, ?, 0, NOW(), ?)";
            
            $params = [$title, $excerpt, $content, $imageName, $category, $featured, $author];
            
            $result = $db->query($sql, $params);
            
            if ($result) {
                // Thêm thành công -> Chuyển về trang chủ
                header("Location: index.php");
                exit();
            } else {
                $error = "Lỗi hệ thống, không thể thêm mới.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Thêm mới Tin tức</title>
    <link href="./public/css/app.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <div class="main">
            <main class="content">
                <div class="container-fluid p-0">
                    <h1 class="h3 mb-3">Thêm mới Bài viết</h1>

                    <?php if($error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-body">
                            <form action="" method="POST" enctype="multipart/form-data">
                                
                                <div class="mb-3">
                                    <label class="form-label">Tiêu đề tin (*)</label>
                                    <input type="text" name="title" class="form-control" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Danh mục (*)</label>
                                        <select name="category" class="form-control" required>
                                            <option value="">-- Chọn danh mục --</option>
                                            <?php foreach($categories as $c): ?>
                                                <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tác giả (*)</label>
                                        <select name="author" class="form-control" required>
                                            <option value="">-- Chọn tác giả --</option>
                                            <?php foreach($authors as $a): ?>
                                                <option value="<?= $a['id'] ?>"><?= $a['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tóm tắt</label>
                                    <textarea name="excerpt" class="form-control" rows="3"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nội dung chi tiết</label>
                                    <textarea name="content" class="form-control" rows="5"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Hình ảnh đại diện</label>
                                    <input type="file" name="image" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-check">
                                        <input class="form-check-input" type="checkbox" name="featured" value="1">
                                        <span class="form-check-label">Tin nổi bật?</span>
                                    </label>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                                    <a href="index.php" class="btn btn-secondary">Quay lại</a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>