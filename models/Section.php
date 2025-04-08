<?php
require_once 'config/Database.php';

class Section {
    public $id;
    public $designation;
    public $description;

    public static function findAll() {
        $db = Database::getInstance()->getConnection();
        return $db->query("SELECT * FROM sections ORDER BY designation ASC")->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getById($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM sections WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getDesignation($section_id) {
        if (!$section_id) return 'Non assigné';
        
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT designation FROM sections WHERE id = ?");
        $stmt->execute([$section_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['designation'] : 'Section inconnue';
    }

    public static function getStudentsCount($section_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM students WHERE section_id = ?");
        $stmt->execute([$section_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }
}