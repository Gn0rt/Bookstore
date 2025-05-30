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
    <title>Yêu cầu đặt hàng</title>
</head>
<body>
    <?php 
        include './inc/header.php';
    ?>
    <?php
        require_once '../classes/product.php';
        require_once '../classes/request.php';


        $pd = new product();
        $rq = new request();

        // Xử lý khi form được submit
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_request'])) {
            $product_id = (int)$_POST['product_id'];
            $quantity = (int)$_POST['quantity'];
            
            // Thêm yêu cầu vào database
            $result = $rq->createRestockRequest($product_id, $quantity);
        }

        // Lấy danh sách sản phẩm sắp hết hàng
        $lowStockProducts = $pd->getLowStockProducts();
    ?>

    <div id="main">
        <h2>Thêm yêu cầu đặt hàng mới</h2>
        
        <form action="" method="POST">
            <div class="mb-3">
                <label for="product_id" class="form-label">Chọn sản phẩm</label>
                <select class="form-select" name="product_id" id="product_id" required>
                    <option value="">-- Chọn sản phẩm --</option>
                    <?php while($product = $lowStockProducts->fetch_assoc()): ?>
                    <option value="<?= $product['id'] ?>">
                        <?= htmlspecialchars($product['name']) ?> 
                        (Hiện có: <?= $product['quantity'] ?>)
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="quantity" class="form-label">Số lượng yêu cầu</label>
                <input type="number" class="form-control" name="quantity" id="quantity" min="1" required>
            </div>
            
            <button type="submit" name="submit_request" class="btn btn-primary">Gửi yêu cầu</button>
            <a href="./index1.php" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>

    
</body>
</html>