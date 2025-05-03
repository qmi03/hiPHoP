<?php

class FAQ {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAllFAQs() {
        try {
            $stmt = $this->db->prepare('SELECT * FROM faqs ORDER BY id ASC');
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
}
