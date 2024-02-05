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
        $categories = $db->getCategories();
        $product_types = $db->getProductTypes();

        if(isset($_GET['product_type_id'])) {
            include "./view/website/header_website.php";
            include "./view/website/list_product.php";
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