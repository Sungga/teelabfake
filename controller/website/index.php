<?php
include "./model/class/class_website.php";

$db = new website();
?>

<?php
$page = '';

if(isset($_GET['page'])) {
    $page = $_GET['page'];
}

switch($page) {
    case 'product_type': {
        if(isset($_GET['product_type_id'])) {
            $categories = $db->getCategories();
            $product_types = $db->getProductTypes();

            $product_type = $db->getProductType($_GET['product_type_id']);
            $category = $db->getCategory($product_type['category_id']);
            $products = $db->getProducts_w_productTypeId($_GET['product_type_id']);
            $colors = $db->getColors();

            include "./view/website/header_website.php";
            include "./view/website/list_product.php";
            include "./view/website/footer_website.php";
        }
        else {
            header('location: .');
        }

        break;
    }

    case 'product': {
        if(isset($_GET['product_id']) && $_GET['product_id'] != '') {
            $categories = $db->getCategories();
            $product_types = $db->getProductTypes();

            include "./view/website/header_website.php";
            include "./view/website/footer_website.php";
        }
        else {
            header('location: .');
        }

        break;
    }

    default: {
        $categories = $db->getCategories();
        $product_types = $db->getProductTypes();

        include "./view/website/header_website.php";
        include "./view/website/home.php";
        include "./view/website/footer_website.php";
    }
}

?>