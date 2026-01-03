<?php
// 1. KHỞI TẠO & KẾT NỐI
require_once 'database.php';
$db = new Database();

// 2. LẤY THAM SỐ ĐẦU VÀO
$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 1;
$limit = 5;
$offset = ($page - 1) * $limit;
$keyword = trim(filter_input(INPUT_GET, 'keyword') ?? '');
$cat_id = filter_input(INPUT_GET, 'cat_id', FILTER_VALIDATE_INT) ?: 0;

// 3. XÂY DỰNG TRUY VẤN
$conditions = [];
$params = [];

if ($keyword) {
    $conditions[] = "items.title LIKE ?";
    $params[] = "%$keyword%";
}

if ($cat_id > 0) {
    $conditions[] = "items.category = ?";
    $params[] = $cat_id;
}

$whereInfo = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

// 4. LẤY DỮ LIỆU
// a. Lấy danh sách danh mục (cho dropdown)
$categories = $db->select("SELECT id, name FROM categories ORDER BY name");

// b. Đếm tổng số bản ghi (để phân trang)
$countSql = "SELECT COUNT(*) as total FROM items $whereInfo";
$totalRecords = $db->select($countSql, $params)[0]['total'] ?? 0;
$totalPages = ceil($totalRecords / $limit);

// c. Lấy danh sách bài viết
$sql = "SELECT items.id, items.title, items.excerpt, items.image, items.views, items.created_at,
               authors.name as author_name, categories.name as category_name
        FROM items 
        LEFT JOIN authors ON items.author = authors.id 
        LEFT JOIN categories ON items.category = categories.id
        $whereInfo
        ORDER BY items.created_at DESC
        LIMIT ?, ?";

// Thêm limit/offset vào params để execute
$paramsItems = $params;
$paramsItems[] = $offset;
$paramsItems[] = $limit;

