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
                                    <form method="POST" enctype="multipart/form-data" action="add_item.php">
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
                                                <option value="1">Thời sự</option>
                                                <option value="2">Thế giới</option>
                                                <option value="3">Khoa học</option>
                                                <option value="4">Giải trí</option>
                                                <option value="5">Thể thao</option>
                                                <option value="6">Quân sự</option>
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
                                            <select class="form-control" name="author" id="">
                                                <option disabled selected>Select an author</option>
                                                <option value="1">Chúc Ly</option>
                                                <option value="2">Viết Tuân</option>
                                                <option value="3">Trần Hóa</option>
                                                <option value="4">Thanh Danh</option>
                                                <option value="5">Nguyễn Tiến</option>
                                                <option value="6">Sơn Hà</option>
                                                <option value="7">Minh Thư</option>
                                                <option value="8">Bảo Anh</option>
                                                <option value="9">An Khang</option>
                                                <option value="10">Châu Anh</option>
                                                <option value="11">Phương Thảo</option>
                                                <option value="12">Mai Nhật</option>
                                                <option value="13">Thanh Quý</option>
                                                <option value="14">Hoàng An</option>
                                                <option value="15">Thùy Lâm</option>
                                                <option value="16">Như Tâm</option>
                                                <option value="17">An Bình</option>
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