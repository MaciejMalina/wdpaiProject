<?php

function getTasksByProjectId($projectId) {
    $db = new PDO('pgsql:host=db;dbname=teamit', 'postgres', 'example');

    $stmt = $db->prepare('
        SELECT 
            t.id, 
            t.description, 
            t.status, 
            t.assigned_to, 
            u.name AS assigned_user
        FROM 
            tasks t
        LEFT JOIN 
            users u ON t.assigned_to = u.id
        WHERE 
            t.project_id = :project_id
    ');

    $stmt->execute(['project_id' => $projectId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function createTask($projectId, $description, $assignedTo = null) {
    $db = new PDO('pgsql:host=db;dbname=teamit', 'postgres', 'example');

    $stmt = $db->prepare('
        INSERT INTO tasks (project_id, description, assigned_to) 
        VALUES (:project_id, :description, :assigned_to)
    ');

    $stmt->execute([
        'project_id' => $projectId,
        'description' => $description,
        'assigned_to' => $assignedTo,
    ]);

    return $db->lastInsertId();
}

function updateTaskStatus($taskId, $status) {
    $db = new PDO('pgsql:host=db;dbname=teamit', 'postgres', 'example');

    $stmt = $db->prepare('
        UPDATE tasks 
        SET status = :status 
        WHERE id = :task_id
    ');

    $stmt->execute([
        'status' => $status,
        'task_id' => $taskId,
    ]);

    return $stmt->rowCount();
}