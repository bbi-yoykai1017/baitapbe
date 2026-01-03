<?php
require_once 'database.php';
$db = new Database();

// ===== CẤU HÌNH =====
$limit = 5;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$cat_id = isset($_GET['cat_id']) ? (int)$_GET['cat_id'] : 0;

// ===== XÂY DỰNG ĐIỀU KIỆN LỌC =====
$conditions = [];
$params = [];

if (!empty($keyword)) {
    $conditions[] = "items.title LIKE ?";
    $params[] = "%$keyword%";
}

if ($cat_id > 0) {
    $conditions[] = "items.category = ?";
    $params[] = $cat_id;
}

$whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

// ===== LẤY DANH SÁCH DANH MỤC =====
$categories = $db->select("SELECT id, name FROM categories ORDER BY name");

// ===== TÍNH TỔNG SỐ BÀI VIẾT =====
$countSql = "SELECT COUNT(*) as total FROM items $whereClause";
$countResult = $db->select($countSql, $params);
$totalRecords = $countResult[0]['total'] ?? 0;
$totalPages = ceil($totalRecords / $limit);

// ===== LẤY DỮ LIỆU BÀI VIẾT =====
$sql = "SELECT items.id, items.title, items.excerpt, items.image, 
               items.category, items.views, items.created_at,
               authors.name as author_name, categories.name as category_name
        FROM items 
        LEFT JOIN authors ON items.author = authors.id 
        LEFT JOIN categories ON items.category = categories.id
        $whereClause
        ORDER BY items.created_at DESC
        LIMIT ?, ?";

$params[] = $offset;
$params[] = $limit;

$items = $db->select($sql, $params);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Quản lý bài viết - E-News Admin</title>
    <link href="./public/css/app.css" rel="stylesheet">
    <style>
        .thumb-img { width: 80px; height: 50px; object-fit: cover; border-radius: 4px; }
        .text-limit { max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    </style>
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="index.php"><span class="align-middle">E-News Admin</span></a>
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
        </nav>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle"><i class="hamburger align-self-center"></i></a>
            </nav>

            <main class="content">
                <div class="container-fluid p-0">
                    <h1 class="h3 mb-3">Danh sách bài viết</h1>
                    <div class="row mb-3">
                        <div class="col-12">
                            <a href="form_add_item.php" class="btn btn-primary"><i data-feather="plus"></i> Thêm bài viết mới</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Tổng: <strong><?php echo $totalRecords; ?></strong> bài viết</h5>
                                </div>
                                <div class="card-body">
                                    <form action="" method="GET" class="row mb-3">
                                        <div class="col-md-4">
                                            <input type="text" name="keyword" class="form-control" 
                                                   placeholder="Nhập tên bài viết..." 
                                                   value="<?= htmlspecialchars($keyword); ?>">
                                        </div>
                                        <div class="col-md-3">
                                            <select name="cat_id" class="form-control">
                                                <option value="">-- Tất cả danh mục --</option>
                                                <?php foreach ($categories as $cat): ?>
                                                    <option value="<?= $cat['id']; ?>" 
                                                        <?= ($cat_id == $cat['id']) ? 'selected' : ''; ?>>
                                                        <?= htmlspecialchars($cat['name']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i data-feather="search"></i> Tìm kiếm
                                            </button>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="index.php" class="btn btn-outline-secondary w-100">
                                                <i data-feather="refresh-cw"></i> Reset
                                            </a>
                                        </div>
                                    </form>

                                    
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <!-- <th>ID</th> -->
                                                <th>Hình ảnh</th>
                                                <th>Tiêu đề</th>
                                                <th>Danh mục</th>
                                                <th>Tác giả</th>
                                                <th class="d-none d-md-table-cell">Lượt xem</th>
                                                <th class="d-none d-md-table-cell">Ngày tạo</th>
                                                <th>Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($items)): ?>
                                                <?php foreach ($items as $row): ?>
                                                    <tr>
                                                        <td>
                                                            <?php
                                                            $imgSrc = $row['image'];
                                                            if (!filter_var($imgSrc, FILTER_VALIDATE_URL)) {
                                                                $imgSrc = "./public/images/" . $imgSrc;
                                                            }
                                                            ?>
                                                            <img src="<?= $imgSrc; ?>" class="thumb-img" 
                                                                 onerror="this.src='./public/images/user.jpg'" alt="Ảnh bài viết">
                                                        </td>
                                                        <td>
                                                            <div class="text-limit" title="<?= htmlspecialchars($row['title']); ?>">
                                                                <strong><?= htmlspecialchars(substr($row['title'], 0, 40)); ?>...</strong>
                                                            </div>
                                                            <small class="text-muted"><?= htmlspecialchars(substr($row['excerpt'], 0, 50)); ?>...</small>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-success">
                                                                <?= htmlspecialchars($row['category_name'] ?? 'Chưa phân loại'); ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-info text-dark">
                                                                <?= htmlspecialchars($row['author_name'] ?? 'Ẩn danh'); ?>
                                                            </span>
                                                        </td>
                                                        <td class="d-none d-md-table-cell">
                                                            <span class="badge bg-warning"><?= $row['views']; ?> lượt</span>
                                                        </td>
                                                        <td class="d-none d-md-table-cell">
                                                            <small><?= date('d/m/Y H:i', strtotime($row['created_at'])); ?></small>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button class="btn btn-sm btn-outline-warning" 
                                                                        onclick="editItem(<?= $row['id']; ?>)">
                                                                    <i data-feather="edit"></i>
                                                                </button>
                                                                <button class="btn btn-sm btn-outline-danger" 
                                                                        onclick="deleteItem(<?= $row['id']; ?>)">
                                                                    <i data-feather="trash-2"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="8" class="text-center py-4">
                                                        <p class="text-muted">Không có dữ liệu bài viết.</p>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                    <?php if ($totalPages > 1): ?>
                                        <div class="d-flex justify-content-center mt-3">
                                            <nav aria-label="Phân trang">
                                                <ul class="pagination">
                                                    <li class="page-item <?= ($page <= 1) ? 'disabled' : ''; ?>">
                                                        <a class="page-link" href="?page=<?= $page - 1; ?>&keyword=<?= urlencode($keyword); ?>&cat_id=<?= $cat_id; ?>">
                                                            Trước
                                                        </a>
                                                    </li>
                                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                                        <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>">
                                                            <a class="page-link" href="?page=<?= $i; ?>&keyword=<?= urlencode($keyword); ?>&cat_id=<?= $cat_id; ?>">
                                                                <?= $i; ?>
                                                            </a>
                                                        </li>
                                                    <?php endfor; ?>
                                                    <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : ''; ?>">
                                                        <a class="page-link" href="?page=<?= $page + 1; ?>&keyword=<?= urlencode($keyword); ?>&cat_id=<?= $cat_id; ?>">
                                                            Sau
                                                        </a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            
            <footer class="footer">
                <div class="container-fluid">
                   <p class="mb-0 text-muted"><strong>E-News Admin</strong> &copy;</p>
                </div>
            </footer>
        </div>
    </div>
    <script src="./public/js/vendor.js"></script>
    <script src="./public/js/app.js"></script>
    <script>
        function editItem(id) {
            // TODO: Implement edit functionality
            console.log('Edit item:', id);
        }

        function deleteItem(id) {
            if (confirm('Bạn có chắc muốn xóa bài viết này?')) {
                // TODO: Implement delete functionality
                console.log('Delete item:', id);
            }
        }
    </script>
</body>
</html>