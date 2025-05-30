<?php 
    include '../classes/category.php';
?>

<?php 
    $cat = new category();
    if(isset($_GET['delid']) && $_GET['delid'] != NULL) {
        $id = $_GET['delid'];

        $delcat = $cat->deleteCatById($id);
    } 



?>
<table class="table">
        <?php
            if(isset($delcat)) {
                if($delcat === "Xóa thành công!") {
                    echo '<div class="alert alert-success" role="alert">' . $delcat . '</div>';
                }else {
                    echo '<div class="alert alert-danger" role="alert">' . $delcat . '</div>';
                }
            }
        ?>
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">ID</th>
            <th scope="col">Tên danh mục</th>
            <th scope="col">Mô tả</th>
            <th scope="col">Ngày tạo</th>
            <th scope="col">Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $show_cate = $cat->selectCategory();
            if($show_cate) {
                $i = 0;
                while($row = $show_cate->fetch_assoc()) {
                    $i++;
        ?>
        <tr>
            <th scope="row"><?=$i?></th>
            <td><?=$row['id']?></td>
            <td><?=$row['name']?></td>
            <td><?=$row['description']?></td>
            <td><?=$row['created_at']?></td>
            <td>
                <div class="action__product">
                    <a href="./catedit.php?catid=<?=$row['id']?>" class="btn btn-success">Sửa</a>
                    <a href="?delid=<?=$row['id']?>" class="btn btn-danger"
                        onclick="return confirm('Bạn có muốn xóa danh mục này không?')"
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