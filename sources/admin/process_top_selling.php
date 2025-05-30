<?php
include '../classes/product.php';

// Kiểm tra nếu là request AJAX
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['findTopSelling'])) {
    $pd = new product();
    $month = (int)$_POST['month'];
    $year = (int)$_POST['year'];
    
    $topSellingProducts = $pd->getTopSellingProductsByMonth($month, $year);
    
    if ($topSellingProducts && $topSellingProducts->num_rows > 0) {
        echo '<h3 class="report-title">Sản phẩm bán chạy nhất trong tháng '.$month.'/'.$year.'</h3>';
        echo '<table class="report-table">';
        echo '<thead><tr><th>ID</th><th>Tên sản phẩm</th><th>Số lượng đã bán</th></tr></thead>';
        echo '<tbody>';
        
        while ($row = $topSellingProducts->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
            echo '<td>' . (int)$row['total_quantity'] . '</td>';
            echo '</tr>';
        }
        
        echo '</tbody></table>';
    } else {
        echo '<div class="report-no-data">Không có sản phẩm nào được bán trong tháng '.$month.'/'.$year.'.</div>';
    }
}
?>