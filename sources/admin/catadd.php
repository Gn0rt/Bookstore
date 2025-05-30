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
        <title>Thêm danh mục</title>
</head>
<body>
    <?php include './inc/header.php'; ?>
    <?php 
    include '../classes/category.php';
    ?>
    <?php 
        $cat = new category();
        if($_SERVER['REQUEST_METHOD'] === "POST" ) {
            $catName = $_POST['categoryName'];
            $descName = $_POST['descName'];
            $insertCat = $cat->insertCategory($catName, $descName);
        }
    ?>
    <div id="main">
        <div class="backToHome">
            <a href="./index1.php" type="button" class="btn btn-secondary">Trở về</a>
        </div>
        <?php 
            if(isset($insertCat) && $catName !== "") {
                echo '<div class="alert alert-success" role="alert">' . $insertCat . '</div>';
            }else if(isset($insertCat) && $catName === ""){
                echo '<div class="alert alert-danger" role="alert">' . $insertCat . '</div>';
            }
        ?>
        <form action="catadd.php" method="POST">
            <div class="mb-3">
                <label for="categoryLabel" class="form-label">Danh mục</label>
                <input type="text" class="form-control" id="categoryInput"
                    placeholder="Thêm danh mục mới!" name="categoryName">
            </div>
            <div class="mb-3">
                <label for="descLabel" class="form-label">Mô tả</label>
                <input type="text" class="form-control" id="descInput"
                    placeholder="Mô tả" name="descName">
            </div>
            <div class="category__add">
                <button href="" type="submit" class="btn btn-info">Thêm danh mục</button>
            </div>
        </form>
        
    </div>

</body>
</html>