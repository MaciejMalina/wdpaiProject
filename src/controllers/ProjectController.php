<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/ProjectRepository.php';
require_once __DIR__ . '/../repository/TaskRepository.php';
require_once __DIR__ . '/../repository/TeamRepository.php';
require_once __DIR__ . '/ProfileController.php';

class ProjectController extends AppController {
    private $projectRepository;
    private $taskRepository;
    private $teamRepository;
    private $profileController;

    public function __construct() {
        $this->projectRepository = new ProjectRepository();
        $this->taskRepository = new TaskRepository();
        $this->teamRepository = new TeamRepository();
        $this->profileController = new ProfileController();
    }
    public function project($id) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        $id = $_GET['id'] ?? null;

        if (!$id || !is_numeric($id)) {
            die("No valid project ID provided!");
        }
    
        $project = $this->projectRepository->getProjectDetailsById($id);
        if (!$project) {
            echo "Project not found!";
            exit();
        }

        $teamRoles = $this->teamRepository->getTeamMembersByProject($id);
        $tasks = $this->projectRepository->getTasksForProject($project['name']);

        $this->render('project', [
            'project' => $project,
            'teamRoles' => $teamRoles,
            'tasks' => $tasks
        ]);
    }

    public function updateProject() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $projectId = $_POST['project_id'];
            $field = $_POST['field'];
            $value = trim($_POST['value']);

            $allowedFields = ['name', 'status', 'description'];
            if (!in_array($field, $allowedFields)) {
                die("Invalid field!");
            }

            $success = $this->projectRepository->updateProjectField($projectId, $field, $value);

            if ($success) {
                header("Location: /project/$projectId");
                exit();
            } else {
                die("Error updating project.");
            }
        }
    }

    public function addTask() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $projectId = $_POST['project_id'];
            $description = trim($_POST['description']);
            $assignedUserId = $_POST['assigned_user'];

            if (empty($description)) {
                die("Task description cannot be empty!");
            }

            $this->taskRepository->insertTask($projectId, $description, $assignedUserId);

            header("Location: /project/$projectId");
            exit();
        }
    }
    public function addProject() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $managers = $this->projectRepository->getManagersAndAdmins();
        $users = $this->teamRepository->getAllUsers();

        $this->render('addProject',['users' => $users, 'managers' => $managers]);
    }
    public function createProject() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? null;
            $description = $_POST['description'] ?? null;
            $manager_id = $_POST['manager_id'] ?? null;
            $status = $_POST['status'] ?? 'Pending';
            $teamMembers = isset($_POST['team_members']) ? (array) $_POST['team_members'] : [];

    
            if (!$name || !$description || !$manager_id) {
                echo "All fields are required!";
                exit();
            }
    
            $projectId = $this->projectRepository->insertProject($name, $description, $manager_id, $status, $teamMembers);
    
            foreach ($teamMembers as $memberId) {
                $role = $this->teamRepository->getUserRoleById($memberId);
                $this->teamRepository->addMemberToProject($projectId, $memberId, $role);
            }
    
            header("Location: /dashboard");
            exit();
        }
    
        header("Location: /addProject");
        exit();
    }
}