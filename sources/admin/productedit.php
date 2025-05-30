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
        <title>Sửa thông tin sản phẩm</title>
</head>
<body>
    <?php include './inc/header.php'; ?>
    <?php 
    include '../classes/product.php';
    ?>
    <?php 
        if(isset($_GET['productid']) && $_GET['productid'] != NULL) {
            $id = $_GET['productid'];
        } 
        $pd = new product();
        if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
            $updateProduct = $pd->updateProductById($_POST, $_FILES, $id);
        }
    ?>
    <div id="main">
        <div class="backToHome">
            <a href="./index1.php" type="button" class="btn btn-secondary">Trở về</a>
        </div>
        <?php
            if(isset($updateProduct)) {
                echo $updateProduct;
            }
        ?>
        <?php 
            $getPd = $pd->getProductById($id);
            if($getPd) {
                while($row = $getPd->fetch_assoc()) { 
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="productId" class="form-label">ID</label>
                <input type="text" class="form-control" id="productId"
                    value="<?=$id?>" disabled>
            </div>
            <div class="mb-3">
                <label for="productName" class="form-label">Tên sản phẩm</label>
                <input type="text" class="form-control" id="productName"
                    name="productName" value="<?=$row['name']?>">
            </div>
            <div class="mb-3">
                <label for="productCat" class="form-label">Danh mục</label>
                <select class="form-select" aria-label="Default select example" name="productCat">
                        <option selected>-- Danh mục sản phẩm --</option>
                        <?php 
                            $categories = $pd->selectCat();
                            foreach($categories as $cate) {
                                $selected = ($cate['id'] == $row['category_id']) ? 'selected' : '';
                                echo "<option value='{$cate['id']}' $selected>{$cate['id']}-{$cate['name']}</option>";
                            }
                        ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="productPrice" class="form-label">Giá tiền</label>
                <input type="text" class="form-control" id="productPrice"
                     name="productPrice" value="<?=$row['price']?>">
            </div>
            <div class="mb-3">
                <label for="productSale" class="form-label">Sale</label>
                <input type="text" class="form-control" id="productSale"
                     name="productSale" value="<?=$row['sale']*100?>">
            </div>
            <div class="mb-3">
                <label for="productQuantity" class="form-label">Số lượng</label>
                <input type="text" class="form-control" id="productQuantity"
                     name="productQuantity" value="<?=$row['quantity']?>">
            </div>
            <div class="mb-3">
                <label for="productStatus" class="form-label">Trạng thái</label>
                <select class="form-select" aria-label="Default select example" name="productStatus">
                        <option selected>--- Trạng thái ---</option>
                        <?php 
                            $currentStatus = $row['stock_status'];
                            $statusOptions = [
                                'in_stock' => 'Còn hàng',
                                'out_stock' => 'Hết hàng',
                            ];
                            foreach($statusOptions as $value => $label) {
                                $selected = ($value == $currentStatus) ? 'selected' : '';
                                echo "<option value='$value' $selected>$label</option>";
                            }
                        ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="productDesc" class="form-label">Mô tả</label>
                <textarea class="form-control" id="desc" rows="5" name="productDesc">
                    <?=$row['description']?>
                </textarea>
            </div>
            <div class="mb-3">
                <label for="productImg" class="form-label">Image</label>
                <input type="file" class="form-control" id="productImg"
                     name="productImg">
            </div>
            <div class="mb-3">
                <label for="productCreated" class="form-label">Ngày tạo</label>
                <input type="text" class="form-control" id="productCreated"
                    value="<?=$row['created_at']?>" disabled>
            </div>
            <div class="product__btn">
                <button name="submit" type="submit" class="btn btn-info">Sửa sản phẩm</button>
            </div>
        </form>
        <?php 
            }   
        }
        ?>
    </div>

</body>
</html>