$items = $db->select($sql, $paramsItems);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Quản lý bài viết - E-News Admin</title>
    <link href="./public/css/app.css" rel="stylesheet">
    <style>
        .thumb-img {
            width: 80px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #dee2e6;
        }

        .text-limit {
            max-width: 250px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .pagination {
            justify-content: center;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="index.php"><span class="align-middle">E-News Admin</span></a>
                <ul class="sidebar-nav">
                    <li class="sidebar-item active"><a class="sidebar-link" href="index.php"><i
                                data-feather="file-text"></i> Items</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="categories.php"><i
                                data-feather="archive"></i> Categories</a></li>
                </ul>
            </div>
        </nav>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle"><i class="hamburger align-self-center"></i></a>
            </nav>

            <main class="content">
                <div class="container-fluid p-0">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h1 class="h3">Danh sách bài viết</h1>
                        <a href="form_add_item.php" class="btn btn-primary"><i data-feather="plus"></i> Thêm mới</a>
                    </div>

                    <div class="card">
                        <div class="card-header pb-0">
                            <h5 class="card-title">Tổng: <strong><?= $totalRecords; ?></strong> bài viết</h5>

                            <form action="" method="GET" class="row mt-3">
                                <div class="col-md-4 mb-2">
                                    <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên..."
                                        value="<?= htmlspecialchars($keyword); ?>">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <select name="cat_id" class="form-control">
                                        <option value="0">-- Tất cả danh mục --</option>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?= $cat['id']; ?>" <?= ($cat_id == $cat['id']) ? 'selected' : ''; ?>>
                                                <?= htmlspecialchars($cat['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-2 d-flex">
                                    <button type="submit" class="btn btn-primary mr-2"><i data-feather="search"></i>
                                        Tìm</button>
                                    <a href="index.php" class="btn btn-outline-secondary"><i
                                            data-feather="refresh-cw"></i> Reset</a>
                                </div>
                            </form>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width: 100px;">Hình ảnh</th>
                                            <th>Thông tin bài viết</th>
                                            <th>Danh mục</th>
                                            <th>Tác giả</th>
                                            <th class="text-center">Lượt xem</th>
                                            <th class="text-center" style="width: 120px;">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($items)): ?>
                                            <?php foreach ($items as $row): ?>
                                                <?php
                                                // Xử lý logic hiển thị ảnh gọn gàng
                                                $isUrl = filter_var($row['image'], FILTER_VALIDATE_URL);
                                                $imgSrc = $isUrl ? $row['image'] : "./public/images/" . $row['image'];
                                                ?>
                                                <tr>
                                                    <td>
                                                        <img src="<?= $imgSrc; ?>" class="thumb-img"
                                                            onerror="this.src='./public/images/no-image.png'" alt="Img">
                                                    </td>
                                                    <td>
                                                        <div class="text-limit font-weight-bold"
                                                            title="<?= htmlspecialchars($row['title']); ?>">
                                                            <?= htmlspecialchars($row['title']); ?>
                                                        </div>
                                                        <small class="text-muted d-block text-limit">
                                                            <?= htmlspecialchars($row['excerpt']); ?>
                                                        </small>
                                                        <small class="text-secondary">
                                                            <i data-feather="calendar" width="12" height="12"></i>
                                                            <?= date('d/m/Y', strtotime($row['created_at'])); ?>
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-success text-white">
                                                            <?= htmlspecialchars($row['category_name'] ?? 'Chưa phân loại'); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info text-dark">
                                                            <?= htmlspecialchars($row['author_name'] ?? 'Ẩn danh'); ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span
                                                            class="font-weight-bold"><?= number_format($row['views']); ?></span>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="edit_item.php?id=<?= $row['id']; ?>"
                                                            class="btn btn-sm btn-outline-warning" title="Sửa">
                                                            <i data-feather="edit"></i>
                                                        </a>
                                                        <a href="javascript:void(0);" onclick="deleteItem(<?= $row['id']; ?>)"
                                                            class="btn btn-sm btn-outline-danger" title="Xóa">
                                                            <i data-feather="trash-2"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">Không tìm thấy dữ liệu
                                                    nào.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                            <?php if ($totalPages > 1): ?>
                                <nav class="mt-4">
                                    <ul class="pagination">
                                        <li class="page-item <?= ($page <= 1) ? 'disabled' : ''; ?>">
                                            <a class="page-link"
                                                href="?page=<?= $page - 1; ?>&keyword=<?= urlencode($keyword); ?>&cat_id=<?= $cat_id; ?>">Trước</a>
                                        </li>

                                        <?php
                                        $start = max(1, $page - 2);
                                        $end = min($totalPages, $page + 2);
                                        ?>

                                        <?php if ($start > 1): ?>
                                            <li class="page-item"><a class="page-link" href="?page=1...">1</a></li>
                                            <li class="page-item disabled"><span class="page-link">...</span></li>
                                        <?php endif; ?>

                                        <?php for ($i = $start; $i <= $end; $i++): ?>
                                            <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>">
                                                <a class="page-link"
                                                    href="?page=<?= $i; ?>&keyword=<?= urlencode($keyword); ?>&cat_id=<?= $cat_id; ?>">
                                                    <?= $i; ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>

                                        <?php if ($end < $totalPages): ?>
                                            <li class="page-item disabled"><span class="page-link">...</span></li>
                                            <li class="page-item"><a class="page-link"
                                                    href="?page=<?= $totalPages; ?>..."><?= $totalPages; ?></a></li>
                                        <?php endif; ?>

                                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : ''; ?>">
                                            <a class="page-link"
                                                href="?page=<?= $page + 1; ?>&keyword=<?= urlencode($keyword); ?>&cat_id=<?= $cat_id; ?>">Sau</a>
                                        </li>
                                    </ul>
                                </nav>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="footer">
                <div class="container-fluid">
                    <p class="mb-0 text-muted"><strong>E-News Admin</strong> &copy; <?= date('Y'); ?></p>
                </div>
            </footer>
        </div>
    </div>

    <script src="./public/js/app.js"></script>
    <script>
        function deleteItem(id) {
            if (confirm('CẢNH BÁO: Bạn có chắc chắn muốn xóa bài viết này không?')) {
                // Chuyển hướng đến file xử lý xóa
                window.location.href = 'delete_item.php?id=' + id;
            }
        }
    </script>
</body>

</html>