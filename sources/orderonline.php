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
    <title>Giỏ hàng</title>
</head>

<body>
    <?php include './inc/header.php' ?>
    <?php 
        if(isset($_GET['delpdcart']) && $_GET['delpdcart'] != NULL) {
            $id = $_GET['delpdcart'];
            $delcart = $cart->deleteCartPd($id);
        } 
    ?>
    <?php 
        $usId = Session::get('customer_id');
        
    ?>
    <div id="main">
        <div id="cart">
            <h3>Kiểm tra lại đơn hàng</h3>
            <form action="" method="POST">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Giá sản phẩm</th>
                            <th scope="col">Giảm giá</th>
                            <th scope="col">Tổng tiền</th>
                            <th scope="col">Hành động</th>

                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php 
                            $getCart = $cart->getCartByUserId($usId);
                            $grandTotal = 0;
                            if($getCart ) {
                                $i = 0;
                                while($row = $getCart->fetch_assoc()) {
                                    $productTotal = $row['price']*$row['quantity'] * (1 - $row['sale']);
                                    $grandTotal += $productTotal;
                                    $i++;
                        ?>
                        <tr>
                            <th scope="row"><?=$i?></th>
                            <td>
                                <input type="text" class="form-control" name="pdname" value="<?=$row['pdname']?>" disabled>
                            </td>
                            <td><input type="text" class="form-control" name="quantity" value="<?=$row['quantity']?>" disabled></td>
                            <td>
                            <input type="text" class="form-control" name="price" 
                            value="<?php echo number_format($row['price'], 0, ',', '.'); ?> đ" disabled>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="sale" value="<?=$row['sale']*100?>%" disabled>
                            </td>
                            <td>
                            <input type="text" class="form-control" name="totalprice" 
                            value="<?php echo number_format($productTotal, 0, ',', '.'); ?>đ" disabled>
                            </td>
                            <td>
                                <a 
                                href="?delpdcart=<?=$row['product_id']?>" 
                                class="btn btn-outline-danger"
                                >
                                Xóa</a>
                            </td>
                        </tr>
                        <?php 
                                }
                            }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr class="table-active">
                            <td colspan="4" class="text-end fw-bold">Tổng cộng:</td>
                            <td class="fw-bold"><?=number_format($grandTotal, 0, ',', '.')?> đ</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </form>
            <form action="congthanhtoan.php" method="POST">
                <input type="hidden" name="total_gate" value="<?php echo $grandTotal ?>">
                <button class="btn btn-primary" >Thanh toán VNPAY</button>
        </form>
        </div>
    </div>

    <?php include './inc/footer.php' ?>

</body>

</html>