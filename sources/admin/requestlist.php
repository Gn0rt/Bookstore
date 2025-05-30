<?php 
    include '../classes/request.php';
    include_once '../classes/product.php';

    $rq = new request();
    $pd = new product();

?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng yêu cầu</th>
            <th>Trạng thái</th>
            <th>Ngày yêu cầu</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $requests = $rq->getRestockRequests();
        if ($requests) {
            while ($req = $requests->fetch_assoc()) {
                $id = $req['product_id'];
                $prod = $pd->getProductById($id);
                $rs = $prod->fetch_assoc();
        ?>
        <tr>
            <td><?= $req['id'] ?></td>
            <td><?= htmlspecialchars($rs['name']) ?></td>
            <td><?= $req['quantity'] ?></td>
            <td>
                <span class="badge bg-<?= 
                    $req['status'] == 'pending' ? 'warning' : 
                    ($req['status'] == 'approved' ? 'success' : 'danger')
                ?>">
                    <?= $req['status'] ?>
                </span>
            </td>
            <td><?= date('d/m/Y H:i', strtotime($req['request_date'])) ?></td>
        </tr>
        <?php
            }
        } else {
            echo '<tr><td colspan="5" class="text-center">Không có yêu cầu nào</td></tr>';
        }
        ?>
    </tbody>
</table>