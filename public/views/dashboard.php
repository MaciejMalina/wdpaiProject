<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/css/dashboard.css">
</head>
<body>

<header>
    <div class="header">
        <h1>Your Projects</h1>
        <nav>
            <?php if (isset($_SESSION['user_id']) && isset($_SESSION['role']) 
                && in_array($_SESSION['role'], ['admin', 'manager'])): ?>
                <a href="/addProject" class="add-project-button">+ Add Project</a>
            <?php endif; ?>
            <a href="/profile" class="account">Account</a>
            <a href="/logout" class="logout">Logout</a>
        </nav>
    </div>
</header>

<main>
    <div class="dashboard-container">
        <?php foreach ($projects as $project): ?>
        <a href="/project?id=<?= $project['id'] ?>" class="project-card">
            <h2><?= htmlspecialchars($project['name']) ?></h2>
            <p><?= htmlspecialchars($project['description']) ?></p>
            <p><strong>Manager:</strong> <?= htmlspecialchars($project['manager_name']) ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($project['status']) ?></p>
            <p><strong>Team:</strong></p>
            <ul>
                <li><strong>Developers:</strong> <?= !empty($project['team_roles']['developers']) ? implode(", ", $project['team_roles']['developers']) : 'None' ?></li>
                <li><strong>Testers:</strong> <?= !empty($project['team_roles']['testers']) ? implode(", ", $project['team_roles']['testers']) : 'None' ?></li>
                <li><strong>Business Analysts:</strong> <?= !empty($project['team_roles']['analysts']) ? implode(", ", $project['team_roles']['analysts']) : 'None' ?></li>
                <li><strong>Designers:</strong> <?= !empty($project['team_roles']['designers']) ? implode(", ", $project['team_roles']['designers']) : 'None' ?></li>
            </ul>
        </a>
    <?php endforeach; ?>
    </div>
</main>
</body>
</html>
