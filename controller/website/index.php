<?php
$page = '';

if(isset($_GET['page'])) {
    $page = $_GET['page'];
}

switch($page) {
    default: {
        echo "hello word";
    }
}

?>