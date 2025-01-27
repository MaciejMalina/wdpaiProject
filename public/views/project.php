<?php
// project.php
require_once '../src/api/projects.php';
$projectId = $_GET['id'] ?? null;
$project = $projectId ? getProjectById($projectId) : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details</title>
    <link rel="stylesheet" href="/css/project.css">
</head>
<body>
    <div class="header">
        <button onclick="history.back()" class="back-button">Back</button>
        <h1><?= htmlspecialchars($project['name'] ?? 'Unknown Project') ?></h1>
        <a href="profile.php" class="account">Account</a>
    </div>
    <div class="content">
        <div class="project-details">
            <p><strong>General info:</strong> <?= htmlspecialchars($project['description'] ?? 'No description available.') ?></p>
            <p><strong>Team:</strong> <?= htmlspecialchars($project['team'] ?? 'No team assigned.') ?></p>
            <ul>
                <li>
                    <span>Task: Build Backend</span>
                    <input type="checkbox">
                    <textarea placeholder="Add a note..."></textarea>
                </li>
            </ul>
        </div>
    </div>
</body>
</html>
