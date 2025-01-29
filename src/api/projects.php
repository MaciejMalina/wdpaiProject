<?php

function getProjects($userId, $role) {
    $db = new PDO('pgsql:host=db;dbname=teamit', 'postgres', 'example');

    if ($role === 'admin') {
        $stmt = $db->prepare('
            SELECT 
                p.id, 
                p.name, 
                p.status, 
                p.team, 
                p.created_at, 
                u.name AS manager 
            FROM 
                projects p
            JOIN 
                users u ON p.manager_id = u.id
        ');
        $stmt->execute();
    } else {
        $stmt = $db->prepare('
            SELECT 
                p.id, 
                p.name, 
                p.status, 
                p.team, 
                p.created_at, 
                u.name AS manager 
            FROM 
                projects p
            JOIN 
                users u ON p.manager_id = u.id
            WHERE 
                p.manager_id = :user_id OR 
                p.team LIKE :user_pattern
        ');
        $stmt->execute([
            'user_id' => $userId,
            'user_pattern' => '%"'.$userId.'"%'
        ]);
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getProjectById($projectId) {
    $db = new PDO('pgsql:host=db;dbname=teamit', 'postgres', 'example');

    $stmt = $db->prepare('
        SELECT 
            p.id, 
            p.name, 
            p.description, 
            p.status, 
            p.team, 
            p.created_at, 
            u.name AS manager 
        FROM 
            projects p
        JOIN 
            users u ON p.manager_id = u.id
        WHERE 
            p.id = :project_id
    ');

    $stmt->execute(['project_id' => $projectId]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function updateProjectField($projectId, $field, $value) {
    $allowedFields = ['name', 'description', 'team', 'status'];
    if (!in_array($field, $allowedFields)) {
        return false;
    }

    $db = new PDO('pgsql:host=db;dbname=teamit', 'postgres', 'example');

    $stmt = $db->prepare("
        UPDATE projects
        SET $field = :value
        WHERE id = :id
    ");

    $stmt->execute([
        'value' => $value,
        'id' => $projectId
    ]);

    return $stmt->rowCount();
}
