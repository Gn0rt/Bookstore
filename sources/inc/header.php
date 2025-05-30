<?php 
    include './lib/session.php';
    Session::init();

?>
<?php 
    include_once './lib/database.php';

    spl_autoload_register(function($className){
        include_once "./classes/".$className.".php";
    }); 
    $db = new Database();
    $cart = new cart();
    $user = new user();
    $cat = new category();
    $pd = new product(); 
    $order = new order();

    $checkSession = Session::get('customer_login');

?>
<header id="header">
        <div class="row d-flex">
            <div class="col-md-6 col-sm-12">
                <div class="header__logo d-flex align-items-center">
                    <a href="./index.php" class="header__logo-content">
                        <img src="./images/logo_store.png" alt="Logo Store">
                    </a>
                    <?php 
                        if($checkSession) {
                            echo '
                                <a href="./cart.php" class="header__cart">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </a>
                            ';
                        }
                        else {
                            echo '
                                <a href="./login.php" class="header__cart">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </a>
                            ';
                        }
                    ?>
                </div>

            </div>
            <div class="col-md-6 col-sm-12 d-flex justify-content-around align-items-center ">
                <div class="header__navigation">
                    <ul class="header__lists d-flex ">
                        <li class="header__item"><a href="./index.php">Trang chủ</a></li>
                        <?php 
                            if($checkSession) {
                                echo '
                                    <li class="header__item"><a href="./shopp.php">Shop</a></li>
                                ';
                            }else {
                                echo '<li class="header__item"><a href="./login.php">Shop</a></li>';                            }
                        ?>
                        <!-- <li class="header__item"><a href="./shop.php">Shop</a></li> -->
                        <li class="header__item"><a href="./about-us.php">Về chúng tôi</a></li>
                    </ul>
                </div>
                <div class="user">
                    <i class="fa-regular fa-circle-user"></i>
                    <ul class="user__options">
                        <?php 
                            if(isset($_GET['action']) && $_GET['action'] == 'logout') {
                                $delCart = $cart->delAllCart();
                                Session::destroy();
                            }
                        ?>
                        <?php 
                            $usname = Session::get('customer_name');
                            if($checkSession) {
                                echo "
                                    <li class='option'><a href='./infouser.php'>Hello, $usname</a></li>
                                    <li class='option'><a href='./orderuser.php'>Xem đơn hàng</a></li>
                                    <li class='option'><a href='?action=logout'>Đăng xuất</a></li>
                                ";
                            }else {
                                echo "<li class='option'><a href='./login.php'>Đăng nhập</a></li>";
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </header>