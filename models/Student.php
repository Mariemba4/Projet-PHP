<?php
require_once 'config/Database.php';

class Student {
    public static function getAll($search = '') {
        $db = Database::getInstance()->getConnection();
        
        $sql = "SELECT s.*, sec.designation as section_name 
                FROM students s
                LEFT JOIN sections sec ON s.section_id = sec.id";
        
        if (!empty($search)) {
            $sql .= " WHERE s.name LIKE :search";
        }
    
        $stmt = $db->prepare($sql);
        
        if (!empty($search)) {
            $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getBySection($section_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT s.* 
            FROM students s
            WHERE s.section_id = :section_id
            ORDER BY s.name ASC
        ");
        $stmt->bindParam(':section_id', $section_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByUserId($user_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT s.*, sec.designation as section_name 
            FROM students s
            LEFT JOIN sections sec ON s.section_id = sec.id
            WHERE s.user_id = :user_id
            LIMIT 1
        ");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($name, $birthday, $section_id, $user_id = null) {
        $db = Database::getInstance()->getConnection();
        
        $stmt = $db->prepare("
            INSERT INTO students (name, birthday, section_id, user_id)
            VALUES (:name, :birthday, :section_id, :user_id)
        ");
        
        return $stmt->execute([
            ':name' => htmlspecialchars($name),
            ':birthday' => $birthday,
            ':section_id' => $section_id,
            ':user_id' => $user_id
        ]);
    }

    public static function update($id, $name, $birthday, $section_id) {
        $db = Database::getInstance()->getConnection();
        
        $stmt = $db->prepare("
            UPDATE students 
            SET name = :name, birthday = :birthday, section_id = :section_id
            WHERE id = :id
        ");
        
        return $stmt->execute([
            ':id' => $id,
            ':name' => htmlspecialchars($name, ENT_QUOTES),
            ':birthday' => $birthday,
            ':section_id' => $section_id
        ]);
    }

    public static function delete($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM students WHERE id = ?");
        return $stmt->execute([$id]);
    }
}