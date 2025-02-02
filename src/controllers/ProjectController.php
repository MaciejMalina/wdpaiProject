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

        $teamMembers = $this->teamRepository->getTeamMembersByProject($id);
        $tasks = $this->projectRepository->getTasksForProject($project['name']);
        $allUsers = $this->teamRepository->getAllUsers();
        
        $this->render('project', [
            'project' => $project,
            'teamMembers' => $teamMembers,
            'tasks' => $tasks,
            'allUsers' => $allUsers
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
        if (!$this->isAuthorized()) {
            die("Access Denied");
        }


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $projectId = $_POST['project_id'];
            $name = trim($_POST['name']);
            $status = trim($_POST['status']);
            $description = trim($_POST['description']);
    
            $this->projectRepository->updateProject($projectId, $name, $status, $description);
            
            header("Location: /project?id=$projectId");
            exit();
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
        if (!$this->isAuthorized()) {
            die("Access Denied");
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $projectId = $_POST['project_id'];
            $description = trim($_POST['description']);
            $assignedTo = !empty($_POST['assigned_to']) ? $_POST['assigned_to'] : null;
            $status = $_POST['status'] ?? 'Pending';

            if (empty($description)) {
                $_SESSION['error'] = "Task description cannot be empty!";
                header("Location: /project?id=$projectId");
                exit();
            }
    
            if (!is_numeric($assignedTo) && !empty($assignedTo)) {
                $assignedTo = $this->teamRepository->getUserIdByName($assignedTo);
            }
            
            if ($assignedTo === null && !empty($assignedTo)) {
                $_SESSION['error'] = "User '$assignedTo' not found in database!";
                header("Location: /project?id=$projectId");
                exit();
            }

            $this->taskRepository->insertTask($projectId, $description, $assignedTo, $status);
    
            $_SESSION['message'] = "Task added successfully!";
            header("Location: /project?id=$projectId");
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
    private function isAuthorized() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        return isset($_SESSION['user_id']) && isset($_SESSION['role']) 
               && in_array($_SESSION['role'], ['admin', 'manager']);
    }
    
    public function addTeamMember() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!$this->isAuthorized()) {
            die("Access Denied");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $projectId = $_POST['project_id'];
            $userId = $_POST['user_id'];

            try {
                $this->teamRepository->addMemberToProject($projectId, $userId);
                $_SESSION['message'] = "User added successfully!";
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
            }
    
            header("Location: /project?id=$projectId");
            exit();
        }
    }

}