<?php
require_once 'database.php';
$db = new Database();

// 1. CẤU HÌNH PHÂN TRANG & LẤY THAM SỐ
$limit = 5;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : '';

// 2. XÂY DỰNG ĐIỀU KIỆN LỌC
$where = [];
if ($keyword) {
    $where[] = "items.title LIKE '%$keyword%'";
}
if ($cat_id) {
    $where[] = "items.category = " . (int)$cat_id; 
}
$sqlWhere = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

// 3. LẤY DANH SÁCH DANH MỤC 
$categories = $db->select("SELECT * FROM categories");

// 4. TÍNH TỔNG BÀI VIẾT
$sqlCount = "SELECT COUNT(*) as total from items $sqlWhere";
$countresult = $db->select($sqlCount);
$total_records = $countresult[0]['total'];
$totalpages = ceil($total_records / $limit);

// 5. LẤY DỮ LIỆU BÀI VIẾT 
$sql = "SELECT items.*, 
               authors.name as author_name,
               categories.name as category_name
        FROM items 
        LEFT JOIN authors ON items.author = authors.id 
        LEFT JOIN categories ON items.category = categories.id
        $sqlWhere
        ORDER BY items.created_at DESC
        LIMIT $offset, $limit"; 

$items = $db->select($sql);
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
                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="index.php"><i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Bài viết</span></a>
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
                                    <h5 class="card-title">Tổng: <?php echo $total_records; ?> bài viết</h5>
                                </div>
                                <div class="card-body">
                                    <form action="" method="GET" class="row mb-3">
                                        <div class="col-md-4">
                                            <input type="text" name="keyword" class="form-control" placeholder="Nhập tên bài viết..." value="<?= htmlspecialchars($keyword); ?>">
                                        </div>
                                        <div class="col-md-3">
                                            <select name="cat_id" class="form-control">
                                                <option value="">-- Tất cả danh mục --</option>
                                                <?php if(!empty($categories)): ?>
                                                    <?php foreach ($categories as $cat): ?>
                                                        <option value="<?= $cat['id']; ?>" <?= ($cat_id == $cat['id']) ? 'selected' : '' ?>>
                                                            <?= $cat['name']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary w-100"><i data-feather="search"></i> Tìm kiếm</button>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="index.php" class="btn btn-outline-secondary w-100"><i data-feather="refresh-cw"></i> Reset</a>
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
                                                        <!-- <td><strong>#<?php //echo $row['id']; ?></strong></td> -->
                                                        <td>
                                                            <?php
                                                            $imgSrc = $row['image'];
                                                            if (!filter_var($imgSrc, FILTER_VALIDATE_URL)) {
                                                                $imgSrc = "./public/images/" . $imgSrc;
                                                            }
                                                            ?>
                                                            <img src="<?php echo $imgSrc; ?>" class="thumb-img" onerror="this.src='./public/images/user.jpg'" alt="">
                                                        </td>
                                                        <td>
                                                            <div class="text-limit" title="<?php echo htmlspecialchars($row['title']); ?>">
                                                                <strong><?php echo substr($row['title'], 0, 40); ?>...</strong>
                                                            </div>
                                                            <small class="text-muted"><?php echo substr($row['excerpt'], 0, 50); ?>...</small>
                                                        </td>
                                                        <td><span class="badge bg-success"><?php echo $row['category_name'] ?? 'Chưa phân loại'; ?></span></td>
                                                        <td><span class="badge bg-info text-dark"><?php echo $row['author_name'] ?? 'Ẩn danh'; ?></span></td>
                                                        <td class="d-none d-md-table-cell"><span class="badge bg-warning"><?php echo $row['views']; ?> lượt</span></td>
                                                        <td class="d-none d-md-table-cell"><small><?php echo date('d/m/Y', strtotime($row['created_at'])); ?></small></td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button class="btn btn-sm btn-outline-warning"><i data-feather="edit"></i></button>
                                                                <button class="btn btn-sm btn-outline-danger"><i data-feather="trash-2"></i></button>
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
                                    <?php if ($totalpages > 1): ?>
                                        <div class="d-flex justify-content-center mt-3">
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination">
                                                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                                                        <a class="page-link" href="?page=<?php echo $page - 1; ?>&keyword=<?php echo $keyword; ?>&cat_id=<?php echo $cat_id; ?>">Trước</a>
                                                    </li>
                                                    <?php for ($i = 1; $i <= $totalpages; $i++): ?>
                                                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                                            <a class="page-link" href="?page=<?php echo $i; ?>&keyword=<?php echo $keyword; ?>&cat_id=<?php echo $cat_id; ?>"><?php echo $i; ?></a>
                                                        </li>
                                                    <?php endfor; ?>
                                                    <li class="page-item <?php echo ($page >= $totalpages) ? 'disabled' : ''; ?>">
                                                        <a class="page-link" href="?page=<?php echo $page + 1; ?>&keyword=<?php echo $keyword; ?>&cat_id=<?php echo $cat_id; ?>">Sau</a>
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
</body>
</html>