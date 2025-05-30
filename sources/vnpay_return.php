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
    <title>Thanh toán</title>
</head>
    <?php 
        include './inc/header.php';
    ?>
    <?php
    // Định nghĩa các thông số cần thiết cho VNPay
    $vnp_HashSecret = "FYT53VQS52IWNHV9ZBEX4I1FNX6RAEDG"; // Secret key
    // Lấy thông tin trả về từ VNPay
    $vnp_ResponseCode = $_GET['vnp_ResponseCode'];
    $vnp_TxnRef = $_GET['vnp_TxnRef']; // Mã giao dịch
    $vnp_Amount = $_GET['vnp_Amount']; // Số tiền thanh toán
    $vnp_SecureHash = $_GET['vnp_SecureHash'];

    // Xây dựng dữ liệu để xác thực
    $inputData = $_GET;
    unset($inputData['vnp_SecureHash']);
    ksort($inputData);
    $query = http_build_query($inputData);
    $vnpSecureHash = hash_hmac('sha512', $query, $vnp_HashSecret);

    // Kiểm tra chữ ký bảo mật
    if ($vnp_SecureHash === $vnpSecureHash) {
        // Chữ ký hợp lệ, kiểm tra mã phản hồi
        if ($vnp_ResponseCode === '00') {
            $amount = $vnp_Amount / 100; // Chuyển đổi về đơn vị VND
            $userId = Session::get('customer_id'); // Giả sử bạn đã lưu ID người dùng trong session
            $orderId = $order->createNewOrderVNPAY($userId, 'vnpay');
            $delCart = $cart->delAllCart();
            if ($orderId) {
                // Lưu thành công
                header("Location: ./success.php");
                exit();
            } else {
                // Xử lý lỗi lưu vào CSDL
                echo "Có lỗi xảy ra khi lưu đơn hàng.";
            }
        } else {
            // Thanh toán không thành công
            echo "Thanh toán không thành công. Mã phản hồi: " . $vnp_ResponseCode;
        }
    } else {
        // Chữ ký không hợp lệ
        echo "Chữ ký không hợp lệ.";
    }
    ?>
</body>
</html>