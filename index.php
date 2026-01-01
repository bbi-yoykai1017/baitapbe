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
                    <div class="row py-3 mb-3" style="background-color: #fff;">
                        <div class="col-6">
                            <h1 class="h3 mb-3">Manage Items</h1>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12 my-2">
                            <a href="form_add_item.php">
                                <button type="button" class="btn btn-primary">
                                    Add Item
                                </button>
                            </a>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Excerpt</th>
                                            <th>Category</th>
                                            <th>Feature</th>
                                            <th>View</th>
                                            <th>Author</th>
                                            <th>Created at</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="">
                                            <td>
                                                <img style="width:100px"
                                                    src="./public/images/z4373167397100-ad526b3646c26ba-6193-9805-1732891121.jpg" />
                                            </td>
                                            <td>Miền Tây mỗi năm mất 300-500 ha đất do sạt lở </td>
                                            <td> Hơn 800 khu vực sạt lở bờ sông, biển, với tổng chiều dài trên 1.000 km,
                                                mỗi năm "cuốn trôi" 300-500 ha đất ở Đồng bằng sông Cửu Long.</td>
                                            <td>Thời sự</td>
                                            <td>1</td>
                                            <td>12</td>
                                            <td>An Bình</td>
                                            <td>2024-11-30 07:24:06</td>
                                            <td>
                                                <a href="form_edit_item.php?id=28" class="btn
                                                    btn-success btn-mini">Edit</a>
                                                <a href="delete.php?id=28" class="btn
                                                    btn-danger btn-mini">Delete</a>
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <td>
                                                <img style="width:100px"
                                                    src="./public/images/gianhatop172906697249071729066-9647-2559-1729959592.png" />
                                            </td>
                                            <td>Giá nhà ngày càng xa tầm với</td>
                                            <td>Giá nhà ngày càng leo thang, bỏ xa thu nhập người lao động, ngay cả với
                                                nhân viên tài chính, ngân hàng - nhóm ngành có mức lương cao nhất - cũng
                                                không theo kịp.</td>
                                            <td>Thời sự</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>Nguyễn Tiến</td>
                                            <td>2024-10-31 08:41:02</td>
                                            <td>
                                                <a href="form_edit_item.php?id=25" class="btn
                                                    btn-success btn-mini">Edit</a>
                                                <a href="delete.php?id=25" class="btn
                                                    btn-danger btn-mini">Delete</a>
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <td>
                                                <img style="width:100px"
                                                    src="./public/images/nguyennhatanh11642147020861116-5894-3859-1730117002.jpg" />
                                            </td>
                                            <td>Giới trẻ nói về sức hút của truyện Nguyễn Nhật Ánh</td>
                                            <td>Nhiều fan cho rằng Nguyễn Nhật Ánh không cần đổi lối viết bởi giọng văn
                                                tình cảm và thuần Việt của ông là bản sắc.</td>
                                            <td>Giải trí</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>Thanh Danh</td>
                                            <td>2024-10-31 08:33:21</td>
                                            <td>
                                                <a href="form_edit_item.php?id=24" class="btn
                                                    btn-success btn-mini">Edit</a>
                                                <a href="delete.php?id=24" class="btn
                                                    btn-danger btn-mini">Delete</a>
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <td>
                                                <img style="width:100px"
                                                    src="./public/images/ungdung-1729473244-5785-1729481462.jpg" />
                                            </td>
                                            <td>Nhà khoa học thiết kế giải pháp hỗ trợ bệnh nhân nữ ung thư</td>
                                            <td>Nhóm nhà khoa học trường Đại học VinUni và đối tác quốc tế phát triển
                                                giải pháp số, ứng dụng AI hỗ trợ sức khỏe miễn phí cho 150 phụ nữ sau
                                                phẫu thuật ung thư</td>
                                            <td>Khoa học</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>Viết Tuân</td>
                                            <td>2024-10-31 08:31:44</td>
                                            <td>
                                                <a href="form_edit_item.php?id=23" class="btn
                                                    btn-success btn-mini">Edit</a>
                                                <a href="delete.php?id=23" class="btn
                                                    btn-danger btn-mini">Delete</a>
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <td>
                                                <img style="width:100px"
                                                    src="./public/images/pmc-qatar-2-4300-1730309058.jpg" />
                                            </td>
                                            <td>Thủ tướng Phạm Minh Chính bắt đầu thăm Qatar</td>
                                            <td>Thủ tướng Phạm Minh Chính và phu nhân đến Qatar, bắt đầu chuyến thăm
                                                chính thức nước này.</td>
                                            <td>Thế giới</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>Chúc Ly</td>
                                            <td>2024-10-31 08:28:49</td>
                                            <td>
                                                <a href="form_edit_item.php?id=22" class="btn
                                                    btn-success btn-mini">Edit</a>
                                                <a href="delete.php?id=22" class="btn
                                                    btn-danger btn-mini">Delete</a>
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <td>
                                                <img style="width:100px"
                                                    src="./public/images/Israel-6752-1729226852.png" />
                                            </td>
                                            <td>Cuộc chạm trán bất ngờ khiến thủ lĩnh Hamas thiệt mạng</td>
                                            <td>Khi binh sĩ Lữ đoàn 828 Israel chạm trán nhóm tay súng ở thành phố
                                                Rafah, họ không ngờ đối phương là thủ lĩnh Hamas Yahya Sinwar cùng các
                                                cận vệ.</td>
                                            <td>Quân sự</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>An Bình</td>
                                            <td>2024-10-18 15:42:07</td>
                                            <td>
                                                <a href="form_edit_item.php?id=20" class="btn
                                                    btn-success btn-mini">Edit</a>
                                                <a href="delete.php?id=20" class="btn
                                                    btn-danger btn-mini">Delete</a>
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <td>
                                                <img style="width:100px" src="./public/images/2-SO-2-1729181158.jpg" />
                                            </td>
                                            <td>Người Cần Thơ 'vật lộn' khi triều cường gây ngập gần một mét</td>
                                            <td>Triều cường khiến một số khu vực TP Cần Thơ ngập gần một mét, nhiều
                                                người không kịp trở tay, cuộc sống đảo lộn, kinh doanh ế ẩm, học sinh đi
                                                thuyền tới trường.</td>
                                            <td>Thời sự</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>An Bình</td>
                                            <td>2024-10-18 15:38:22</td>
                                            <td>
                                                <a href="form_edit_item.php?id=19" class="btn
                                                    btn-success btn-mini">Edit</a>
                                                <a href="delete.php?id=19" class="btn
                                                    btn-danger btn-mini">Delete</a>
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <td>
                                                <img style="width:100px"
                                                    src="./public/images/AFP-20240803-369X2YQ-v2-HighRe-8119-4578-1729211956.jpg" />
                                            </td>
                                            <td>Hezbollah lần đầu tập kích Israel bằng 'tên lửa dẫn đường chính xác'
                                            </td>
                                            <td>Nhóm vũ trang Hezbollah tuyên bố chuyển sang giai đoạn mới trong xung
                                                đột với Israel, lần đầu tấn công mục tiêu bằng tên lửa dẫn đường chính
                                                xác.</td>
                                            <td>Quân sự</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>Thùy Lâm</td>
                                            <td>2024-10-18 09:35:50</td>
                                            <td>
                                                <a href="form_edit_item.php?id=17" class="btn
                                                    btn-success btn-mini">Edit</a>
                                                <a href="delete.php?id=17" class="btn
                                                    btn-danger btn-mini">Delete</a>
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <td>
                                                <img style="width:100px"
                                                    src="./public/images/sinwar-5680-1729188509-5826-1729208259.jpg" />
                                            </td>
                                            <td>Israel công bố video 'khoảnh khắc cuối cùng của thủ lĩnh Hamas'</td>
                                            <td>Quân đội Israel công bố video từ drone trinh sát, được cho là hình ảnh
                                                thủ lĩnh Hamas Yahya Sinwar ngay trước khi bị hạ sát.</td>
                                            <td>Quân sự</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>Như Tâm</td>
                                            <td>2024-10-18 09:32:34</td>
                                            <td>
                                                <a href="form_edit_item.php?id=16" class="btn
                                                    btn-success btn-mini">Edit</a>
                                                <a href="delete.php?id=16" class="btn
                                                    btn-danger btn-mini">Delete</a>
                                            </td>
                                    </tbody>
                                </table>
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