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
    <title>Thêm sản phẩm</title>
</head>
<body>
    <?php include './inc/header.php'; ?>
    <?php 
        include '../classes/category.php';
    ?>
    <?php
        include '../classes/product.php';
    ?>
    <?php 
        $pd = new product();
        if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
            $inserProduct = $pd->insertProduct($_POST, $_FILES);
        }
    ?>
    <div id="main">
        <div class="backToHome">
            <a href="./index1.php" type="button" class="btn btn-secondary">Trở về</a>
        </div>
        <?php 
            if(isset($inserProduct)) {
                if($inserProduct === "Thêm sản phẩm thành công!") {
                    echo '<div class="alert alert-success" role="alert">' . $inserProduct . '</div>';
                }else {
                    echo '<div class="alert alert-danger" role="alert">' . $inserProduct . '</div>';
                }
            }
        ?>
        <form action="productadd.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nameProduct" class="form-label">Tên sản phẩm</label>
                <input type="text" class="form-control" id="nameProduct"
                    placeholder="Tên sản phẩm!" name="nameProduct">
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Danh mục</label>
                <select class="form-select" aria-label="Default select example" name="category">
                        <option selected>-- Danh mục sản phẩm --</option>
                    <?php 
                        $cat = new category();
                        $catlist = $cat->selectCategory();
                        if($catlist) {
                            while($row = $catlist->fetch_assoc()) {
                    ?>
                        <option value="<?=$row['id']?>"><?=$row['id']?> - <?=$row['name']?></option>
                    <?php 
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="productType" class="form-label">Thể loại</label>
                <select class="form-select" aria-label="Default select example" name="productType">
                        <option selected>--- Thể loại ---</option>
                        <option value="tech">Công nghệ</option>
                        <option value="literature">Văn học</option>
                        <option value="life">Đời sống</option>
                        <option value="children">Trẻ em</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="priceProduct" class="form-label">Giá tiền</label>
                <input type="text" class="form-control" id="priceProduct"
                    placeholder="Giá tiền" name="priceProduct">
            </div>
            <div class="mb-3">
                <label for="sale" class="form-label">Giảm giá</label>
                <input type="text" class="form-control" id="sale"
                    placeholder="Sale" name="sale">
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Số lượng</label>
                <input type="text" class="form-control" id="quantity"
                    placeholder="Số lượng" name="quantity">
            </div>
            <div class="mb-3">
                <label for="desc" class="form-label">Mô tả</label>
                <textarea class="form-control" id="desc" rows="5" name="desc"></textarea>
            </div>
            <div class="mb-3">
                <label for="imageProduct" class="form-label">Hình ảnh</label>
                <input type="file" class="form-control" id="imageProduct"
                    placeholder="ảnh" name="imageProduct">
            </div>
            <div class="product__add">
                <button type="submit" name="submit" class="btn btn-info">Thêm danh mục</button>
            </div>
        </form>
        
    </div>

    
</body>
</html>