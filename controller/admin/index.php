<?php
include "./model/class/class_admin.php";
$db = new admin();

$page = '';

if(isset($_GET['page'])) {
    $page = $_GET['page'];
}

switch($page) {
    // category
    case 'add_category': {
        include "./view/admin/header_admin.php";
        include "./view/admin/admin_left.php";
        include "./view/admin/add_category.php";

        if(isset($_POST['category_name'])) {
            if($db->addCategory($_POST['category_name'])) {
                echo "<script>alert('Thêm thành công!')</script>";
            }
            else {
                echo "<script>alert('Thêm không thành công!')</script>";
            }
        }
        break;
    }

    case 'list_category': {
        $categories = $db->getCategories();
        
        include "./view/admin/header_admin.php";
        include "./view/admin/admin_left.php";
        include "./view/admin/list_category.php";
        break;
    }

    case 'delete_category': {
        if(isset($_GET['category_id'])) {
            if($db->deleteCategory($_GET['category_id'])) {
                echo "<script>alert('Xóa thành công!')</script>";
            }
            else {
                echo "<script>alert('Xóa không thành công!')</script>";
            }
        }

        header('Location: ./index.php?controller=admin&page=list_category');
        break;
    }

    case 'edit_category': {
        if(isset($_GET['category_id'])) {
            $category = $db->getCategory($_GET['category_id']);

            include "./view/admin/header_admin.php";
            include "./view/admin/admin_left.php";
            include "./view/admin/edit_category.php";

            if(isset($_POST['category_name'])) {
                if($db->editCategory($_GET['category_id'], $_POST['category_name'])) {
                    echo "<script>alert('Sửa thành công!')</script>";

                    header('Location: ./index.php?controller=admin&page=list_category');
                }
                else {
                    echo "<script>alert('Sửa không thành công!')</script>";

                    header('Location: ./index.php?controller=admin&page=list_category');
                }
            }
        }
        else {
            header('Location: ./index.php?controller=admin&page=list_category');
        }

        break;
    }

    // product type

    case 'add_product_type': {
        $categories = $db->getCategories();

        include "./view/admin/header_admin.php";
        include "./view/admin/admin_left.php";
        include "./view/admin/add_product_type.php";

        if(isset($_POST['product-type_name'])) {
            if($db->addProductType($_POST['product-type_name'], $_POST['category_id'])) {
                echo "<script>alert('Thêm thành công!')</script>";
            }
            else {
                echo "<script>alert('Thêm không thành công!')</script>";
            }
        }
        break;
    }

    case 'list_product_type': {
        $categories = $db->getCategories();
        $product_types = $db->getProductTypes();
        
        include "./view/admin/header_admin.php";
        include "./view/admin/admin_left.php";
        include "./view/admin/list_product_type.php";
        break;
    }

    case 'edit_product_type': {
        $categories = $db->getCategories();
        if(isset($_GET['product_type_id'])) {
            $product_type = $db->getProductType($_GET['product_type_id']);
            include "./view/admin/header_admin.php";
            include "./view/admin/admin_left.php";
            include "./view/admin/edit_product_type.php";
        }
        else {
            header('location: ./index.php?controller=admin&page=list_product_type');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if($db->editProductType($_GET['product_type_id'], $_POST['product_type_name'], $_POST['category_id'])) {
                echo "<script>alert('Sửa thành công!')</script>";

                header('location: ./index.php?controller=admin&page=list_product_type');
            }
            else {
                echo "<script>alert('Sửa thành công!')</script>";
            }
        }

        break;
    }

    case 'delete_product_type': {
        if(isset($_GET['product_type_id'])) {
            if($db->deleteProductType($_GET['product_type_id'])) {
                echo "<script>alert('Xóa thành công!')</script>";
            }
            else {
                echo "<script>alert('Xóa không thành công!')</script>";
            }
        }

        header('Location: ./index.php?controller=admin&page=list_product_type');
        break;
    }

    // product

    case 'add_product': {
        $categories = $db->getCategories();
        $product_types = $db->getProductTypes();

        // Chuyển đổi mảng thành chuỗi JSON
        $jsonData = json_encode($product_types);

        include "./view/admin/header_admin.php";
        include "./view/admin/admin_left.php";
        include "./view/admin/add_product.php";

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if($db->addProduct($_POST, $_FILES)) {
                echo "<script>alert('Thêm dữ liệu thành công!')</script>";
                echo '<script>window.location.href = "./index.php?controller=admin&page=list_product";</script>';
            }
            else {
                echo '<script>window.location.href = "./index.php?controller=admin&page=list_product";</script>';   
            }
        }

        break;
    }

    case 'list_product': {
        $categories = $db->getCategories();
        $product_types = $db->getProductTypes();
        $products = $db->getProducts();
        $product_imgs_desc = $db->getImgsDesc();
        $product_color = $db->getColors();

        include "./view/admin/header_admin.php";
        include "./view/admin/admin_left.php";
        include "./view/admin/list_product.php";

        break;
    }

    case 'edit_product': {
        $categories = $db->getCategories();
        $product_types = $db->getProductTypes();

        if(!isset($_GET['product_id']) || $_GET['product_id'] == '') {
            header('location: ./index.php?controller=admin&page=list_product');
        }
        $product = $db->getProduct($_GET['product_id']);

        $product_img_desc = $db->getImgDesc($_GET['product_id']);

        $product_color = $db->getColor($_GET['product_id']);

        // Lấy category và product type của product hiện tại
        $product_type_prd = $db->getProductType($product['product_type_id']);
        $category_prd = $db->getCategory($product_type_prd['category_id']);

        $product_type_ctg = $db->getProductTypes_w_categoryId($category_prd['category_id']);

        // Chuyển đổi mảng thành chuỗi JSON
        $jsonData = json_encode($product_types);

        include "./view/admin/header_admin.php";
        include "./view/admin/admin_left.php";
        include "./view/admin/edit_product.php";

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if($db->editProduct($_POST, $_FILES)) {
                echo "<script>alert('Sửa dữ liệu thành công!')</script>";
                echo '<script>window.location.href = "./index.php?controller=admin&page=list_product";</script>';
            }
            else {
                echo "<script>alert('Sửa dữ liệu không thành công!')</script>";
            }
        }

        break;
    }

    case 'delete_product': {
        if(isset($_GET['product_id'])) {
            if($db->deleteProduct($_GET['product_id'])) {
                echo "<script>alert('Xóa thành công!')</script>";
            }
            else {
                echo "<script>alert('Xóa không thành công!')</script>";
            }
        }

        header('Location: ./index.php?controller=admin&page=list_product');
        break;
    }
    
    default: {
        include "./view/admin/header_admin.php";
        include "./view/admin/admin_left.php";
        echo "view";
    }
}

?>