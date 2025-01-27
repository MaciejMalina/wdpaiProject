<?php

function getProjects() {
    $db = new PDO('pgsql:host=db;dbname=teamit', 'postgres', 'example');

    // Pobierz wszystkie projekty wraz z nazwą menedżera
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

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
