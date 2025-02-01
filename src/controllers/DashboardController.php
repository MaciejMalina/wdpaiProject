<?php
require_once 'AppController.php';
require_once __DIR__ . '/../repository/ProjectRepository.php';
require_once __DIR__ . '/../repository/TeamRepository.php';
require_once __DIR__ . '/ProfileController.php';

class DashboardController extends AppController {
    private $projectRepository;
    private $teamRepository;
    private $profileController;

    public function __construct() {
        $this->projectRepository = new ProjectRepository();
        $this->teamRepository = new TeamRepository();
        $this->profileController = new ProfileController();
    }

    public function dashboard() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $user = $this->profileController->getUserById($userId);
        $role = $user['role'];

        if ($role === 'admin') {
            $projects = $this->projectRepository->getAllProjects();
        } elseif ($role === 'manager') {
            $projects = $this->projectRepository->getProjectsByManager($userId);
        } else {
            $projects = $this->projectRepository->getProjectsByAssignedTasks($userId);
        }

        foreach ($projects as &$project) {
            $project['manager_name'] = $this->projectRepository->getManagerName($project['manager_id']);
            $project['team_roles'] = $this->teamRepository->getTeamMembersByProject($project['id']);
        }

        $this->render('dashboard', ['projects' => $projects, 'user' => $user]);
    }
}
