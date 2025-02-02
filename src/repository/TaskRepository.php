<?php
require_once __DIR__. '/../../database.php';

class TaskRepository {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }


    public function getTasksByProject($projectId) {
        $database = new Database();
        $db = $database->connect();
        
        if (!is_numeric($projectId) || $projectId <= 0) {
            throw new InvalidArgumentException("Invalid project ID");
        }

        $stmt = $this->db->connect()->prepare("SELECT * FROM tasks WHERE project_id = :project_id");
        $stmt->bindParam(':project_id', $projectId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertTask($projectId, $description, $assignedTo, $status) {
        $database = new Database();
        $db = $database->connect();
        $stmt = $this->db->connect()->prepare("
            INSERT INTO tasks (project_id, description, assigned_to, status) 
            VALUES (:project_id, :description, :assigned_to, :status)
        ");
        $stmt->execute([
            ':project_id' => $projectId,
            ':description' => $description,
            ':assigned_to' => $assignedTo,
            ':status' => $status
        ]);
    }
}
