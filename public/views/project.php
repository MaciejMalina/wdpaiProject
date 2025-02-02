<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details</title>
    <link rel="stylesheet" href="/css/project.css">
    <script>
        
    </script>
</head>
<body>
    <div class="header">
        <button class="back-button" onclick="location.href='/dashboard'">Back</button>
        <h1><?= htmlspecialchars($project['name'] ?? 'Unknown Project') ?></h1>
        <div class="nav-links">
            <a href="/profile" class="account">Account</a>
            <a href="/logout" class="account">Logout</a>
        </div>
    </div>
    <div class="content">
    <div class="project-details">
    <h2>General Information</h2>
    <p><strong>Manager:</strong> <?= htmlspecialchars($project['manager'] ?? 'Unknown') ?></p>
    <p><strong>Status:</strong> <?= htmlspecialchars($project['status'] ?? 'N/A') ?></p>
    <p><strong>Description:</strong> <?= htmlspecialchars($project['description'] ?? 'N/A') ?></p>
    <h2>Team</h2>
        <?php if (empty($teamRoles)): ?>
            <p>No team members assigned.</p>
        <?php else: ?>
            <ul>
                <?php if (!empty($teamRoles['developers'])): ?>
                    <li><strong>Developers:</strong> <?= implode(', ', $teamRoles['developers']) ?></li>
                <?php endif; ?>
                <?php if (!empty($teamRoles['testers'])): ?>
                    <li><strong>Testers:</strong> <?= implode(', ', $teamRoles['testers']) ?></li>
                <?php endif; ?>
                <?php if (!empty($teamRoles['analysts'])): ?>
                    <li><strong>Analysts:</strong> <?= implode(', ', $teamRoles['analysts']) ?></li>
                <?php endif; ?>
                <?php if (!empty($teamRoles['designers'])): ?>
                    <li><strong>Designers:</strong> <?= implode(', ', $teamRoles['designers']) ?></li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>

    <h2>Tasks</h2>
            <?php if (empty($tasks)): ?>
                <p>No tasks available for this project.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($tasks as $task): ?>
                        <li>
                            <strong>Task:</strong> <?= htmlspecialchars($task['description']) ?><br>
                            <strong>Assigned To:</strong> <?= htmlspecialchars($task['assigned_user'] ?? 'Unassigned') ?><br>
                            <strong>Status:</strong> <?= htmlspecialchars($task['status']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>