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
    <link rel="stylesheet" href="./css/cart.css">
    <title>Theo dõi đơn hàng</title>
</head>
<body>
    <?php include './inc/header.php'; ?>
    <?php 
        $usid = Session::get("customer_id");
        $orders = $order->getCustomerOrder($usid);
        if(!empty($orders)) {
            foreach ($orders as $order): 

        
    ?>
    <div id="main">
        <div class="order-card">
            <div class="order-header">
                <h3>Đơn hàng #<?= $order['order_info']['id'] ?></h3>
                <p>Ngày đặt: <?= $order['order_info']['date'] ?></p>
                <p>Tổng tiền: <strong><?= number_format($order['order_info']['total'], 0, ',', '.') ?>đ</strong></p>
                <!-- <p>Trạng thái: <strong><?= $order['order_info']['status'] ?></strong></p> -->
                <p>Trạng thái: 
                    <span class="status-badge" style="background-color: <?= $order['order_info']['status'] == 'pending' ? '#ffc107' : '#28a745' ?>; 
                                                       color: <?= $order['order_info']['status'] == 'pending' ? '#000' : '#fff' ?>; 
                                                       padding: 3px 8px; 
                                                       border-radius: 4px;">
                        <strong><?= $order['order_info']['status'] ?></strong>
                    </span>
                </p>
            </div>
            
            <div class="order-products">
                <h4>Sản phẩm:</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Giảm giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order['products'] as $product): ?>
                        <tr>
                            <td><?= $product['name'] ?></td>
                            <td><?= $product['quantity'] ?></td>
                            <td><?= number_format($product['price'], 0, ',', '.') ?>đ</td>
                            <td><?= ($product['sale'] * 100) ?>%</td>
                            <td><?= number_format($product['price'] * $product['quantity'] * (1 - $product['sale']), 0, ',', '.') ?>đ</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php 
            endforeach;
        }else {
            echo "<p>Không có đơn hàng nào</p>";
        }
    
    ?>

</body>
</html>