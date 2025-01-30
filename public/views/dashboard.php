<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/css/dashboard.css">
</head>
<body>
    <div class="header">
        <h1>Your Projects</h1>
        <div class="nav-links">
            <a href="/profile" class="account">Account</a>
            <a href="/logout" class="account">Logout</a>
        </div>
    </div>
    <div class="dashboard">
        <?php if (empty($projects)): ?>
            <p>No projects available.</p>
        <?php else: ?>
            <?php foreach ($projects as $project): ?>
                <div class="project-card" onclick="location.href='/project?id=<?= $project['id'] ?>';">
                    <h2><?= htmlspecialchars($project['name']) ?></h2>
                    <p><strong>Manager:</strong> <?= htmlspecialchars($project['manager']) ?></p>
                    <p><strong>Status:</strong> <?= htmlspecialchars($project['status']) ?></p>
                    <p><strong>Team:</strong> <?= htmlspecialchars($project['team']) ?></p>
                    <ul>
                        <li>Developers: <?= htmlspecialchars($project['developers'] ?? 'None') ?></li>
                        <li>Testers: <?= htmlspecialchars($project['testers'] ?? 'None') ?></li>
                        <li>Business analysts: <?= htmlspecialchars($project['analysts'] ?? 'None') ?></li>
                        <li>Designers: <?= htmlspecialchars($project['designers'] ?? 'None') ?></li>
                    </ul>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
