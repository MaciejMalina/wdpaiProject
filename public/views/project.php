<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details</title>
    <link rel="stylesheet" href="/css/project.css">
    <script>
    function toggleForm(formId) {
        document.getElementById(formId).classList.toggle("show");
    }
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

    <?php 
        $isManager = isset($_SESSION['user_id']) && isset($_SESSION['role']) 
        && in_array($_SESSION['role'], ['admin', 'manager']); 
        if ($isManager): ?>

    <button class="edit-button" onclick="toggleForm('edit-project-form')">Edit Project</button>
    <form id="edit-project-form" method="POST" action="/updateProject" style="display: none;">
        <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
        
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($project['name']) ?>" required>

        <label>Status:</label>
        <select name="status">
            <option value="Pending" <?= $project['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
            <option value="Active" <?= $project['status'] === 'Active' ? 'selected' : '' ?>>Active</option>
            <option value="Completed" <?= $project['status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
            <option value="On Hold" <?= $project['status'] === 'On Hold' ? 'selected' : '' ?>>On Hold</option>
        </select>

        <label>Description:</label>
        <textarea name="description"><?= htmlspecialchars($project['description']) ?></textarea>

        <button class="save-button" type="submit">Save Changes</button>
    </form>
<?php endif; ?>


    <h2>Team</h2>
        <?php if (empty($teamMembers)): ?>
            <p>No team members assigned.</p>
        <?php else: ?>
            <ul>
                <?php if (!empty($teamMembers['developers'])): ?>
                    <li><strong>Developers:</strong> <?= implode(', ', $teamMembers['developers']) ?></li>
                <?php endif; ?>
                <?php if (!empty($teamMembers['testers'])): ?>
                    <li><strong>Testers:</strong> <?= implode(', ', $teamMembers['testers']) ?></li>
                <?php endif; ?>
                <?php if (!empty($teamMembers['analysts'])): ?>
                    <li><strong>Analysts:</strong> <?= implode(', ', $teamMembers['analysts']) ?></li>
                <?php endif; ?>
                <?php if (!empty($teamMembers['designers'])): ?>
                    <li><strong>Designers:</strong> <?= implode(', ', $teamMembers['designers']) ?></li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>

        <?php 
            $isManager = isset($_SESSION['user_id']) && isset($_SESSION['role']) 
            && in_array($_SESSION['role'], ['admin', 'manager']); 
            if ($isManager): ?>
            <button class="edit-button" onclick="toggleForm('add-team-form')">Add Team Member</button>
            <form id="add-team-form" method="POST" action="/addTeamMember" style="display: none;">
                <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                
                <label>Select User:</label>
                <select name="user_id">
                    <?php foreach ($allUsers as $user): ?>
                        <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['role']) ?>)</option>
                    <?php endforeach; ?>
                </select>

                <button class="save-button" type="submit">Add</button>
            </form>
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

            <?php if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'manager'])): ?>
                <button class="edit-button" onclick="toggleForm('add-task-form')">Add Task</button>
                <form id="add-task-form" method="POST" action="/addTask" class="hidden">
                    <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                    
                    <label>Description:</label>
                    <input type="text" name="description" required>

                    <label>Assign To:</label>
                        <select name="assigned_to">
                            <option value="">Unassigned</option>
                            <?php foreach ($teamMembers as $role => $members): ?>
                                <?php if (!empty($members)): ?>
                                    <optgroup label="<?= ucfirst($role) ?>">
                                        <?php foreach ($members as $memberName): ?>
                                            <option value="<?= htmlspecialchars($memberName) ?>">
                                                <?= htmlspecialchars($memberName) ?> (<?= ucfirst($role) ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>

                    <label>Status:</label>
                    <select name="status">
                        <option value="Pending">Pending</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                    </select>

                    <button class="save-button" type="submit">Add Task</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>