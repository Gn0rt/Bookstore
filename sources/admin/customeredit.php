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
        <title>Sửa thông tin khách hàng</title>
</head>
<body>
    <?php include './inc/header.php'; ?>
    <?php 
    include '../classes/user.php';
    ?>
    <?php
        if(isset($_GET['cusid']) && $_GET['cusid'] != NULL) {
            $id = $_GET['cusid'];
        } 
        $cus = new user();
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateCus'])) {
            $updateCus = $cus->updateUserById($_POST, $id);
        }
        

        
        
    ?>
    <div id="main">
        <div class="backToHome">
            <a href="./index1.php" type="button" class="btn btn-secondary">Trở về</a>
        </div>
        <?php
            
        ?>
        <?php 
            $getCus = $cus->getUserById($id);
            if($getCus) {
                while($row = $getCus->fetch_assoc()) {
        ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="userId" class="form-label">ID</label>
                <input type="text" class="form-control" id="userId"
                    value="<?=$row['id']?>" name="userId" disabled>
            </div>
            <div class="mb-3">
                <label for="usname" class="form-label">Username</label>
                <input type="text" class="form-control" id="usname"
                     name="username" value="<?=$row['username']?>">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="text" class="form-control" id="password"
                     name="password" value="<?=$row['password']?>">
            </div>
            <div class="mb-3">
                <label for="emailUs" class="form-label">Email</label>
                <input type="text" class="form-control" id="emailUs"
                     name="email" value="<?=$row['email']?>" >
            </div>
            <div class="mb-3">
                <label for="fullname" class="form-label">Họ và tên</label>
                <input type="text" class="form-control" id="fullname"
                     name="fullname" value="<?=$row['fullname']?>" >
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">SDT</label>
                <input type="text" class="form-control" id="phone"
                     name="phone" value="<?=$row['phone']?>" >
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Địa chỉ</label>
                <input type="text" class="form-control" id="address"
                     name="address" value="<?=$row['address']?>" >
            </div>
            <div class="mb-3">
                <label for="created" class="form-label">Ngày tạo</label>
                <input type="text" class="form-control" id="created"
                     name="created" value="<?=$row['created_at']?>" disabled>
            </div>
            <div class="category__add category__btn">
                <button name="updateCus" type="submit" class="btn btn-info">Sửa thông tin</button>
            </div>
        </form>
        <?php 
                }
            }   
        ?>
    </div>

</body>
</html>