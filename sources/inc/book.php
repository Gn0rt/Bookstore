<?php 
    include_once './lib/database.php';
    
    // Lấy tham số category từ URL
    $category = $_GET['category'] ?? 'technology'; // Mặc định là 'technology'
    // Chuyển đổi tên danh mục thành giá trị trong database
    $category_map = [
        'technology' => 'cong-nghe',
        'children' => 'thieu-nhi',
        'literature' => 'van-hoc',
        'lifestyle' => 'doi-song'
    ];
    $db_category = $category_map[$category] ?? 'cong-nghe';
    $getBookPd = $pd->getProductsByCategory($db_category);
    if($getBookPd) {
        while($row = $getBookPd->fetch_assoc()) {
            echo "
                <a href='' class='book__care-content-item'>
                    <img src='..{$row['image']}' alt='{$row['name']}'>
                    <div class='book__care-content-box'>
                        <h3>{$row['name']}</h3>
                        <p class='book__care-content-price'>{$row['price']}đ</p>
                    </div>
                </a>
            ";
        }
    }else {
        echo '<p>Không có sản phẩm trong danh mục này</p>';
    }
?>