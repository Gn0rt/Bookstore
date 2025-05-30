<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ Thống Quản Lý</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/test.css">
    <!-- Font Awesome cho các biểu tượng -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <!-- Header sẽ được bạn thêm vào -->
    <?php 
        include './inc/header.php';
    ?>
    <div class="admin-container">
        <!-- Sidebar với các tab -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h3>Quản Lý Hệ Thống</h3>
            </div>

            <ul class="sidebar-menu">
                <li class="sidebar-item active" data-tab="dashboard">
                    <i class="fas fa-tachometer-alt"></i> Tổng quan
                </li>
                <li class="sidebar-item" data-tab="products">
                    <i class="fas fa-box"></i> Sản phẩm
                </li>
                <li class="sidebar-item" data-tab="categories">
                    <i class="fas fa-tags"></i> Danh mục
                </li>
                <li class="sidebar-item" data-tab="orders">
                    <i class="fas fa-shopping-cart"></i> Đơn hàng
                </li>
                <li class="sidebar-item" data-tab="customers">
                    <i class="fas fa-users"></i> Khách hàng
                </li>
                <li class="sidebar-item" data-tab="reports">
                    <i class="fas fa-chart-bar"></i> Báo cáo
                </li>
                <li class="sidebar-item" data-tab="settings">
                    <i class="fas fa-cog"></i> Yêu cầu đặt hàng
                </li>
            </ul>
        </div>

        <!-- Phần nội dung chính -->
        <div class="content">
            <!-- Tab Tổng quan -->
            <div class="tab-content active" id="dashboard">
                <div class="content-header">
                    <h2>Sản phẩm bán chạy nhất</h2>
                </div>
                <iframe src="./rplist.php" style="width:100%; height:600px; border:none;font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;"></iframe>

            </div>

            <!-- Tab Sản phẩm -->
            <div class="tab-content" id="products">
                <div class="content-header">
                    <h2>Quản lý sản phẩm</h2>
                </div>
                <div class="product__btn">
                    <a href="./productadd.php" type="button" class="btn btn-info">Thêm sản phẩm</a>
                </div>
                <?php 
                    include './productlist.php';
                ?>
                
            </div>

            <!-- Tab Danh mục -->
            <div class="tab-content" id="categories">
                <div class="content-header">
                    <h2>Quản lý danh mục</h2>
                </div>
                <div class="category__add-new category__btn">
                    <a href="./catadd.php" class="btn btn-info">Thêm danh mục mới</a>
                </div>
                <?php 
                    include './catlist.php'; 
                ?>

            </div>

            <!-- Các tab khác tương tự -->
            <div class="tab-content" id="orders">
                <div class="content-header">
                    <h2>Quản lý đơn hàng</h2>
                </div>
                <?php 
                    include './orderlist.php';
                ?>
            </div>

            <div class="tab-content" id="customers">
                <div class="content-header">
                    <h2>Quản lý khách hàng</h2>
                </div>
                <?php 
                    include './customerlist.php';
                ?>
            </div>

            <div class="tab-content" id="reports">
                <div class="content-header">
                    <h2>Báo cáo</h2>
                </div>
                <?php 
                    include './dasgboard.php';
                ?>
            </div>

            <div class="tab-content" id="settings">
                <div class="content-header">
                    <h2>Cài đặt hệ thống</h2>
                </div>
                <div class="category__add-new category__btn">
                    <a href="./requestadd.php" class="btn btn-info">Thêm danh yêu cầu đặt hàng</a>
                </div>
                <?php 
                    include './requestlist.php';
                ?>
            </div>
        </div>
    </div>

    <script src="./js/test.js"></script>
</body>

</html>