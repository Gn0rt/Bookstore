<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/shop.css">
    <link rel="stylesheet" href="./css/test.css">
    
    <title>Cửa hàng</title>
</head>

<body>
    <?php 
        include './inc/header.php';
    ?>

<div class="admin-container">
        <!-- Sidebar với các tab -->
        <div class="sidebar">
            <ul class="sidebar-menu">
                <li class="sidebar-item active" data-tab="dashboard">
                    <i class="fas fa-tachometer-alt"></i> Sách
                </li>
                <li class="sidebar-item" data-tab="products">
                    <i class="fas fa-box"></i> Đồ dùng học tập
                </li>
                <li class="sidebar-item" data-tab="categories">
                    <i class="fas fa-tags"></i> Đồ chơi
                </li>
            </ul>
        </div>

        <!-- Phần nội dung chính -->
        <div class="content">
            <!-- Tab Tổng quan -->
            <div class="tab-content active" id="dashboard">
                <div class="row">
                    <?php 
                        // Khởi tạo biến
                        $getBook = false;
                        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Lấy số trang hiện tại
                        $limit = 8; // Số sản phẩm trên 1 trang
                        $offset = ($currentPage - 1) * $limit; // Tính toán offset
                        if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['findBook'])) {
                            $searchTerm = $_POST['search'] ?? '';
                            $getBook = $pd->getProductByCatId(1, $searchTerm,$limit,$offset);
                        }
                        // Nếu không có tìm kiếm hoặc không tìm thấy kết quả, hiển thị tất cả sản phẩm
                        if(!$getBook) {
                            $getBook = $pd->getProductByCatId(1,'',$limit, $offset);
                        }
                        
                        if($getBook) {
                            while($row = $getBook->fetch_assoc()) {
                                $newSrc = str_replace('../', './', $row['image']);
                    ?>
                    <div class="col-md-3">
                        <a href="./detail-product.php?id=<?=$row['id']?>" class="shop__product">
                            <img src="<?=$newSrc?>" alt="">
                            <h4 class="product__title"><?=$row['name']?></h4>
                            <p class="product__disount">Sale: <?=$row['sale']*100?>%</p>
                            <p class="product__price">Giá: <?php echo number_format($row['price'], 0, ',', '.'); ?>đ</p>
                        </a>
                    </div>
                    <?php
                            }
                        }
                    ?>
                </div>
                <div class="row">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php
                            // Tính số trang
                            $totalProducts = $pd->countProductsByCatId(1); // Hàm để đếm tổng số sản phẩm
                            $totalPages = ceil($totalProducts / $limit);

                            // Hiển thị phân trang
                            for ($i = 1; $i <= $totalPages; $i++) {
                                echo '<li class="page-item ' . ($i == $currentPage ? 'active' : '') . '">
                                    <a class="page-link" href="?tab=book&page=' . $i . '">' . $i . '</a>
                                </li>';
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Tab Sản phẩm -->
            <div class="tab-content" id="products">
                <div class="row">
                    <?php 
                        // Khởi tạo biến
                        $getSchool = false;
                        if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['findSchool'])) {
                            $searchTerm = $_POST['search_school'] ?? '';
                            $getSchool = $pd->getProductByCatId(3, $searchTerm);
                        }
                        // Nếu không có tìm kiếm hoặc không tìm thấy kết quả, hiển thị tất cả sản phẩm
                        if(!$getSchool) {
                            $getSchool = $pd->getProductByCatId(3,'',$limit, $offset);
                        }
                        
                        if($getSchool) {
                            while($row = $getSchool->fetch_assoc()) {
                                $newSrc = str_replace('../', './', $row['image']);
                    ?>
                    <div class="col-md-3">
                        <a href="./detail-product.php?id=<?=$row['id']?>" class="shop__product">
                            <img src="<?=$newSrc?>" alt="">
                            <h4 class="product__title"><?=$row['name']?></h4>
                            <p class="product__disount">Sale: <?=$row['sale']*100?>%</p>
                            <p class="product__price">Giá: <?php echo number_format($row['price'], 0, ',', '.'); ?>đ</p>
                        </a>
                    </div>
                    <?php
                            }
                        }
                    ?>
                </div>
                <div class="row">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php
                            // Tính số trang
                            $totalProducts = $pd->countProductsByCatId(3); // Hàm để đếm tổng số sản phẩm
                            $totalPages = ceil($totalProducts / $limit);

                            // Hiển thị phân trang
                            for ($i = 1; $i <= $totalPages; $i++) {
                                echo '<li class="page-item ' . ($i == $currentPage ? 'active' : '') . '">
                                    <a class="page-link" href="?tab=book&page=' . $i . '">' . $i . '</a>
                                </li>';
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Tab Danh mục -->
            <div class="tab-content" id="categories">
                <div class="row">
                    <?php 
                    // Khởi tạo biến
                        $getToy = false;
                        if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['findToy'])) {
                            $searchTerm = $_POST['search_toy'] ?? '';
                            $getToy = $pd->getProductByCatId(2, $searchTerm);
                        }
                        // Nếu không có tìm kiếm hoặc không tìm thấy kết quả, hiển thị tất cả sản phẩm
                        if(!$getToy) {
                            $getToy = $pd->getProductByCatId(2,'',$limit, $offset);
                        }
                    
                        if($getToy) {
                            while($row = $getToy->fetch_assoc()) {
                                $newSrc = str_replace('../', './', $row['image']);
                    ?>
                    <div class="col-md-3">
                        <a href="./detail-product.php?id=<?=$row['id']?>" class="shop__product">
                            <img src="<?=$newSrc?>" alt="">
                            <h4 class="product__title"><?=$row['name']?></h4>
                            <p class="product__disount">Sale: <?=$row['sale']*100?>%</p>
                            <p class="product__price">Giá: <?php echo number_format($row['price'], 0, ',', '.'); ?>đ</p>
                        </a>
                    </div>
                    <?php
                            }
                        }
                    ?>
                </div>
                <div class="row">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php
                            // Tính số trang
                            $totalProducts = $pd->countProductsByCatId(2); // Hàm để đếm tổng số sản phẩm
                            $totalPages = ceil($totalProducts / $limit);

                            // Hiển thị phân trang
                            for ($i = 1; $i <= $totalPages; $i++) {
                                echo '<li class="page-item ' . ($i == $currentPage ? 'active' : '') . '">
                                    <a class="page-link" href="?tab=book&page=' . $i . '">' . $i . '</a>
                                </li>';
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>

        </div>
    </div>

    <?php 
        include './inc/footer.php';
    ?>


    <script src="./js/test.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>