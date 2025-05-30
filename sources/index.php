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
    <link rel="stylesheet" href="./css/index.css">
    <title>Trang chủ</title>
</head>

<body>
    <?php 
        include './inc/header.php';
    ?>

    <div id="content">
        <?php 
            include './inc/slider.php';
        ?>
        <div id="introduce">
            <div class="introduce__contain">
                <div class="introduce__content">
                    <h3 class="introduce__title">Bookstore - gieo mầm chi thức</h3>
                    <p class="introduce__text">
                        Phương châm hoạt động của Bookstore là tạo ra những sản phẩm xuất bản mang tính trí tuệ,
                        giải trí và giáo dục chất lượng để đem đến cho bạn đọc những giá trị cốt lõi và thực sự có ý
                        nghĩa trong cuộc sống hàng ngày.
                        Bookstore luôn luôn xác định sứ mệnh và trách nhiệm của mình đến với cộng đồng là lan tỏa
                        và phát triển văn hóa đọc đến mọi người, mọi nhà, và mọi lúc, mọi nơi.
                    </p>
                    <a href="./about-us.php" class="introduce__btn">Xem thêm</a>
                </div>
                <div class="introduce__img">
                    <img src="./images/bookstore.png" alt="">
                </div>
            </div>
        </div>

        <div id="book__care" class="care">
            <h2 class="book__care-title">
                Sách được quan tâm
            </h2>

            <ul class="book__care-list list__contain1">
                <li class="book__care-item active" data-target="wrapper1" data-category="technology">Công nghệ</li>
                <li class="book__care-item" data-target="wrapper2" data-category="children">Thiếu nhi</li>
                <li class="book__care-item" data-target="wrapper3" data-category="literature">Văn học</li>
                <li class="book__care-item" data-target="wrapper4" data-category="life">Đời sống</li>
            </ul>

            <div class="book__care-contain contain1">
                <div class="book__care-btn">
                    <button class="nav-button prev-button">&lt;</button>
                    <button class="nav-button next-button">&gt;</button>
                </div>
                <div class="book__care-wrapper book__care-box active" id="wrapper1">
                    <div class="book__care-container">
                        <?php 
                            $getTech = $pd->getProductByType('tech');
                            if($getTech) {
                                $count = 0;
                                while($row = $getTech->fetch_assoc()) {
                                    if($count > 10) {
                                        break;
                                    }
                                    $newSrc = str_replace('../', './', $row['image']);
                        ?>
                        <a href="./detail-product.php?id=<?=$row['id']?>" class="book__care-content-item">
                            <img src="<?=$newSrc?>" alt="<?=$row['name']?>">
                            <div class="book__care-content-box">
                                <h3><?=$row['name']?></h3>
                                <p class="book__care-content-price"><?php echo number_format($row['price'], 0, ',', '.'); ?>đ</p>
                            </div>
                        </a>
                        <?php 
                                    $count++;
                                }
                            }
                        ?>
                    </div>
                </div>
                <div class="book__care-wrapper book__care-box" id="wrapper2">
                    <!-- Container chứa các sản phẩm -->
                    <div class="book__care-container">
                        <?php 
                            $getChild = $pd->getProductByType('children');
                            if($getChild) {
                                $count = 0;
                                while($row = $getChild->fetch_assoc()) {
                                    if($count > 10) {
                                        break;
                                    }
                                    $newSrc = str_replace('../', './', $row['image']);
                        ?>
                        <a href="./detail-product.php?id=<?=$row['id']?>" class="book__care-content-item">
                            <img src="<?=$newSrc?>" alt="<?=$row['name']?>">
                            <div class="book__care-content-box">
                                <h3><?=$row['name']?></h3>
                                <p class="book__care-content-price"><?php echo number_format($row['price'], 0, ',', '.'); ?>đ</p>
                            </div>
                        </a>
                        <?php 
                                    $count++;
                                }
                            }
                        ?>
                    </div>
                </div>
                <div class="book__care-wrapper book__care-box" id="wrapper3">
                    <!-- Container chứa các sản phẩm -->
                    <div class="book__care-container">
                        <?php 
                            $getChild = $pd->getProductByType('literature');
                            if($getChild) {
                                $count = 0;
                                while($row = $getChild->fetch_assoc()) {
                                    if($count > 10) {
                                        break;
                                    }
                                    $newSrc = str_replace('../', './', $row['image']);
                        ?>
                        <a href="./detail-product.php?id=<?=$row['id']?>" class="book__care-content-item">
                            <img src="<?=$newSrc?>" alt="<?=$row['name']?>">
                            <div class="book__care-content-box">
                                <h3><?=$row['name']?></h3>
                                <p class="book__care-content-price"><?php echo number_format($row['price'], 0, ',', '.'); ?>đ</p>
                            </div>
                        </a>
                        <?php 
                                    $count++;
                                }
                            }
                        ?>
                    </div>
                </div>
                <div class="book__care-wrapper book__care-box" id="wrapper4">
                    <!-- Container chứa các sản phẩm -->
                    <div class="book__care-container">
                        <?php 
                            $getChild = $pd->getProductByType('literature');
                            if($getChild) {
                                $count = 0;
                                while($row = $getChild->fetch_assoc()) {
                                    if($count > 10) {
                                        break;
                                    }
                                    $newSrc = str_replace('../', './', $row['image']);
                        ?>
                        <a href="./detail-product.php?id=<?=$row['id']?>" class="book__care-content-item">
                            <img src="<?=$newSrc?>" alt="<?=$row['name']?>">
                            <div class="book__care-content-box">
                                <h3><?=$row['name']?></h3>
                                <p class="book__care-content-price"><?php echo number_format($row['price'], 0, ',', '.'); ?>đ</p>
                            </div>
                        </a>
                        <?php 
                                    $count++;
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="book__care-more">
                <?php 
                    if($checkSession) {
                        echo '
                            <a href="./shopp.php">Xem thêm</a>
                        ';
                    }else {
                        echo '
                            <a href="./login.php">Xem thêm</a>
                        ';
                    }
                ?>
            </div>
        </div>

        <div id="toy__care" class="care">
            <h2 class="book__care-title">
                Đồ chơi được quan tâm
            </h2>

            <div class="book__care-contain">
                <div class="book__care-btn">
                    <button class="nav-button prev-button">&lt;</button>
                    <button class="nav-button next-button">&gt;</button>
                </div>

                <div class="book__care-wrapper book__care-box active toy__care-wrapper">
                    <!-- Container chứa các sản phẩm -->
                    <div class="book__care-container">
                        <?php 
                            $getPd = $pd->getProductByImage('toy');
                            if($getPd) {
                                $count = 0;
                                while($row = $getPd->fetch_assoc()) {  
                                    if($count > 10) {
                                        break;
                                    } 
                                    $newSrc = str_replace('../', './', $row['image']);
                        ?>
                        <a href="./detail-product.php?id=<?=$row['id']?>" class="book__care-content-item">
                            <img src="<?=$newSrc?>" alt="<?=$row['name']?>">
                            <div class="book__care-content-box">
                                <h3><?=$row['name']?></h3>
                                <p class="book__care-content-price"><?php echo number_format($row['price'], 0, ',', '.'); ?>đ</p>
                            </div>
                        </a>
                        <?php 
                                    $count++;
                                }
                            }
                        ?>
                    </div>
                </div>

            </div>
            <div class="book__care-more">
                <?php 
                    if($checkSession) {
                        echo '
                            <a href="./shopp.php">Xem thêm</a>
                        ';
                    }else {
                        echo '
                            <a href="./login.php">Xem thêm</a>
                        ';
                    }
                ?>
            </div>
        </div>

        <div id="school__care" class="care">
            <h2 class="book__care-title">
                Dụng cụ học tập
            </h2>

            <div class="book__care-contain">
                <div class="book__care-btn">
                    <button class="nav-button prev-button">&lt;</button>
                    <button class="nav-button next-button">&gt;</button>
                </div>

                <div class="book__care-wrapper book__care-box active toy__care-wrapper">
                    <!-- Container chứa các sản phẩm -->
                    <div class="book__care-container">
                        <?php 
                                $getPd = $pd->getProductByImage('school');
                                if($getPd) {
                                    $count = 0;
                                    while($row = $getPd->fetch_assoc()) {  
                                        if($count > 10) {
                                            break;
                                        } 
                                        $newSrc = str_replace('../', './', $row['image']);
                            ?>
                            <a href="./detail-product.php?id=<?=$row['id']?>" class="book__care-content-item">
                                <img src="<?=$newSrc?>" alt="<?=$row['name']?>">
                                <div class="book__care-content-box">
                                    <h3><?=$row['name']?></h3>
                                    <p class="book__care-content-price"><?php echo number_format($row['price'], 0, ',', '.'); ?>đ</p>
                                </div>
                            </a>
                            <?php 
                                        $count++;
                                    }
                                }
                            ?>
                    </div>
                </div>

            </div>
            <div class="book__care-more">
                <?php 
                    if($checkSession) {
                        echo '
                            <a href="./shopp.php">Xem thêm</a>
                        ';
                    }else {
                        echo '
                            <a href="./login.php">Xem thêm</a>
                        ';
                    }
                ?>
            </div>
        </div>
    </div>

    <?php 
        include './inc/footer.php';
    ?>
    <?php 
        include './inc/backtotop.php';

    ?>
    <script src="./js/index.js"></script>
    <script src="./js/backtotop.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://app.tudongchat.com/js/chatbox.js"></script>
    <script>
        const tudong_chatbox = new TuDongChat('chE8-BapbW7SgTJmi6dUx')
        tudong_chatbox.initial()
    </script>
</body>

</html>