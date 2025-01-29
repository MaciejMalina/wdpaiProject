<?php

require_once __DIR__ . '/AppController.php';
require_once __DIR__ . '/../api/projects.php';
require_once __DIR__ . '/../api/tasks.php';

class ProjectController extends AppController {
    public function project() {
        session_start();
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
    public function updateTaskStatus() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit();
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $taskId = $_POST['task_id'] ?? null;
            $status = $_POST['status'] ?? null;
    
            if ($taskId && $status) {
                updateTaskStatus($taskId, $status);
            }
        }
    
        $projectId = $_POST['project_id'] ?? null;
    
        if ($projectId) {
            header("Location: /project?id=$projectId");
            exit();
        }
    
        header('Location: /dashboard');
        exit();
    }
    
    public function updateProject() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit();
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $projectId = $_POST['project_id'] ?? null;
            $field = $_POST['field'] ?? null;
            $value = $_POST['value'] ?? null;
    
            if ($projectId && $field && $value) {
                updateProjectField($projectId, $field, $value);
            }
        }
    
        header('Location: /project?id=' . ($_POST['project_id'] ?? ''));
        exit();
    }
    
}
