<?php 
    include '../classes/user.php';
?>
<?php 
    $us = new user();
    if(isset($_GET['delus']) && $_GET['delus'] != NULL) {
        $id = $_GET['delus'];

        $delUs = $us->deleteUserById($id);
    } 

?>
<?php 
    if(isset($delUs)) {
        echo $delUs;
    }
?>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">ID</th>
            <th scope="col">User</th>
            <th scope="col">Password</th>
            <th scope="col">Email</th>
            <th scope="col">Họ tên</th>
            <th scope="col">SDT</th>
            <th scope="col">Ngày tạo</th>
            <th scope="col">Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $getUs = $us->getUser();
            if($getUs) {
                $i = 0;
                while($row = $getUs->fetch_assoc()) {
                    $i++;
        ?>
        <tr>
            <th scope="row"><?=$i?></th>
            <td><?=$row['id']?></td>
            <td><?=$row['username']?></td>
            <td><?=$row['password']?></td>
            <td><?=$row['email']?></td>
            <td><?=$row['fullname']?></td>
            <td><?=$row['phone']?></td>
            <td><?=$row['created_at']?></td>
            <td>
                <div class="action__product">
                    <a href="./customeredit.php?cusid=<?=$row['id']?>" class="btn btn-success">Sửa</a>
                    <a href="?delus=<?=$row['id']?>" class="btn btn-danger"
                    onclick="return confirm('Bạn có muốn xóa người dùng này không?')"
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