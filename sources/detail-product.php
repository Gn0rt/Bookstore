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
    <link rel="stylesheet" href="./css/detail-product.css">
    <title>Chi tiết sản phẩm</title>
</head>

<body>
    <?php include './inc/header.php'; ?>
    
    <div id="main">
        <div class="main__content">
            <div class="row">
                <?php 
                    if(isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $getDetailPd = $pd->getProductById($id);
                        if($getDetailPd) {
                            $row = $getDetailPd->fetch_assoc();
                            $newSrc = str_replace('../', './', $row['image']);
                ?>
                <div class="col-md-6">
                    <div class="main__image">
                        <img src="<?=$newSrc?>" alt="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="main__product">
                        <h3 class="main__title">
                            <?=$row['name']?>
                        </h3>
                        <p class="main__price">
                            Giá thành sản phẩm: <strong><?php echo number_format($row['price'], 0, ',', '.'); ?>đ</strong>
                        </p>
                        <p>
                            Giảm giá: <?=$row['sale']*100?>%
                        </p>
                        
                        <!-- Nút mở Modal -->
                        <?php 
                            if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addCart'])) {
                                $sl = $_POST['quantity'];
                                $usid = Session::get('customer_id');
                                $addCart = $cart->addToCart($id, $sl, $usid);
                            }
                        ?>
                        <form action="" method="POST">
                            <p>
                                <span>Số lượng: </span>
                                <input type="number" name="quantity" value="1" min="1">
                            </p>

                            <button class="btn btn-outline-success main__btn-add" type="submit"
                                name="addCart"
                            >
                                Thêm vào giỏ hàng
                            </button>
                        </form>
                        
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="main__desc">
                        <h3>Giới thiệu về sản phẩm</h3>
                        <p>
                            <?=$row['description']?>
                        </p>
                    </div>
                </div>
                <?php    
                        }
                    }
                ?>
                
            </div>
        </div>
    </div>


    <?php 
        include './inc/footer.php';
    ?>


    <script src="./js/buy.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>