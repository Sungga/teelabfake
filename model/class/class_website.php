<?php
include "./model/database.php";

class website {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Phương thức category

    public function getCategories() {
        $sql = "SELECT * FROM tbl_category";
        $result = array();
        $result = $this->db->getRows($sql);

        return $result;
    }

    public function getCategory($category_id) {
        $sql = "SELECT * FROM tbl_category WHERE category_id = '$category_id'";
        $result = $this->db->getRow($sql);

        return $result;
    }

    // Phương thức cho product type

    public function getProductTypes() {
        $sql = "SELECT * FROM tbl_product_type";
        $result = $this->db->getRows($sql);

        return $result;
    }

    public function getProductType($product_type_id) {
        $sql = "SELECT * FROM tbl_product_type WHERE product_type_id = '$product_type_id'";
        $result = $this->db->getRow($sql);

        return $result;
    }

    // Phương thức cho product
    public function getProduct($product_id) {
        $sql = "SELECT * FROM tbl_product WHERE product_id = '$product_id'";
        $result = $this->db->getRow($sql);

        return $result;
    }

    public function getProducts_w_productTypeId($product_type_id) {
        $sql = "SELECT * FROM tbl_product WHERE product_type_id = '$product_type_id'";
        $result = $this->db->getRows($sql);

        return $result;
    }

    public function getColors() {
        $sql = "SELECT * FROM tbl_product_color";
        $result = $this->db->getRows($sql);

        return $result;
    }

    public function getColor($product_id) {
        $sql = "SELECT * FROM tbl_product_color WHERE product_id = '$product_id'";
        $result = $this->db->getRows($sql);

        return $result;
    }

    public function getImgDesc($product_id) {
        $sql = "SELECT * FROM tbl_product_img_desc WHERE product_id = '$product_id'";
        $result = $this->db->getRows($sql);

        return $result;
    }

    // Phương thức cho cart
    public function addCart($cart_user_id, $cart_product_id, $cart_size, $cart_color, $cart_number) {
        $sql = "INSERT INTO tbl_cart(cart_user_id, cart_product_id, cart_size, cart_color, cart_quantity) VALUES ('$cart_user_id', '$cart_product_id', '$cart_size', '$cart_color', '$cart_number')";

        $result = $this->db->exec($sql);

        return $result;
    }

    public function getCarts($user_id) {
        $sql = "SELECT * FROM tbl_cart WHERE cart_user_id = '$user_id'";

        $result = $this->db->getRows($sql);

        return $result;
    }
}