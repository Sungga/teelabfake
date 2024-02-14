    <!-- BEGIN CART -->
    <section class="cart">
        <div class="grid">
            <div class="location">
                <i class="fa-solid fa-cart-shopping"></i>
                <i class="fa-solid fa-location-dot"></i>
                <i class="fa-solid fa-money-bill"></i>
                <i class="fa-solid fa-check"></i>
            </div>
            <div class="cart__container">
                <table class="cart__left">
                    <tr>
                        <th>Ảnh sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Màu sắc</th>
                        <th>Số lượng</th>
                        <th>Giá tiền</th>
                        <th>Tổng tiền</th>
                        <th>Xóa</th>
                    </tr>
                    <?php
                    foreach($arr_product_cart as $arr_product_cart_item) {
                    ?>
                        <tr>
                        <td>
                            <img src="./access/img/product1.jpg" alt="">
                        </td>
                        <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptate, deserunt?</td>
                        <td>
                            <select name="" id="">
                                <option value="yellow">vàng</option>
                                <option value="blue">xanh nước</option>
                                <option value="đỏ">đỏ</option>
                            </select>
                        </td>
                        <td>
                            <input type="number" name="" id="" value="0" max="33" min="0">
                        </td>
                        <td>
                            1500000₫
                        </td>
                        <td>
                            1.500.000₫
                        </td>
                        <td><a href="" class="fa-solid fa-trash"></a></td>
                    </tr>
                    <?php
                    }
                    ?>
                </table>
                <div class="cart__right">
                    <h1>Tổng tiền giỏ hàng</h1>
                    <div>
                        <p>Tổng sản phẩm</p>
                        <p class="tongsanpham">1</p>
                    </div>
                    <div>
                        <p>Tổng tiền hàng</p>
                        <p class="tongtienhang">2.000.000₫</p>
                    </div>
                    <div>
                        <p>Thành tiền (bao gồm phí vận chuyển)</p>
                        <p class="thanhtien">3.000.000₫</p>
                    </div>
                    <div class="cart__right--input">
                        <input type="submit" value="Thanh toán">
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script src="./view/access/js/js_cart.js"></script>