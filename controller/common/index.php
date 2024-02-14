<?php
session_start();

?>
<?php
include "./model/class/class_common.php";
$db = new common();
?>

<?php
$page = '';

if(isset($_GET['page'])) {
    $page = $_GET['page'];
}

switch($page) {
    case 'signup': {
        $categories = $db->getCategories();
        $product_types = $db->getProductTypes();
        
        include "./view/website/header_website.php";
        include "./view/common/signup.php";
        include "./view/website/footer_website.php";

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($_POST['password1'] == $_POST['password2'] && $db->checkUserExists($_POST['account'])) {
                $db->addUser($_POST['account'], $_POST['password1'], $_POST['name'], $_POST['phone'], $_POST['email'], $_POST['address']);

                echo '<script>alert("Đăng ký thành công");</script>';
                echo '<script>window.location.href = "./index.php?controller=common&page=signin";</script>';
            }
            else {
                echo "<script>alert('Mật khẩu nhập không giống nhau hoặc tài khoản đã tồn tại!');</script>";
            }
        }

        break;
    }

    case 'signin': {
        $categories = $db->getCategories();
        $product_types = $db->getProductTypes();
        
        include "./view/website/header_website.php";
        include "./view/common/signin.php";
        include "./view/website/footer_website.php";

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($db->checkAccount($_POST['account'], $_POST['password'])) {
                $user_now = $db->getUserId($_POST['account']);
                $_SESSION['user_id'] = $user_now['user_id'];
                $_SESSION['role'] = $user_now['role'];

                echo "<script>alert('Đăng nhập thành công!')</script>";
                echo '<script>window.location.href = "./index.php";</script>';
            }
            else {
                echo "<script>alert('Thông tin mật khẩu hoặc tài khoản không chính xác!')</script>";
            }
        }
        
        break;
    }

    case 'account': {
        $categories = $db->getCategories();
        $product_types = $db->getProductTypes();

        $user_account = $db->getUserAcc($_SESSION['user_id']);
        $user_info = $db->getUserInfo($_SESSION['user_id']);

        include "./view/website/header_website.php";
        include "./view/common/account.php";
        include "./view/website/footer_website.php";

        

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($db->editInfo($_SESSION['user_id'], $_POST['name'], $_POST['phone'], $_POST['email'], $_POST['address'])) {
                echo "<script>alert('Sửa thông tin thành công');</script>";
                echo '<script>window.location.href = "./index.php?controller=common&page=account";</script>';
            }
            else {
                echo "<script>alert('Sửa thông tin không thành công');</script>";
            }
        }
        
        break;
    }

    case 'password': {
        $categories = $db->getCategories();
        $product_types = $db->getProductTypes();

        $user_info = $db->getUserInfo($_SESSION['user_id']);

        include "./view/website/header_website.php";
        include "./view/common/password.php";
        include "./view/website/footer_website.php";

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($db->checkPassword($_SESSION['user_id'], $_POST['passwordOld'])) {
                if($_POST['passwordNew1'] == $_POST['passwordNew2']) {
                    if($db->editPassword($_SESSION['user_id'], $_POST['passwordNew1'])) {
                        echo "<script>alert('Sửa mật khẩu thành công');</script>";
                        echo '<script>window.location.href = "./index.php?controller=common&page=account";</script>';
                    }
                    else {
                        echo "<script>alert('Sửa mật khẩu không thành công!');</script>";
                    }
                }
                else {
                    echo "<script>alert('Mật khẩu nhập không giống nhau!');</script>";
                }
            }
            else {
                echo "<script>alert('Sai mật khẩu!');</script>";
            }
        }
        
        break;
    }

    case 'logout': {
        unset($_SESSION['user_id']);
        unset($_SESSION['role']);
        
        echo '<script>window.location.href = "./index.php";</script>';

        break;
    }

    default: {
        echo "khong ton tai";
    }
}