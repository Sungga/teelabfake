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
}