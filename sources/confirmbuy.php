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
    <link rel="stylesheet" href="./css/infouser.css">
    <title>Xác nhận thanh toán</title>
</head>
<body>
    <?php 
        include './inc/header.php';
    ?>

    <div id="main">
        <h1>Xác nhận thông tin nhận hàng</h1>
        <?php 
            $id = Session::get("customer_id");        
            $getInfoUser = $user->getUserById($id);
            if($getInfoUser) {
                $row = $getInfoUser->fetch_assoc();
            
        ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="productId" class="form-label">ID</label>
                <input type="text" class="form-control" id="productId"
                    value="<?=$id?>" disabled>
            </div>
            <div class="mb-3">
                <label for="productName" class="form-label">Tên người nhận</label>
                <input type="text" class="form-control" id="productName"
                    name="productName" value="<?=$row['fullname']?>">
            </div>
            <div class="mb-3">
                <label for="productSale" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" id="productSale"
                     name="productSale" value="<?=$row['phone']?>">
            </div>
            <div class="mb-3">
                <label for="productSale" class="form-label">Địa chỉ</label>
                <input type="text" class="form-control" id="productSale"
                     name="productSale" value="<?=$row['address']?>">
            </div>
            <div class="mb-3">
                <label for="productQuantity" class="form-label">Payment</label>
                <input type="text" class="form-control" id="productQuantity"
                     name="productQuantity" value="COD" disabled>
            </div>
            <div class="product__btn">
                <button name="submit" type="submit" class="btn btn-info">Xác nhận mua</button>
            </div>
        </form>
        <?php } ?>
    </div>
    <?php 
        include './inc/footer.php';
    ?>
</body>
</html>