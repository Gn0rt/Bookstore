<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/login.css">
    <title>Đăng nhập</title>
</head>

<body>
    <?php 
        include './lib/session.php';
        Session::init();
    ?>
    <?php 
        include './classes/user.php';
    ?>
    <?php 
        $check = Session::get('customer_login');
        if($check) {
            header("Location: index.php");
        }
    ?>
    <?php 
        $us = new user();
        if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['btnLogin'])) {
            $login_check = $us->loginUser($_POST);
        }
    ?>
    <?php 
        if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['register'])) {
            $insertCustomer = $us->insertCustomer($_POST);
            // Nếu đăng ký thành công, có thể redirect hoặc hiển thị thông báo
            if(strpos($insertCustomer, 'thành công') !== false) {
                // Ví dụ: reload trang để tránh submit lại form
                echo "<script>window.location.href = window.location.href;</script>";
            }
        }
    ?>
    <div id="container">
        <?php 
            if(isset($insertCustomer)) {
                echo $insertCustomer;
            }
        ?>
        <?php 
            if(isset($login_check)) {
                echo $login_check;
            }
        ?>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                    type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Đăng nhập</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                    type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Đăng ký</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                tabindex="0">
                <form id="formLogin" action="" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    </div>
                    <button type="submit" name="btnLogin" class="btn btn-primary">Đăng nhập</button>
                </form>
            </div>
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                <form id="formRegister" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div class="mb-3">
                            <label for="reg_email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="reg_email" name="reg_email" placeholder="Email">
                        </div>
                        <div class="mb-3">
                            <label for="reg_password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="reg_password" name="reg_password" placeholder="Password">
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Nhập lại mật khẩu</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Password">
                            <p id="password-feedback"></p>
                        </div>
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Họ Tên</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Họ Tên">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">User Name</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="User">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Số điện thoại">
                        </div>
                        <button disabled type="submit" name="register" class="btn btn-primary">Đăng ký</button>
                </form>
            </div>

        </div>
    </div>
    <script src="./js/checkRegis.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>