<?php
// manager-view.php
require_once '../src/api/projects.php';
$projectId = $_GET['id'] ?? null;
$project = $projectId ? getProjectById($projectId) : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Manager View</title>
    <link rel="stylesheet" href="/css/manager-view.css">
</head>
<body>
    <div class="header">
        <button onclick="history.back()" class="back-button">Back</button>
        <h1><?= htmlspecialchars($project['name'] ?? 'Unknown Project') ?></h1>
        <a href="profile.php" class="account">Account</a>
    </div>
    <div class="content">
        <div class="project-details">
            <div class="row">
                <p><strong>General info:</strong> <?= htmlspecialchars($project['description']) ?></p>
                <button class="edit-button">Edit</button>
            </div>
            <ul>
                <li><span>Task: Build Backend</span></li>
                <li><span>Task: Design Frontend</span></li>
            </ul>
        </div>
    </div>
</body>
</html>
