<?php
$controller = '';

if(isset($_GET['controller'])) {
    $controller = $_GET['controller'];
}

switch($controller) {
    case 'admin': {
        include "./controller/admin/index.php";
        break;
    }
    
    default: {
        include "./controller/website/index.php";
    }
}

?>