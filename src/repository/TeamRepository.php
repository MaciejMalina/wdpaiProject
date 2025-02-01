<?php
require_once __DIR__. '/../../database.php';

class TeamRepository {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getTeamMembersByProject($projectId) {
        $database = new Database();
        $db = $database->connect();
        $stmt = $this->db->connect()->prepare("
            SELECT u.name, u.role FROM users u
            JOIN project_team pt ON u.id = pt.user_id
            WHERE pt.project_id = :project_id
        ");
        $stmt->bindParam(':project_id', $projectId, PDO::PARAM_INT);
        $stmt->execute();

        $roles = [
            'developers' => [],
            'testers' => [],
            'analysts' => [],
            'designers' => []
        ];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['role'] === 'developer') {
                $roles['developers'][] = $row['name'];
            } elseif ($row['role'] === 'tester') {
                $roles['testers'][] = $row['name'];
            } elseif ($row['role'] === 'analyst') {
                $roles['analysts'][] = $row['name'];
            } elseif ($row['role'] === 'designer') {
                $roles['designers'][] = $row['name'];
            }
        }

        return $roles;
    }

    public function addMemberToProject($projectId, $userId) {
        $database = new Database();
        $db = $database->connect();
        $stmt = $this->db->connect()->prepare("
        INSERT INTO project_team (project_id, user_id, role)
        VALUES (:project_id, :user_id, :role)
        ");
        $stmt->bindParam(':project_id', $projectId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function getTeamRoles($teamString) {
        $database = new Database();
        $db = $database->connect();
        $teamMembers = explode(", ", $teamString);
        $roles = [
            'developers' => [],
            'testers' => [],
            'analysts' => [],
            'designers' => []
        ];

        foreach ($teamMembers as $member) {
            $stmt = $this->db->connect()->prepare("SELECT role FROM users WHERE name = :name");
            $stmt->bindParam(':name', $member, PDO::PARAM_STR);
            $stmt->execute();
            $role = $stmt->fetchColumn();

            if ($role === 'developer') {
                $roles['developers'][] = $member;
            } elseif ($role === 'tester') {
                $roles['testers'][] = $member;
            } elseif ($role === 'analyst') {
                $roles['analysts'][] = $member;
            } elseif ($role === 'designer') {
                $roles['designers'][] = $member;
            }
        }

        return $roles;
    }
    public function getAllUsers() {
        $database = new Database();
        $db = $database->connect();
        $stmt = $this->db->connect()->prepare("SELECT id, name, role FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserRoleById($userId) {
        $database = new Database();
        $db = $database->connect();
        $stmt = $this->db->connect()->prepare("SELECT role FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
}
