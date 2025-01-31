<?php

require_once __DIR__ . '/AppController.php';
require_once __DIR__ . '/../api/projects.php';
require_once __DIR__ . '/../api/tasks.php';

class ProjectController extends AppController {
    private $projectRepository;
    private $teamRepository;
    private $profileController;

    public function __construct() {
        $this->projectRepository = new ProjectRepository();
        $this->teamRepository = new TeamRepository();
        $this->profileController = new ProfileController();
    }

    public function project() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit();
        }

        $projectId = $_GET['id'] ?? null;

        if (!$projectId) {
            echo "No project ID provided.";
            http_response_code(404);
            exit();
        }

        $project = getProjectById($projectId);

        if (!$project) {
            echo "Project not found.";
            http_response_code(404);
            exit();
        }

        $tasks = getTasksByProjectId($projectId);

        $this->render('project', [
            'project' => $project,
            'tasks' => $tasks
        ]);
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
            $team_members = $_POST['team_members'] ?? [];

            if ($name && $manager_id) {
                $this->projectRepository->insertProject($name, $description, $manager_id, $status, $team_members);
                header('Location: /dashboard');
                exit();
            }
        }
    
        $this->render('addProject', ['error' => 'All fields are required.']);
    }
}