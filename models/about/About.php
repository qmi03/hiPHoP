<?php

class About {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function fetch() {
        try {
            $stmt = $this->db->prepare('SELECT * FROM about_page WHERE id = 1');
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getTeamMembers() {
        try {
            $stmt = $this->db->prepare('SELECT * FROM team_members ORDER BY id ASC');
            $stmt->execute(); 
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
}
