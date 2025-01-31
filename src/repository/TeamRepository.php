<?php
require_once __DIR__. '/../../database.php';

class TeamRepository {
    private $db;

    public function __construct() {
        $this->db = new Database();
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
}
