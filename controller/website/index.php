<?php
session_start();

?>
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

            if ($_SERVER["REQUEST_METHOD"] == 'POST') {
                if(isset($_POST["size"])) {
                    if(isset($_SESSION['user_id'])) {
                        $cart_user_id = $_SESSION['user_id'];
                        $cart_product_id = $_POST['product_id'];
                        $cart_size = $_POST["size"];
                        $cart_color = $_POST["color_product_" . $cart_product_id];
                        $cart_number = 1;

                        if($db->addCart($cart_user_id, $cart_product_id, $cart_size, $cart_color, $cart_number)) {
                            echo "<script>alert('Thêm vào giỏ thành công');</script>";
                        }
                        else {
                            echo "<script>alert('Thêm vào giỏ không thành công');</script>";
                        }
                    }
                    else {
                        echo "<script>alert('Bạn cần đăng nhập trước khi thêm giỏ hàng!');</script>";
                    }
                }
            }
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

            $product = $db->getProduct($_GET['product_id']);
            $product_type = $db->getProductType($product['product_type_id']);
            $category = $db->getCategory($product_type['category_id']);

            $product_img_desc = $db->getImgDesc($_GET['product_id']);
            $product_color = $db->getColor($_GET['product_id']);



            include "./view/website/header_website.php";
            include "./view/website/product.php";
            include "./view/website/footer_website.php";

            if ($_SERVER["REQUEST_METHOD"] == 'POST') {
                if(isset($_POST["cart"])) {
                    if(isset($_SESSION['user_id'])) {
                        $cart_user_id = $_SESSION['user_id'];
                        $cart_product_id = $_GET['product_id'];
                        $cart_size = $_POST["size"];
                        $cart_color = $_POST["color"];
                        $cart_number = $_POST['numberInput'];

                        if($db->addCart($cart_user_id, $cart_product_id, $cart_size, $cart_color, $cart_number)) {
                            echo "<script>alert('Thêm vào giỏ thành công');</script>";
                        }
                        else {
                            echo "<script>alert('Thêm vào giỏ không thành công');</script>";
                        }
                    }
                    else {
                        echo "<script>alert('Bạn cần đăng nhập trước khi thêm giỏ hàng!');</script>";
                    }
                }
                else {
                    echo "<script>alert('hehe');</script>";
                }
            }
        }
        else {
            header('location: .');
        }

        break;
    }

    case 'cart': {
        $categories = $db->getCategories();
        $product_types = $db->getProductTypes();

        if(isset($_SESSION['user_id'])) {
            $list_cart = $db->getCarts($_SESSION['user_id']);

            $arr_product_cart = array();
            foreach($list_cart as $list_cart_item) {
                $arr_product_cart[] = $db->getProduct($list_cart_item['cart_product_id']);
            }
        }
        elseif(isset($_GET['product_id'])) {
            
        }
        else {
            echo '<script>window.location.href = "./index.php</script>';
        }

        include "./view/website/header_website.php";
        include "./view/website/cart.php";
        include "./view/website/footer_website.php";


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