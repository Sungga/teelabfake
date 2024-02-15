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
                elseif(isset($_POST["buy"])) {
                    $cart_product_id = $_GET['product_id'];
                    $cart_size = $_POST["size"];
                    $cart_color = $_POST["color"];
                    $cart_number = $_POST['numberInput'];

                    echo "<script>window.location.href = './index.php?controller=website&page=cart&product_id=$cart_product_id&size=$cart_size&color=$cart_color&numberInput=$cart_number'</script>";
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

        // truong hop co tai khoan
        if(isset($_SESSION['user_id'])) {
            $list_cart = $db->getCarts($_SESSION['user_id']);

            $arr_product_cart = array();
            foreach($list_cart as $list_cart_item) {
                $arr_product_cart[] = $db->getProduct($list_cart_item['cart_product_id']);
            }

            $colors = $db->getColors();

            $sizes = array('S', 'M', 'L', 'XL', 'XXL');
        }
        // truong hop khong co tai khoan
        elseif(isset($_GET['product_id'], $_GET['size'], $_GET['color'], $_GET['numberInput'])) {
            $list_cart = array();
            $list_cart[0]['cart_id'] = 'KA';
            $list_cart[0]['cart_product_id'] = $_GET['product_id'];
            $list_cart[0]['cart_size'] = $_GET['size'];
            $list_cart[0]['cart_color'] = $_GET['color'];
            $list_cart[0]['cart_quantity'] = $_GET['numberInput'];

            $arr_product_cart = array();
            foreach($list_cart as $list_cart_item) {
                $arr_product_cart[] = $db->getProduct($list_cart_item['cart_product_id']);
            }

            $arr_product_cart = array();
            foreach($list_cart as $list_cart_item) {
                $arr_product_cart[] = $db->getProduct($list_cart_item['cart_product_id']);
            }
            
            $colors = $db->getColors();

            $sizes = array('S', 'M', 'L', 'XL', 'XXL');
        }
        else {
            echo '<script>window.location.href = "./index.php"</script>';
        }

        include "./view/website/header_website.php";
        include "./view/website/cart.php";
        include "./view/website/footer_website.php";

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_POST['next'])) {
                // truong hop nguoi mua co tai khoan
                if(isset($_SESSION['user_id'])) {
                    $listBuy = array();
                    foreach($list_cart as $list_cart_item) {
                        if(isset($_POST['check'.$list_cart_item['cart_id']])) {
                            // Loại bỏ các ký tự không phải số và chuyển đổi thành số nguyên
                            $total = (int) preg_replace('/[^0-9]/', '', $_POST['total'.$list_cart_item['cart_id']]);

                            $arr = array();
                            $arr['cart_id'] = $list_cart_item['cart_id'];
                            $arr['product_id'] = $_POST['product_id'.$list_cart_item['cart_id']];
                            $arr['color'] = $_POST['color'.$list_cart_item['cart_id']];
                            $arr['size'] = $_POST['size'.$list_cart_item['cart_id']];
                            $arr['quantity'] = $_POST['quantity'.$list_cart_item['cart_id']];
                            $arr['total'] = $total;

                            $listBuy[] = $arr;
                        }
                    }
                    $_SESSION['listBuy'] = $listBuy;

                    echo '<script>window.location.href = "./index.php?controller=website&page=location";</script>';
                }
                // truong hop khong co tai khoan
                else {
                    $listBuy = array();
                    if(isset($_POST['checkKA'])) {
                        // Loại bỏ các ký tự không phải số và chuyển đổi thành số nguyên
                        $total = (int) preg_replace('/[^0-9]/', '', $_POST['total']);

                        $arr = array();
                        $arr['cart_id'] = 'KA';
                        $arr['product_id'] = $_POST['product_idKA'];
                        $arr['color'] = $_POST['colorKA'];
                        $arr['size'] = $_POST['sizeKA'];
                        $arr['quantity'] = $_POST['quantityKA'];
                        $arr['total'] = $total;

                        $listBuy[] = $arr;
                    }
                    $_SESSION['listBuy'] = $listBuy;

                    echo '<script>window.location.href = "./index.php?controller=website&page=location";</script>';
                }
            }
        }

        break;
    }

    case 'delete_cart': {
        if(isset($_GET['cart_id'])) {
            if(!($db->deleteCart($_GET['cart_id']))) {
                echo '<script>alert("Xóa đơn hàng thất bại!");</script>';
            }
        }

        echo '<script>window.location.href = "./index.php?controller=website&page=cart"</script>';

        break;
    }

    case 'location': {
        $categories = $db->getCategories();
        $product_types = $db->getProductTypes();

        $user_name = '';
        $user_phone = '';
        $user_address = '';
        if(isset($_SESSION['user_id'])) {
            $user = $db->getUserInfo($_SESSION['user_id']);
            $user_name = $user['user_name'];
            $user_phone = $user['user_phone'];
            $user_address = $user['user_address'];
        }

        include "./view/website/header_website.php";
        include "./view/website/location.php";
        include "./view/website/footer_website.php";

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_SESSION['buy_user_info']['buy_name_user'] = $_POST['name'];
            $_SESSION['buy_user_info']['buy_phone_user'] = $_POST['phone'];
            $_SESSION['buy_user_info']['buy_address'] = $_POST['city']."-".$_POST['district']."-".$_POST['ward']."-".$_POST['address'];

            echo '<script>window.location.href = "./index.php?controller=website&page=pay_money";</script>';
        }

        break;
    }

    case 'pay_money': {
        if(isset($_SESSION['listBuy']) && isset($_SESSION['buy_user_info'])) {
            $categories = $db->getCategories();
            $product_types = $db->getProductTypes();
    
            include "./view/website/header_website.php";
            include "./view/website/pay_money.php";
            include "./view/website/footer_website.php";

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                if($_POST['pay_money'] == 'cod') {
                    $_SESSION['payment_method'] = 'cod';
                    echo '<script>window.location.href = "./index.php?controller=website&page=success";</script>';
                }
                elseif($_POST['pay_money'] == 'momo') {
                    // $_SESSION['payment_method'] = 'momo';
                    echo '<script>alert("Chức năng chưa được phát triển!");</script>';
                }
            }
        }
        else {
            header('Location: ./index.php');
        }

        break;
    }

    case 'success': {
        if(isset($_SESSION['listBuy']) && isset($_SESSION['buy_user_info']) && isset($_SESSION['payment_method'])) {
            foreach($_SESSION['listBuy'] as $listBuy_index => $listBuy) {
                if($_SESSION['payment_method'] != 'cod') {
                    $_SESSION['listBuy'][$listBuy_index]['total'] = 0;
                }
                if($db->addOrder($listBuy_index)) {
                    $db->deleteCart($_SESSION['listBuy'][$listBuy_index]['cart_id']);
                    $status = 'Đặt hàng thành công';
                }
                else {
                    $status = 'Đặt hàng không thành công';
                }
            }

            unset($_SESSION['listBuy']);
            unset($_SESSION['buy_user_info']);
            unset($_SESSION['payment_method']);

            $categories = $db->getCategories();
            $product_types = $db->getProductTypes();

            include "./view/website/header_website.php";
            include "./view/website/success.php";
            include "./view/website/footer_website.php";
        }
        else {
            header('location: ./index.php');
        }

        break;
    }

    case 'order': {
        if(isset($_SESSION['user_id'])) {
            $categories = $db->getCategories();
            $product_types = $db->getProductTypes();
    
            $orders = $db->getOrder($_SESSION['user_id']);

            $products = array();
            foreach($orders as $order_item) {
                $product = $db->getProduct($order_item['product_id']);
                $products[] = $product;
            }
    
            include "./view/website/header_website.php";
            include "./view/website/order.php";
            include "./view/website/footer_website.php";
        }
        else {
            header('location: ./index.php');
        }

        break;
    }

    case 'delete_order': {
        if(isset($_SESSION['user_id']) && isset($_GET['order_id'])) {
            $orders = $db->getOrder($_SESSION['user_id']);

            $kt = false;
            foreach($orders as $order_item) {
                if($order_item['order_id'] == $_GET['order_id']) {
                    $kt = true;
                    break;
                }
            }

            if($kt) {
                $db->deleteOrder($_GET['order_id']);
                echo '<script>window.location.href = "./index.php?controller=website&page=order";</script>';
            }
            else {
                echo '<script>window.location.href = "./index.php";</script>';
            }
        }
        else {
            header('location: ./index.php');
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