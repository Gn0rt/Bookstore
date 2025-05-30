    <?php 
        include '../classes/product.php';
    ?>
    <?php 
        $pd = new product();
        if(isset($_GET['delpdid']) && $_GET['delpdid'] != NULL) {
            $id = $_GET['delpdid'];
            $delpd = $pd->deleteProductById($id);
        } 
    ?>
    <?php 
        if(isset($delpd)) {
            echo $delpd;
        }
        // Phân trang
        $limit = 10; // Số sản phẩm mỗi trang
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Lấy số trang hiện tại
        $offset = ($currentPage - 1) * $limit; // Tính toán offset
    ?>
    <?php 
        $getProduct = false;
        if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['findProduct'])) {
            $searchTerm = $_POST['search'] ?? '';
            $getProduct = $pd->selectProductCat1( $limit,$offset, $searchTerm);
        }
        // Nếu không có tìm kiếm hoặc không tìm thấy kết quả, hiển thị tất cả sản phẩm
        if(!$getProduct) {
            $getProduct = $pd->selectProductCat($limit, $offset);
        }
    
    ?>
<form action="" method="POST" class="form__search">
    <input type="text" name="search" placeholder="Nhập gì đó ...." value="">
    <button type="submit" name="findProduct" class="btn btn-primary">Tìm kiếm</button>
</form>
<form class="filter_type" method="GET">
    <input type="hidden" name="action" value="filter_type">
    <span>Thể loại: </span>
    <select name="type" id="product_type" onchange="this.form.submit()">
        <option value="">--- Thể loại ---</option>
        <?php 
            $types = $pd->getTypeProduct();
            $selectedType = isset($_GET['type']) ? $_GET['type'] : '';
            foreach($types as $type) {
                $selected = ($type === $selectedType) ? 'selected' : '';
        ?>
        <option value="<?=$type?>" <?=$selected?>><?=$type?></option>
        <?php } ?>
    </select>
    
</form>
<?php 
        if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['action']) && $_GET['action'] == 'filter_type') {
            // Xử lý lọc theo thể loại
            $selectedType = isset($_GET['type']) ? $_GET['type'] : '';
            $getProduct = $pd->selectProductType(10, 0, $selectedType);
            
            // Hiển thị sản phẩm
        }
?>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">ID</th>
            <th scope="col">Tên sản phẩm</th>
            <th scope="col">Hình ảnh</th>
            <th scope="col">Danh mục</th>
            <th scope="col">SL</th>
            <th scope="col">Giá bán</th>
            <th scope="col">Sale</th>
            <th scope="col">Status</th>
            <th scope="col">Loại</th>
            <th scope="col">Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            // $pdlist = $pd->selectProductCat($limit, $offset);
            $totalProducts = $pd->countProducts(); // Đếm tổng số sản phẩm
            $totalPages = ceil($totalProducts / $limit); // Tính số trang
            if($getProduct) {
                $i = $offset;
                while($row = $getProduct->fetch_assoc()) {
                    $i++;
        ?>            
        <tr>
            <th scope="row"><?=$i?></th>
            <td><?=$row['pd_id']?></td>
            <td class="truncate"><?=$row['pd_name']?></td>
            <td class="product__image"><img src="<?=$row['image']?>" alt=""></td>
            <td><?=$row['cat_name']?></td>
            <td><?=$row['quantity']?></td>
            <td><?=$row['price']?></td>
            <td><?=$row['sale']*100?>%</td> 
            <td><?=$row['stock_status']?></td>
            <td><?=$row['type']?></td>
            <td>
                <div class="action__product d-flex">
                    <a href="./productedit.php?productid=<?=$row['pd_id']?>" type="button" class="btn btn-success">Sửa</a>
                    <a href="?delpdid=<?=$row['pd_id']?>" class="btn btn-danger"
                        onclick="return confirm('Bạn có muốn xóa sản phẩm này không?')"
                    >Xóa</a>
                </div>
            </td>
        </tr> 
        <?php 
                }
            }
        ?>
    </tbody>
</table>
<!-- Phân trang -->
<nav aria-label="Page navigation example">
    <ul class="pagination">
        <li class="page-item <?= ($currentPage == 1) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $currentPage - 1 ?>">Previous</a>
        </li>
        <?php for ($page = 1; $page <= $totalPages; $page++): ?>
            <li class="page-item <?= ($currentPage == $page) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $page ?>"><?= $page ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?= ($currentPage == $totalPages) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $currentPage + 1 ?>">Next</a>
        </li>
    </ul>
</nav>
