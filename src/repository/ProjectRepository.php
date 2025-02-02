<?php
require_once __DIR__. '/../../database.php';

class ProjectRepository {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getProjectById($id) {
        if (empty($id) || !is_numeric($id)) {
            return null;
        }
        $stmt = $this->db->connect()->prepare("SELECT * FROM projects WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function updateProjectField($projectId, $field, $value) {
        $database = new Database();
        $db = $database->connect();
        $stmt = $this->db->connect()->prepare("UPDATE projects SET $field = :value WHERE id = :id");
        return $stmt->execute([
            ':value' => $value,
            ':id' => $projectId
        ]);
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
    public function insertProject($name, $description, $managerId, $status, $teamMembers) {
        try {
            $database = new Database();
            $db = $database->connect();
    
            $db->beginTransaction();
 
            $stmt = $db->prepare("
                INSERT INTO projects (name, manager_id, status, description) 
                VALUES (:name, :manager_id, :status, :description) RETURNING id
            ");
            $stmt->execute([
                ':name' => $name,
                ':manager_id' => $managerId,
                ':status' => $status,
                ':description' => $description
            ]);
            $projectId = $stmt->fetchColumn();
    
            if (!is_array($teamMembers)) {
                $teamMembers = [];
            }

            $stmtTeam = $db->prepare("
                INSERT INTO project_team (project_id, user_id, role) 
                VALUES (:project_id, :user_id, :role)
            ");
    
            foreach ($teamMembers as $member) {
                if (is_array($member) && isset($member['id'], $member['role'])) {
                    $stmtTeam->execute([
                        ':project_id' => $projectId,
                        ':user_id' => $member['id'],
                        ':role' => $member['role']
                    ]);
                }
            }
    
            $db->commit();
            return $projectId;
        } catch (Exception $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            throw new Exception("Błąd podczas dodawania projektu: " . $e->getMessage());
        }
    }
    public function getProjectDetailsById($id) {
        $database = new Database();
        $db = $database->connect();
        $stmt = $this->db->connect()->prepare("SELECT * FROM project_details WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
    public function getTasksForProject($projectName) {
        $database = new Database();
        $db = $database->connect();
        $stmt = $this->db->connect()->prepare("SELECT * FROM task_details WHERE project = :projectName");
        $stmt->bindParam(':projectName', $projectName, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
