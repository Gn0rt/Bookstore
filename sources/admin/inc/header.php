<?php 
    include '../lib/session.php';
    Session::checkSession();
?>

<header id="header">
        <div class="row d-flex">
            <div class="col-md-6 col-sm-12">
                <div class="header__logo d-flex align-items-center">
                    <a href="" class="header__logo-content">
                        <img src="./images/logo_store.png" alt="Logo Store">
                    </a>
                </div>

            </div>
            <div class="col-md-6 col-sm-12 d-flex justify-content-end align-items-center ">
                <div class="user">
                    <i class="fa-regular fa-circle-user"></i>
                    <ul class="user__options">
                        <?php 
                            if(isset($_GET['action']) && $_GET['action'] == 'logout') {
                                Session::destroy();
                            }
                        ?>
                        <li class="option"><a href="?action=logout">Đăng xuất</a></li>
                        <li class="option"><a href=""><?php echo Session::get('admin_user') ?></a></li>

                    </ul>
                </div>
            </div>
        </div>
    </header>