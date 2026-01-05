<?php
require_once 'database.php';

$db = new Database();
$id = $_GET['id'] ?? null;
$message = "";
$category = null;

// Kiểm tra ID hợp lệ
if (!$id) {
    header("Location: index.php");
    exit();
}

// --- XỬ LÝ FORM SUBMIT (Cập nhật) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $slug = $_POST['slug']; 
    $parent = $_POST['parent'];
    $old_image = $_POST['old_image'];
    $image_name = $old_image; // Mặc định giữ ảnh cũ

    // Xử lý upload hình ảnh
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "./public/img/";
        // Đặt tên file để tránh trùng lặp
        $new_filename = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $new_filename;
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_name = $new_filename;
        } else {
            $message = "Lỗi upload ảnh.";
        }
    }

    // Câu 2: Cập nhật vào DB
    $sql_update = "UPDATE categories SET name=?, slug=?, parent=?, image=? WHERE id=?";
    // Gọi hàm query trong class Database với tham số
    $result_update = $db->query($sql_update, [$name, $slug, $parent, $image_name, $id]);

    if ($result_update !== false) {
        header("Location: index.php"); 
        exit();
    } else {
        $message = "Lỗi cập nhật dữ liệu.";
    }
}

// --- LẤY DỮ LIỆU HIỂN THỊ ---

// 1. Lấy thông tin danh mục cần sửa
$data = $db->query("SELECT * FROM categories WHERE id = ?", [$id]);
if (!empty($data)) {
    $category = $data[0]; // Lấy dòng đầu tiên
} else {
    die("Không tìm thấy danh mục.");
}

// 2. Lấy danh sách danh mục khác để đổ vào dropdown (trừ chính nó để tránh vòng lặp cha-con)
$list_categories = $db->query("SELECT * FROM categories WHERE id != ?", [$id]);

// 3. Lấy tên danh mục cha hiện tại (để hiển thị text)
$parent_name_display = "No";
if ($category['parent'] != 0) {
    $p_data = $db->query("SELECT name FROM categories WHERE id = ?", [$category['parent']]);
    if (!empty($p_data)) {
        $parent_name_display = $p_data[0]['name'];
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Sửa Danh mục</title>
    <link href="./public/css/app.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <div class="main">
            <main class="content">
                <div class="container-fluid">
                    <h1 class="h3 mb-3">Sửa Danh mục</h1>
                    
                    <?php if($message): ?>
                        <div class="alert alert-danger"><?php echo $message; ?></div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-body">
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group mb-3">
                                    <label class="form-label">Tên danh mục</label>
                                    <input type="text" name="name" class="form-control" 
                                           value="<?php echo htmlspecialchars($category['name']); ?>" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">Slug</label>
                                    <input type="text" name="slug" class="form-control" 
                                           value="<?php echo htmlspecialchars($category['slug']); ?>">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Danh mục cha</label>
                                    <p class="text-info small">Cha hiện tại: <strong><?php echo $parent_name_display; ?></strong></p>
                                    
                                    <select name="parent" class="form-control">
                                        <option value="0">No (Không có cha)</option>
                                        <?php foreach($list_categories as $cat): ?>
                                            <option value="<?php echo $cat['id']; ?>" 
                                                <?php if($cat['id'] == $category['parent']) echo 'selected'; ?>>
                                                <?php echo $cat['name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Hình ảnh</label><br>
                                    <?php if($category['image']): ?>
                                        <img src="./public/img/<?php echo $category['image']; ?>" 
                                             style="width: 100px; margin-bottom: 10px; border: 1px solid #ddd;">
                                    <?php endif; ?>
                                    <input type="hidden" name="old_image" value="<?php echo $category['image']; ?>">
                                    <input type="file" name="image" class="form-control">
                                </div>

                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                                <a href="index.php" class="btn btn-secondary">Quay lại</a>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>