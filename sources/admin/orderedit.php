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
        <title>Sửa thông tin hóa đơn</title>
</head>
<body>
    <?php include './inc/header.php'; ?>
    <?php 
        // include '../classes/order.php';
        include '../classes/ordera.php';

    ?>
    <?php

        if(isset($_GET['odid']) && $_GET['odid'] != NULL) {
            $id = $_GET['odid'];
        } 
        $od = new ordera();
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
            $newStatus = $_POST['update_status']; // Lấy trạng thái mới
            $updateOd = $od->updateOrderById($id, $newStatus);
        }
        

        
        
    ?>
    <div id="main">
        <div class="backToHome">
            <a href="./index1.php" type="button" class="btn btn-secondary">Trở về</a>
        </div>
        <?php
            if(isset($updateOd)) {
                echo $updateOd;
            }
        ?>
        <?php 
            $getOderDetail = $od->getOrderDetails($id);
            if($getOderDetail) {
                $firstRow = $getOderDetail->fetch_assoc();
        ?>
        <div class="order-header">
            <h3>Đơn hàng #<?= $firstRow['id'] ?></h3>
            <p>Khách hàng: <strong><?= $firstRow['username'] ?> (<?= $firstRow['phone'] ?>)</strong></p>
            <p>Ngày đặt: <?= date('d/m/Y H:i', strtotime($firstRow['order_date'])) ?></p>
            <p>Tổng tiền: <strong><?= number_format($firstRow['total_price'], 0, ',', '.') ?>đ</strong></p>
            <p>Trạng thái: 
                <span class="badge bg-<?= 
                    $firstRow['status'] == 'completed' ? 'success' : 
                    ($firstRow['status'] == 'cancelled' ? 'danger' : 'warning') 
                ?>">
                    <?= ucfirst($firstRow['status']) ?>
                </span>
            </p>
        </div>


        <form action="" method="POST">
            <div class="order-products">
                <h4>Sản phẩm:</h4>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Giảm giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Reset pointer để lặp lại từ đầu
                        $getOderDetail->data_seek(0);
                        $i = 0;
                        while($product = $getOderDetail->fetch_assoc()):
                        $i++;
                        $productTotal = $product['price'] * $product['quantity'] * (1 - $product['sale']);
                        ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td>
                                <?= $product['name'] ?>
                            </td>
                            <td><?= $product['quantity'] ?></td>
                            <td><?= number_format($product['price'], 0, ',', '.') ?>đ</td>
                            <td><?= ($product['sale'] * 100) ?>%</td>
                            <td><?= number_format($productTotal, 0, ',', '.') ?>đ</td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-end"><strong>Tổng cộng:</strong></td>
                            <td><strong><?= number_format($firstRow['total_price'], 0, ',', '.') ?>đ</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
    
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Phương thức thanh toán</label>
                        <input type="text" class="form-control" value="<?= $firstRow['payment_method'] ?>" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ giao hàng</label>
                        <textarea class="form-control" disabled><?= $firstRow['address'] ?></textarea>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <div>
                    <button type="submit" name="update_status" value="completed" class="btn btn-success">Hoàn thành</button>
                    <button type="submit" name="update_status" value="cancelled" class="btn btn-danger ms-2">Hủy đơn</button>
                </div>
            </div>
        </form>
        <?php 
            }
        ?>
    </div>

</body>
</html>