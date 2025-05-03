<?php

class FAQ {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function fetch() {
        try {
            $stmt = $this->db->prepare('SELECT * FROM faqs ORDER BY id ASC');
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            return null;
        }
    }

    public function fetchAll() {
        try {
            $stmt = $this->db->prepare('SELECT * FROM faqs ORDER BY id ASC');
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
}
