<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Project</title>
    <link rel="stylesheet" href="/css/addProject.css">
</head>
<body>
    <div class="container">
        <a href="/dashboard" class="back-button">Back</a>
        <h1>Add New Project</h1>
        <form method="POST" action="/createProject">
            <label for="name"><strong>Project Name:</strong></label>
            <input type="text" id="name" name="name" required>

            <label for="description"><strong>Description:</strong></label>
            <textarea id="description" name="description" required></textarea>

            <label for="manager_id"><strong>Manager:</strong></label>
            <select id="manager_id" name="manager_id">
                <?php foreach ($managers as $manager): ?>
                    <option value="<?= $manager['id'] ?>"><?= htmlspecialchars($manager['name']) ?></option>
                <?php endforeach; ?>
            </select>

            <label><strong>Team Members:</strong></label>
            <div class="team-members-container">
                <?php foreach ($users as $user): ?>
                    <div class="team-member">
                        <input type="checkbox" id="user_<?= $user['id'] ?>" name="team_members[]" value="<?= $user['id'] ?>">
                        <label for="user_<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?></label>
                        <span class="role"><?= htmlspecialchars($user['role']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <label for="status"><strong>Status:</strong></label>
            <select name="status" id="status">
                <option value="Active">Active</option>
                <option value="Completed">Completed</option>
                <option value="Pending">Pending</option>
                <option value="On Hold">On Hold</option>
            </select>

            <button type="submit">Create Project</button>
        </form>
    </div>
</body>
</html>
