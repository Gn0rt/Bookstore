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
    <title>Thông tin cá nhân</title>
</head>
<body>
    <?php 
        include './inc/header.php';
    ?>
    <?php 
        $id = Session::get('customer_id');
        if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['updateInfo'])) {
            $updateUser = $user->updateUserById($_POST, $id);
        }
        $getInfoUser = $user->getUserById($id);
    ?>
    <div id="main">
        <div class="main__content">
            <?php 
                if(isset($updateUser)) {
                    echo $updateUser;
                }
            ?>
            <?php 
                if($getInfoUser) {
                    $row = $getInfoUser->fetch_assoc();
            ?>
            <form class="row g-3" method="POST">
                <div class="col-md-6">
                    <label for="inpEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" value="<?=$row['email']?>" name="email" id="inpEmail">
                </div>
                <div class="col-md-6">
                    <label for="inputPassword" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" value="<?=$row['password']?>" name="password" id="inputPassword">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="inputUsername" class="form-label">Username</label>
                    <input type="text" class="form-control" value="<?=$row['username']?>" name="username" id="inputUsername">
                </div>
                <div class="col-md-6">
                    <label for="inputFullname" class="form-label">Họ và Tên</label>
                    <input type="text" class="form-control" value="<?=$row['fullname']?>" name="fullname" id="inputFullname">
                </div>
                <div class="col-md-6">
                    <label for="inputPhone" class="form-label">Phone</label>
                    <input type="text" class="form-control" value="<?=$row['phone']?>" name="phone" id="inputPhone">
                </div>
                <div class="col-md-6">
                    <label for="inputAddress" class="form-label">Địa chỉ</label>
                    <input type="text" class="form-control" value="<?=$row['address']?>" name="address" id="inputAddress">
                </div>
                <div class="col-md-6">
                    <label for="inputCreated" class="form-label">Ngày tạo</label>
                    <input type="text" class="form-control" value="<?=$row['created_at']?>" name="created" id="inputCreated" disabled>
                </div>
                <div class="col-12">
                    <button type="submit" name="updateInfo" class="btn btn-success">Cập nhật</button>
                </div>
            </form>
            <?php 
                    }
            ?>
        </div>
    </div>
    <?php 
        include './inc/footer.php';
    ?>

    <script src="./js/toggle.js"></script>
</body>
</html>