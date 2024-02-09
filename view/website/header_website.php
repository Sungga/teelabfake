<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teelab</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="./view/access/css/style.css">
    <link rel="stylesheet" href="./view/access/css/base.css">
</head>
<body>
    <!-- BEGIN HEADER -->
    <section id="header">
        <div class="grid">
            <div class="header__container">
                <div class="header__left">
                    <?php
                    foreach ($categories as $category_item) {
                    ?>
                        <div class="header__left--category">
                            <p><?php echo $category_item['category_name'] ?></p>
                            <ul>
                                <?php
                                $arr = array();
                                foreach ($product_types as $product_type_item) {
                                    if ($category_item['category_id'] == $product_type_item['category_id']) $arr[] = $product_type_item;
                                }
                                $count = 0;
                                for($j = 0; $j < count($arr);) {
                                    $i = 0;
                                ?>
                                    <li>
                                <?php
                                    while($i < 4 && $j < count($arr)) {
                                ?>
                                        <a href="./index.php?controller=website&page=product_type&product_type_id=<?php echo $arr[$j]['product_type_id'] ?>"><?php echo $arr[$j]['product_type_name'] ?></a>
                                <?php
                                        $j++;
                                        $i++;
                                    }
                                ?>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="header__center">
                    <a href="https://facebook.com/vu170" class="header__center--logo">
                        <div class="header__center--logo">
                            <img src="./view/access/img/logo.webp" alt="">
                        </div>
                    </a>
                </div>
                <div class="header__right">
                    <div class="header__right--search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="search" id="" placeholder="Tìm kiếm sản phẩm">
                    </div>
                    <div class="header__right--icon">
                        <a href="https://www.messenger.com/t/VU170" class="fa-solid fa-envelope"></a>
                    </div>
                    <div class="header__right--icon header__right--user">
                        <a src="#" class="fa-solid fa-user"></a>
                        <div class="header__right--func">
                            <a href="./index.php?controller=admin&page">Quản lý</a>
                            <a href="#">Tài khoản</a>
                            <a href="#">Đăng xuất</a>
                            <a href="#">Đăng nhập</a>
                        </div>
                    </div>
                    <div class="header__right--icon">
                        <a href="#" class="fa-solid fa-cart-shopping"></a>
                    </div>
                </div>
            </div>
        </div>



    </section>
    <div class="header__footer"></div>

