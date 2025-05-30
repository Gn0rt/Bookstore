
<?php
    include '../classes/product.php';

?>

<?php 

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['findTopSelling'])) {
        $pd = new product();

        $month = (int)$_POST['month'];
        $year = (int)$_POST['year'];
        
        $topSellingProducts = $pd->getTopSellingProductsByMonth($month, $year);
        
        if ($topSellingProducts && $topSellingProducts->num_rows > 0) {
            echo '<h2>Sản phẩm bán chạy nhất trong tháng '.$month.'/'.$year.'</h2>';
            echo '<table class="table">';
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
            echo '<p>Không có sản phẩm nào được bán trong tháng này.</p>';
        }
    }

?>
<form action="" method="POST">
    <label for="month">Chọn tháng:</label>
    <select name="month" id="month">
        <?php for ($m = 1; $m <= 12; $m++): ?>
            <option value="<?= $m ?>"><?= $m ?></option>
        <?php endfor; ?>
    </select>
    
    <label for="year">Chọn năm:</label>
    <select name="year" id="year">
        <?php for ($y = date('Y'); $y >= 2000; $y--): ?>
            <option value="<?= $y ?>"><?= $y ?></option>
        <?php endfor; ?>
    </select>
    
    <button type="submit"  name="findTopSelling">Tìm kiếm</button>
</form>
