<div class="admin__right">
                    <table>
                        <tr>
                            <th>Ảnh sản phẩm</th>
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Tên loại sản phẩm</th>
                            <th>Tên danh mục</th>
                            <th>Giá cũ</th>
                            <th>Giá mới</th>
                            <th>Số lượng</th>
                            <th>Các màu</th>
                            <th>Mô tả</th>
                            <th>Ảnh mô tả</th>
                            <th>Hành động</th>
                        </tr>
                        <?php
                        // callback hell roi :))
                        foreach($categories as $category) {
                            foreach($product_types as $product_type) {
                                foreach($products as $product) {
                                    if($category['category_id'] == $product_type['category_id']) {
                                        if($product_type['product_type_id'] == $product['product_type_id']) {
                        ?>
                                            <tr>
                                                <td><img src="./model/uploads/<?php echo $product['product_img'] ?>" alt=""></td>
                                                <td><?php echo $product['product_id'] ?></td>
                                                <td><?php echo $product['product_name'] ?></td>
                                                <td><?php echo $product_type['product_type_name'] ?></td>
                                                <td><?php echo $category['category_name'] ?></td>
                                                <td><?php echo $product['product_price'] ?></td>
                                                <td><?php echo $product['product_price_new'] ?></td>
                                                <td><?php echo $product['product_quantity'] ?></td>
                                                <td>
                                                    <?php
                                                    foreach($product_color as $color) {
                                                        if($color['product_id'] == $product['product_id']) {
                                                    ?>
                                                            <p style="width: 100%;"><?php echo $color['product_color'] ?></p>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <div class="none"><?php echo $product['product_desc'] ?></div>
                                                </td>
                                                <td>
                                                    <div class="none">
                                                        <?php
                                                        foreach($product_imgs_desc as $img) {
                                                            if($img['product_id'] == $product['product_id']) {

                                                        ?>   
                                                                <img src="./model/uploads/<?php echo $img['product_img_desc'] ?>" alt="">
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                                <td><a href="./index.php?controller=admin&page=edit_product&product_id=<?php echo $product['product_id'] ?>">Sửa</a> | <a href="./index.php?controller=admin&page=delete_product&product_id=<?php echo $product['product_id'] ?>">Xóa</a></td>
                                            </tr>
                        <?php
                                        }
                                    }
                                }
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

<style>
    .admin__right {
        padding-left: 4px;
    }
    img {
        width: 120px;
    }

    .none {
        display: none;
        position: absolute;
        top: 0;
        right: 100%;
        background-color: #fff;
    }

    td {
        position: relative;
    }

    td:hover .none {
        display: block;
    }
</style>
</html>