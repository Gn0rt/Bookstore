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
    <link rel="stylesheet" href="./css/onlinepayment.css">
    <title>Document</title>
</head>
<body>
    <?php 
        include './inc/header.php';
    ?>

    <div id="main">
        <form action="orderonline.php" method="POST">
            <h3>Cổng thanh toán</h3>
            <button class="btn btn-primary" >
                <img src="./images/vnpay.png" alt="vnpay" class="logo-method">
                VNPAY
            </button>
        </form>
        <div class="future">
            <h3>Cập nhật trong tương lai</h3>
            <button class="btn btn-danger" disabled>
                <img src="./images/momo.png" alt="momo" class="logo-method">
                MOMO
            </button>
            <button class="btn btn-primary" disabled>
                <img src="./images/zalopay.png" alt="zalopay" class="logo-method">
                Zalo Pay
            </button>

        </div>
    </div>
    <?php 
        include './inc/footer.php';
    ?>
</body>
</html>