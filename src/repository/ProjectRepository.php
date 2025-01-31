<?php
require_once __DIR__. '/../../database.php';

class ProjectRepository {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllProjects() {
        $database = new Database();
        $db = $database->connect();
        $stmt = $this->db->connect()->query("SELECT * FROM projects");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProjectsByManager($managerId) {
        $database = new Database();
        $db = $database->connect();
        $stmt = $this->db->connect()->prepare("SELECT * FROM projects WHERE manager_id = :manager_id");
        $stmt->bindParam(':manager_id', $managerId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getManagerName($id) {
        $database = new Database();
        $db = $database->connect();
        $stmt = $this->db->connect()->prepare("SELECT name FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() ?: 'Unknown';
    }

    public function getManagersAndAdmins() {
        $database = new Database();
        $db = $database->connect();
        $stmt = $this->db->connect()->prepare("SELECT id, name FROM users Where role IN ('admin','manager')");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProjectsByAssignedTasks($userId) {
        $database = new Database();
        $db = $database->connect();
        $stmt = $this->db->connect()->prepare("
            SELECT DISTINCT p.* 
            FROM projects p
            JOIN tasks t ON p.id = t.project_id
            WHERE t.assigned_user_id = :user_id
        ");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function insertProject($name, $description, $manager_id, $status, $team_members) {
        $database = new Database();
        $db = $database->connect();

        $teamString = implode(", ", $team_members);
        $stmt = $this->db->connect()->prepare("INSERT INTO projects (name, manager_id, status, team, created_at, description) 
        VALUES (:name, :manager_id, :status, :team, NOW(), :description)");

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':manager_id', $manager_id);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':team', $teamString);
        $stmt->bindParam(':description', $description);

        return $stmt->execute();
    }
}
