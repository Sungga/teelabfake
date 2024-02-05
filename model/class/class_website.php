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

    // Phương thức cho product type

    public function getProductTypes() {
        $sql = "SELECT * FROM tbl_product_type";
        $result = $this->db->getRows($sql);

        return $result;
    }
}