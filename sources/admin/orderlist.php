<?php 
    include '../classes/order.php';
?>
<?php 
    $od = new order();

    if(isset($_GET['delod']) && $_GET['delod'] != NULL) {
        $id = $_GET['delod'];

        $delOd = $od->deleteOrderById($id);
    } 
?>
<?php 
    if(isset($delUs)) {
        echo $delUs;
    }
    // Thiết lập phân trang
    $perPage = 5; // Số đơn hàng mỗi trang
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($currentPage - 1) * $perPage;

    $orders = $od->getOrdersList($perPage, $offset);
    $totalOrders = $od->countOrders(); // Hàm đếm tổng số đơn hàng
    $totalPages = max(1, ceil($totalOrders / $perPage)); // Đảm bảo có ít nhất 1 trang

?>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Tên khách hàng</th>
            <th scope="col">Tổng giá tiền</th>
            <th scope="col">Ngày đặt hàng</th>
            <th scope="col">Trạng thái</th>
            <th scope="col">Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            foreach ($orders as $order):
        ?>
        <tr>
            <th scope="row"><?=$order['id']?></th>
            <td><?=$order['customer_name']?></td>
            <td><?= number_format($order['total_price'], 0, ',', '.') ?>đ</td>
            <td><?=$order['order_date']?></td>
            <td><?=$order['status']?></td>
            <td>
                <div class="action__product">
                    <a href="?delod=<?=$order['id']?>" class="btn btn-danger"
                        onclick="return confirm('Bạn có muốn xóa đơn hàng này không?')"
                    >Xóa</a>
                    <a href="./orderedit.php?odid=<?=$order['id']?>" class="btn btn-warning">Xem</a>

                </div>
            </td>
        </tr>
        <?php 
            endforeach;
        ?>
    </tbody>
</table>

<!-- Phân trang -->
<?php if($totalPages > 1): ?>
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center mt-4">

        <li class="page-item <?= $currentPage == 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?=$currentPage-1?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        
        <?php 
        $startPage = max(1, $currentPage - 2);
        $endPage = min($totalPages, $currentPage + 2);
        
        if($startPage > 1) {
            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
        
        for($i = $startPage; $i <= $endPage; $i++): ?>
            <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?=$i?>"><?=$i?></a>
            </li>
        <?php endfor; 
        
        if($endPage < $totalPages) {
            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
        ?>
        
        <li class="page-item <?= $currentPage == $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?=$currentPage+1?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>

    </ul>
</nav>
<?php endif; ?>