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
    <title>Trang chủ admin</title>

</head>
<body>
    <?php 
        include './inc/header.php';
    ?>
    <?php 

    ?>
        <div id="main">
            <div class="row ">
                <div class="d-flex justify-content-between main__content">
                    <div class="nav flex-column nav-pills me-3 col-1 tab-lists" id="v-pills-tab" role="tablist"
                        aria-orientation="vertical">
                        <button class="nav-link active" id="v-pills-product-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-product" type="button" role="tab" aria-controls="v-pills-product"
                            aria-selected="true">Sản phẩm</button>
                        <button class="nav-link" id="v-pills-order-tab" data-bs-toggle="pill" data-bs-target="#v-pills-order"
                            type="button" role="tab" aria-controls="v-pills-order" aria-selected="false">Đơn hàng</button>
                        <button class="nav-link" id="v-pills-customer-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-customer" type="button" role="tab" aria-controls="v-pills-customer"
                            aria-selected="false">Khách hàng</button>
                        <button class="nav-link" id="v-pills-category-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-category" type="button" role="tab" aria-controls="v-pills-category"
                            aria-selected="false">Danh mục sản phẩm</button>
                        <button class="nav-link" id="v-pills-report-tab" data-bs-toggle="pill" data-bs-target="#v-pills-report"
                            type="button" role="tab" aria-controls="v-pills-report" aria-selected="false">Báo cáo thống
                            kê</button>
                        <button class="nav-link" id="v-pills-check-tab" data-bs-toggle="pill" data-bs-target="#v-pills-check"
                            type="button" role="tab" aria-controls="v-pills-check" aria-selected="false">Yêu cầu đặt hàng
                        </button>
                        <button class="nav-link" id="v-pills-dash-tab" data-bs-toggle="pill" data-bs-target="#v-pills-dash"
                            type="button" role="tab" aria-controls="v-pills-dash" aria-selected="false">Dashboard
                        </button>
                    </div>
                    <div class="tab-content col-11" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-product" role="tabpanel"
                            aria-labelledby="v-pills-product-tab" tabindex="0">

                            <?php include './productlist.php'; ?>
                            <div class="product__btn">
                                <a href="./productadd.php" type="button" class="btn btn-info">Thêm sản phẩm</a>
                            </div>

                        </div>

                        <div class="tab-pane fade" id="v-pills-order" role="tabpanel" aria-labelledby="v-pills-order-tab"
                            tabindex="0">

                            <?php 
                            
                            include './orderlist.php'; 
                            ?>

                            <!-- <div class="product__add">
                                <a href="" type="button" class="btn btn-info ">Thêm sản phẩm</a>
                            </div> -->
                        </div>

                        <div class="tab-pane fade" id="v-pills-customer" role="tabpanel" aria-labelledby="v-pills-customer-tab"
                            tabindex="0">
                            <?php 
                                include './customerlist.php';
                            ?>
                        </div>

                        <div class="tab-pane fade" id="v-pills-category" role="tabpanel" aria-labelledby="v-pills-category-tab"
                            tabindex="0">
                
                            <?php 
                                include './catlist.php';
                            ?>
                            <div class="category__add-new category__btn">
                                <a href="./catadd.php" class="btn btn-info">Thêm danh mục mới</a>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-report" role="tabpanel" aria-labelledby="v-pills-report-tab"
                            tabindex="0">
                        
                            <h2>Báo cáo thống kê</h2>
                            <form action="" method="POST">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="month" class="form-label">Chọn tháng:</label>
                                        <select name="month" id="month" class="form-select">
                                            <?php for ($m = 1; $m <= 12; $m++): ?>
                                                <option value="<?= $m ?>"><?= $m ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="year" class="form-label">Chọn năm:</label>
                                        <select name="year" id="year" class="form-select">
                                            <?php for ($y = date('Y'); $y >= 2000; $y--): ?>
                                                <option value="<?= $y ?>"><?= $y ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" name="findTopSelling" class="btn btn-primary">Tìm kiếm</button>
                            </form>

                            <div class="report-results mt-4">
                                <?php
                                    // Xử lý khi nhấn tìm kiếm
                                    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['findTopSelling'])) {
                                        $month = (int)$_POST['month'];
                                        $year = (int)$_POST['year'];

                                        // Gọi hàm để lấy sản phẩm bán chạy nhất theo tháng
                                        $topSellingProducts = $pd->getTopSellingProductsByMonth($month, $year);

                                        if ($topSellingProducts && $topSellingProducts->num_rows > 0) {
                                            echo '<h3>Sản phẩm bán chạy nhất trong tháng '.$month.'/'.$year.'</h3>';
                                            echo '<table class="table">';
                                            echo '<thead><tr><th>ID</th><th>Tên sản phẩm</th><th>Số lượng đã bán</th></tr></thead>';
                                            echo '<tbody>';

                                            while ($row = $topSellingProducts->fetch_assoc()) {
                                                echo '<tr>';
                                                echo '<td>' . $row['id'] . '</td>';
                                                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                                                echo '<td>' . (int)$row['total_quantity'] . '</td>';
                                                echo '</tr>';
                                            }

                                            echo '</tbody></table>';
                                        } else {
                                            echo '<p>Không có sản phẩm nào được bán trong tháng này.</p>';
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="v-pills-check" role="tabpanel" aria-labelledby="v-pills-check-tab"
                            tabindex="0">
                            <h2>Yêu cầu đặt hàng</h2>
                            <div class="category__add-new category__btn">
                                <a href="./requestadd.php" class="btn btn-info">Thêm danh yêu cầu đặt hàng</a>
                            </div>

                            <?php include './requestlist.php'; ?>
                        </div>
                        <div class="tab-pane fade" id="v-pills-dash" role="tabpanel" aria-labelledby="v-pills-dash-tab"
                            tabindex="0">
                            <h2>Dashboard</h2>
                            <?php include './dasgboard.php'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>


</body>
</html>